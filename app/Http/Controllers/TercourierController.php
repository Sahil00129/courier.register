<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tercourier;
use App\Models\Sender;
use App\Models\CreateCourier;
use App\Models\CourierCompany;
use App\Models\ForCompany;
use Validator;
use DB;
use URL;
use Helper;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Update_table_data;
use App\Libraries\Sms_lib;
use App\Models\EmployeeBalance;
use App\Models\EmployeeLedgerData;
use App\Models\EmployeeMailTracker;
use App\Models\TerDeductionSettlement;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportTerList;
use App\Exports\ExportTerFullList;
use App\Exports\ExportHandShakeList;
use App\Exports\ExportTerStatusList;
use App\Models\HandoverDetail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\MailnotSent;
use PDF;

date_default_timezone_set('Asia/Kolkata');
ini_set('max_execution_time', -1);

class TercourierController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:tercouriers/create', ['only' => ['create']]);
        $this->middleware('permission:tercouriers', ['only' => ['index']]);
        $this->middleware('permission:tercouriers', ['only' => ['download_ter_list']]);
        $this->middleware('permission:tercouriers', ['only' => ['download_list']]);
        $this->middleware('permission:ter_list_edit_user', ['only' => ['update_ter']]);
        $this->middleware('permission:hr_admin_edit_ter', ['only' => ['admin_update_ter']]);
        $this->middleware('permission:hr_admin_edit_ter', ['only' => ['show_emp_not_exist']]);
        $this->middleware('permission:full-and-final-data', ['only' => ['show_full_and_final_data']]);
        $this->middleware('permission:full-and-final-data', ['only' => ['show_settlement_deduction']]);
        $this->middleware('permission:unit-change', ['only' => ['show_unit_change']]);
        $this->middleware('permission:full-and-final-data', ['only' => ['show_rejected_ter']]);
        $this->middleware('permission:payment_sheet', ['only' => ['payment_sheet']]);
        $this->middleware('permission:document_list', ['only' => ['received_docs']]);
        $this->middleware('permission:update_status', ['only' => ['update_status']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            $query = Tercourier::query();
            $user = Auth::user();
            $data = json_decode(json_encode($user));
            $name = $data->roles[0]->name;
            // echo'<pre>'; print_r($name); die;
            // print_r($name);exit;
            // $role = 'Admin';
            // echo'<pre>'; print_r($name); die;
            $couriers = DB::table('courier_companies')->select('id', 'courier_name')->distinct()->get();
            if ($name === "tr admin" || $name === "Hr Admin") {

                $tercouriers = $query->whereIn('status', ['0', '2', '3', '4', '5', '6', '7', '8', '9', '11', '12', '13'])->with('CourierCompany', 'SenderDetail', 'HandoverDetail')->orderby('id', 'DESC')->paginate(20);
                $role = "Tr Admin";
                // echo'<pre>'; print_r($tercouriers); die;
                // exit;
                // die;
                return view('tercouriers.tercourier-list', ['tercouriers' => $tercouriers, 'role' => $role, 'name' => $name, 'couriers' => $couriers, 'name' => $name]);
            } else {

                $tercouriers = $query->whereIn('status', ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '11', '12', '13'])->with('CourierCompany', 'SenderDetail', 'HandoverDetail')->orderby('id', 'DESC')->paginate(20);
                $role = "reception";
            }
            //    echo'<pre>'; print_r($tercouriers); die;
        }

        return view('tercouriers.tercourier-list', ['tercouriers' => $tercouriers, 'role' => $role, 'name' => $name, 'couriers' => $couriers]);
    }

    public function received_docs()
    {
        // $data = HandoverDetail::where('action_done', '0')->get();
        $data = HandoverDetail::orderby('id', 'DESC')->get();
        $user = Auth::user();
        $user_type = json_decode(json_encode($user));
        $name = $user_type->roles[0]->name;

        // if($name == 'reception')
        // {
        //     $data = HandoverDetail::where(['is_received'=>0])->get();
        // }
        // dd($data);
        return view('tercouriers.handover-list-tercourier', ['handovers' => $data, 'name' => $name]);
    }


    public function update_status()
    {

        $user = Auth::user();
        $user_type = json_decode(json_encode($user));
        $name = $user_type->roles[0]->name;
        return view('tercouriers.update-finfect', ['name' => $name]);
    }

    public function update_unid_status(Request $request)
    {

        $data = $request->all();
        $unique_id = $data['unique_id'];
        $remarks = $data['remarks'];
        $res = Tercourier::where('id', $unique_id)->get();
        if ($res[0]->status == "3") {
            $update = Tercourier::where('id', $unique_id)->update(array(
                'status' => 2, 'sent_to_finfect_date' => "", 'finfect_response' => "", 'refrence_transaction_id' => "", 'final_payable' => "",
                'payable_amount' => "", 'voucher_code' => "", 'super_admin_remarks' => $remarks,
                'updated_at' => date('Y-m-d H:i:s')
            ));

            return $update;
        } else {
            return "not_possible";
        }



        // $res = Tercourier::where('id', $unique_id)->update(array('is_received' => 1, 'action_done' => '1', 'user_id' => $user_id, 'updated_at' => date('Y-m-d H:i:s')));



    }



    public function submit_change_unit(Request $request)
    {

        $data =  $request->all();


        $unique_id = $data['id'];
        $selected_unit = $data['selected_unit'];
        $unit_change_remarks = $data['remarks'];
        $from_date = $data['from_date'];
        $to_date = $data['to_date'];
        $shifting_date = $data['effective_date'];
        $res = Tercourier::where('id', $unique_id)->with('SenderDetail')->get();

        $old_units_data = array();
        $old_units_data['ax_id'] = $res[0]->ax_id;
        $old_units_data['pfu'] = $res[0]->pfu;
        $old_units_data['iag_code'] = $res[0]->iag_code;
        // echo"<pre>";
        // print_r($old_units_data);
        // exit;

        // print_r($res[0]->SenderDetail->ax_id) ;
        // exit;

        if ($selected_unit == "old") {

            $update = Tercourier::where('id', $unique_id)->update(array(
                'status' => 2, 'old_unit' => "old unit used", 'unit_change_remarks' => $unit_change_remarks, 'shifting_date' => $shifting_date,
                'terfrom_date' => $from_date, 'terto_date' => $to_date, 'updated_at' => date('Y-m-d H:i:s')
            ));
        } else if ($selected_unit == "new") {
            $update = Tercourier::where('id', $unique_id)->update(array(
                'status' => 2, 'old_unit' => $old_units_data,
                'ax_id' => $res[0]->SenderDetail->ax_id, 'pfu' => $res[0]->SenderDetail->pfu, 'iag_code' => $res[0]->SenderDetail->iag_code, 'unit_change_remarks' => $unit_change_remarks, 'shifting_date' => $shifting_date,
                'terfrom_date' => $from_date, 'terto_date' => $to_date, 'updated_at' => date('Y-m-d H:i:s')
            ));
        } else {
            $update = 1;
        }



        return $update;
    }






    public function terportal_check(Request $request)
    {

        $data =  $request->all();

        $unique_id = $data['unid'];
        $response = $data['finfect_response'];
        $res = Tercourier::where('id', $unique_id)->get();
        // return $res;
        if ($res[0]->status == "3") {
            EmployeeLedgerData::finfect_failed_payment($unique_id);
            $update = Tercourier::where('id', $unique_id)->update(array(
                'status' => 13, 'sent_to_finfect_date' => "", 'finfect_response' => $response, 'refrence_transaction_id' => "", 'final_payable' => "",
                'payable_amount' => "", 'voucher_code' => "", 'updated_at' => date('Y-m-d H:i:s')
            ));

            return $update;
        } else if ($res[0]->status == "7") {
            EmployeeLedgerData::finfect_failed_payment($unique_id);
            $check_deduction_table = DB::table('ter_deduction_settlements')->where('parent_ter_id', $res[0]->id)->orderby("book_date", "DESC")->first();

            // $settlement_deduction = DB::table('ter_deduction_settlements')->where('id', $check_deduction_table->id)->update([
            //     'status' => 13, 'sent_to_finfect_date' => "", 'finfect_response' => $response, 'reference_transaction_id' => "", 'final_payable' => "",
            //     'payable_amount' => "", 'voucher_code' => "", 'updated_at' => date('Y-m-d H:i:s')
            // ]);
            $settlement_deduction = DB::table('ter_deduction_settlements')->where('id', $check_deduction_table->id)->update([
                'status' => 13, 'finfect_response' => $response, 'updated_at' => date('Y-m-d H:i:s')
            ]);
            if ($settlement_deduction) {
                $ter = DB::table('tercouriers')->where('id', $res[0]->id)->update([
                    'status' => 5, 'updated_at' => date('Y-m-d H:i:s')
                ]);
            }
            return $ter;
        } else {
            return 'Unique ID : ' . $unique_id . ' Status is not Sent to Finfect in TER Portal';
        }





        // $res = Tercourier::where('id', $unique_id)->update(array('is_received' => 1, 'action_done' => '1', 'user_id' => $user_id, 'updated_at' => date('Y-m-d H:i:s')));



    }

    public function accept_handover(Request $request)
    {

        $data = $request->all();
        $handover_id = $data['handover_id'];
        $details = Auth::user();
        $user_id = $details->id;
        $res = HandoverDetail::where('handover_id', $handover_id)->update(array('is_received' => 1, 'action_done' => '1', 'user_id' => $user_id, 'updated_at' => date('Y-m-d H:i:s')));
        if ($res) {
            $get_data = HandoverDetail::where('handover_id', $handover_id)->get();
            $ter_ids = $get_data[0]->ter_ids;
            $explode_ter = explode(',', $ter_ids);
            for ($i = 0; $i < sizeof($explode_ter); $i++) {
                $id = $explode_ter[$i];
                $get_ter_data = Tercourier::where('id', $id)->first();
                $status = $get_ter_data->copy_status;
                $update_data = Tercourier::where('id', $id)->update(array('status' => $status, 'copy_status' => ""));
            }
        }
        return $update_data;
    }

    public static function send_reject_mail($id)
    {
        $get_ter_data = DB::table('tercouriers')->where('id', $id)->get();
        $getsender = Sender::where('employee_id', $get_ter_data[0]->employee_id)->first();

        // $from_date = Helper::ShowFormatDate($get_ter_data[0]->terto_date);
        $rec_date = date_create($get_ter_data[0]->received_date);
        $received_date = date_format($rec_date, "d-F-Y");
        // $get_month = explode("-", $from_date);

        $save_date = date_create($get_ter_data[0]->terto_date);
        $save_last_date = date_format($save_date, "d-F-Y");
        $get_month = explode("-", $save_last_date);
        $ter_month = $get_month[1];
        $ter_year = $get_month[2];

        $data['terdata'] = $get_ter_data[0];
        $data["title"] = "Rejection of TER for " . $ter_month . " month.";
        $date = "";
        $date = date_create($get_ter_data[0]->terto_date);
        date_add($date, date_interval_create_from_date_string("45 days"));
        $data['today_date'] = date('d-m-Y');
        $data['last_ter_date'] = date_format($date, "d-m-Y");
        $diff = strtotime($data['last_ter_date']) - strtotime($data['today_date']);
        $data['date_diff'] = abs(round($diff / 86400));

        // $body = "We have received your TER with UNID ".$id.". You have not mentioned your E.Code. ";
        // $data["email"] = "dhroov.kanwar@eternitysolutions.net";
        $data["email"] = $getsender->official_email_id;

        $data['id'] = $id;
        $data['employee_name'] = $getsender->name;
        $data['employee_id'] = $getsender->employee_id;
        $data['body'] = "This is to inform you that your TER for " . $ter_month . " " . $ter_year . " received on " . $received_date . ". The last date to receive the " . $ter_month . " month claim was within 45 days.";
        $data['body_two'] = "The TER claim is received after 45 days’ and as per policy any claim received after 45 days is rejected and will not be paid.";

        // return  $employee_name;

        // return view('emails.rejectedTER',['date_diff' => $data['date_diff'],'last_ter_date'=> $data['last_ter_date'],'terdata'=> $data['terdata'],'body'=>$data['body'],'body_two'=> $data['body_two'] ,'title'=>$data['title'],'employee_id'=>$data['employee_id'],'employee_name'=>$data['employee_name']]);

        if(!empty($data["email"]) && $data["email"] != 0) {

            Mail::mailer('smtp2')->send('emails.rejectedTer', $data, function ($message) use ($data) {
                $message->to($data["email"], $data["email"])
                    ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                    ->subject($data["title"])
                    ->cc(config('services.cc_email.email_id'));
            });
        } else {
            // dd("f");
            // print_r("DS");
            $mail_not_sent['mail_response'] = 'No Email Found';
            $res = MailnotSent::create($mail_not_sent);
        }
        
        return 1;
    }
    public function reject_handover(Request $request)
    {

        $data = $request->all();
        $handover_id = $data['handover_id'];
        $handover_remarks = $data['handover_remarks'];
        $details = Auth::user();
        $user_id = $details->id;
        $res = HandoverDetail::where('handover_id', $handover_id)->update(array('handover_remarks' => $handover_remarks, 'action_done' => '1', 'user_id' => $user_id, 'reception_action' => '0', 'updated_at' => date('Y-m-d H:i:s')));
        if ($res) {
            $get_data = HandoverDetail::where('handover_id', $handover_id)->get();
            $ter_ids = $get_data[0]->ter_ids;
            $explode_ter = explode(',', $ter_ids);
            for ($i = 0; $i < sizeof($explode_ter); $i++) {
                $id = $explode_ter[$i];
                // $get_ter_data=Tercourier::where('id',$id)->first();
                // $status= $get_ter_data->copy_status;
                $update_data = Tercourier::where('id', $id)->update(array('status' => '1', 'copy_status' => ""));
            }
        }
        return $update_data;
    }


    public function download_ter_list()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $data = json_decode(json_encode($user));
            $name = $data->roles[0]->name;
            if ($name === "tr admin" || $name === "Hr Admin") {
                return 1;
            } else {
                return 2;
            }
        }
    }
    public function get_searched_data(Request $request)
    {
        // ini_set('max_execution_time', -1);
        $data = $request->all();
        $searched_item = trim($data['search_data']);
        $check_status = $searched_item;
        $role = $data['page_role'];
        $flag = 0;
        if (!empty($searched_item)) {

            if ($check_status == '1') {
                $status = 1;
                $flag = 1;
            } else if ($check_status == '2') {
                $status = 2;
                $flag = 1;
            } else if ($check_status == '3') {
                $status = 3;
                $flag = 1;
            } else if ($check_status == '4') {
                $status = 4;
                $flag = 1;
            } else if ($check_status == '5') {
                $status = 5;
                $flag = 1;
            } else if ($check_status == '6') {
                $status = 6;
                $flag = 1;
            } else if ($check_status == '7') {
                $status = 7;
                $flag = 1;
            } else if ($check_status == '8') {
                $status = 8;
                $flag = 1;
            } else if ($check_status == '9') {
                $status = 9;
                $flag = 1;
            } else if ($check_status == '11') {
                $status = 11;
                $flag = 1;
            } else if ($check_status == '12') {
                $status = 12;
                $flag = 1;
            } else if ($check_status == '13') {
                $status = 13;
                $flag = 1;
            } else if ($check_status == 'fail') {
                $status = 0;
                $flag = 1;
            }
            $query = Tercourier::query();
            // return $flag;
            if ($flag) {

                $tercouriers = $query->with('CourierCompany', 'SenderDetail', 'HandoverDetail')
                    ->where('status', $status)->orderby('id', 'DESC')->get();
                return [$tercouriers];
            } else {
                $tercouriers = $query->with('CourierCompany', 'SenderDetail', 'HandoverDetail')
                    ->where('id', 'like', '%' . $searched_item . '%')->orWhere('employee_id', 'like', '%' . $searched_item . '%')->orWhere('ax_id', 'like', '%' . $searched_item . '%')->orWhere('sender_name', 'like', '%' . $searched_item . '%')->orderby('id', 'DESC')->get();
                // dd($tercouriers);
                // return $tercouriers;
                $ter_data = array();
                $j = 0;
                $size = sizeof($tercouriers);

                if ($role != 'reception') {
                    for ($i = 0; $i < $size; $i++) {

                        if (
                            $tercouriers[$i]->status != 1
                        ) {
                            $ter_data[$j] = $tercouriers[$i];
                            //    print_r($j);
                            $j++;
                        }
                    }
                    return [$ter_data];
                } else {

                    return [$tercouriers];
                }
            }
        } else {
            return 'error';
        }
    }

   
    public function get_file_name(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $ter_data = DB::table('tercouriers')->where('id', $id)->get();
        if ($ter_data[0]->status == '7') {
            $get_file_name = DB::table('ter_deduction_settlements')->select('file_name')->where('parent_ter_id', $id)->get();
            $name = $get_file_name[0]->file_name;
        } else {
            $name = $ter_data[0]->file_name;
        }


        return $name;
    }


    public function download_ter_full_list()
    {
        return Excel::download(new ExportTerFullList, 'courier_ter_list.xlsx');
    }

    public function download_status_wise_ter($status)
    {

        return Excel::download(new ExportTerStatusList($status), 'courier_ter_list.xlsx');
    }

    public function hand_shake_report()
    {
        if (Auth::check()) {
            return 1;
        }
    }

    public function download_handshake_report()
    {
        return Excel::download(new ExportHandShakeList, 'hand_shake_report.xlsx');
    }


    public function download_reception_list()
    {
        return Excel::download(new ExportTerList, 'ter_list.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $senders =  DB::table('sender_details')->get();
        $couriers = DB::table('courier_companies')->select('id', 'courier_name')->distinct()->get();
        $categorys = DB::table('catagories')->select('catagories')->distinct()->get();
        $forcompany = DB::table('for_companies')->select('for_company')->distinct()->get();
        //$lastdate = DB::table('tercouriers')->select('date_of_receipt')->latest()->distinct();
        $lastdate = DB::table('tercouriers')->select('date_of_receipt', 'docket_no')->orderby('id', 'desc')->first();
        //echo'<pre>'; print_r($lastdate);die;
        return view('tercouriers.create-tercourier',  ['senders' => $senders, 'couriers' => $couriers, 'categorys' => $categorys, 'forcompany' => $forcompany, 'lastdate' => $lastdate]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // echo'<pre>'; print_r($request->all()); die;
        $rules = array(
            // 'name' => 'required',
            // 'phone' => 'required|unique:drivers',

        );
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $errors                  = $validator->errors();
            $response['success']     = false;
            $response['validation']  = false;
            $response['formErrors']  = true;
            $response['errors']      = $errors;
            return response()->json($response);
        }

        // return $request->timeTaken;
        // $terdata=array();
        // $ter_data['recp_entry_time'] = $request->timeTaken;
        // echo "<pre>";print_r($ter_data);die;

        $details = Auth::user();
        $terdata['saved_by_name'] = $details->name;
        $terdata['saved_by_id'] = $details->id;
        $terdata['employee_id']    = $request->sender_id;
        $terdata['recp_entry_time'] = $request->timeTaken;
        // return $terdata['employee_id'];
        $terdata['date_of_receipt'] = $request->date_of_receipt;
        $terdata['courier_id']  = $request->courier_id;
        $terdata['docket_no']   = $request->docket_no;
        $terdata['docket_date'] = $request->docket_date;
        $terdata['location']    = $request->location;
        $terdata['company_name'] = $request->company_name;
        $terdata['details'] = $request->details;
        $terdata['amount'] = $request->amount;
        $terdata['remarks'] = $request->remarks;
        $terdata['given_to'] = $request->given_to;
        $terdata['delivery_date'] = $request->delivery_date;
        $terdata['received_date'] = date('Y-m-d');
        $terdata['status'] = 1;

        if ($request->terfrom_date && $request->terto_date) {
            $terdata['terfrom_date'] = $request->terfrom_date;
            $terdata['terto_date'] = $request->terto_date;
        } else {
            $terdata['terfrom_date'] = $request->terfrom_date1;
            $terdata['terto_date'] = $request->terto_date1;
        }



        $senders =  DB::table('sender_details')->where('employee_id', $terdata['employee_id'])->get()->toArray();

        $terdata['ax_id']    = $senders[0]->ax_id;


        $terdata['iag_code']  = $senders[0]->iag_code;
        $terdata['pfu'] = $senders[0]->pfu;
        $terdata['sender_id'] = $senders[0]->id;
        $terdata['sender_name']  = $senders[0]->name;

        $designation_check = strtolower($senders[0]->designation);

        if (
            $designation_check == 'market development representative' ||
            $designation_check == 'field executive'
            || $designation_check == 'project officer'
        ) {
            return "UNID can't generate for this Employee Designation";
        }

        if ($terdata['ax_id'] != 0 && $terdata['sender_name'] != "Unknown Employee") {

            if (empty($terdata['ax_id']) && empty($terdata['iag_code'])) {
                return "Both IAG Code and AX-ID Missing";
            }
        }
        

     
        // echo "<pre>";print_r($ter_data);die;

        $tercourier = Tercourier::create($terdata);
        // dd($tercourier);
        if ($tercourier) {
            $type =     config('services.finfect_key.finfect_url');
            if ($type == "https://stagging.finfect.biz/api/non_finvendors_payments") {
                // return "hello";
                $response['success'] = true;
                $response['messages'] = 'Succesfully Submitted';
                $response['redirect_url'] = URL::to('/tercouriers');
                return Response::json($response);
            }
            //    exit;

            $date = date_create($terdata['terfrom_date']);
            date_add($date, date_interval_create_from_date_string("50 days"));
            $date_check = date_format($date, "Y-m-d");
          

            $today_date = date('Y-m-d');
            
            if ($today_date >= $date_check) {
                   self::send_reject_mail($tercourier->id);
            }
          

            $getsender = Sender::where('id', $terdata['sender_id'])->first();

            $API = "cBQcckyrO0Sib5k7y9eUDw"; // GET Key from SMS Provider
            $peid = "1201159713185947382"; // Get Key from DLT
            $sender_id = "FAPLHR"; // Approved from DLT
            $mob = $getsender->telephone_no; // Get Mobile Number from Sender
            $name = $getsender->name;
            // print_r($getsender);
            // exit;

            $from_period = Helper::ShowFormat($tercourier->terfrom_date);
            $to_period = Helper::ShowFormat($tercourier->terto_date);

            $UNID = $tercourier->id;
            $umsg = "Dear $name , your TER for Period $from_period to $to_period has been received and is under process. TER UNID is $UNID Thanks! Frontiers";

            $url = 'http://sms.innuvissolutions.com/api/mt/SendSMS?APIkey=' . $API . '&senderid=' . $sender_id . '&channel=Trans&DCS=0&flashsms=0&number=' . urlencode($mob) . '&text=' . urlencode($umsg) . '&route=2&peid=' . urlencode($peid) . '';

            $this->SendTSMS($url);

            $response['success'] = true;
            $response['messages'] = 'Succesfully Submitted';
            $response['redirect_url'] = URL::to('/tercouriers');
        } else {
            $response['success'] = false;
            $response['messages'] = 'Can not created TER Courier please try again';
        }
        return Response::json($response);
    }

    public function SendTSMS($hostUrl)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $hostUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0); // change to 1 to verify cert
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
        $result = curl_exec($ch);
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function check_finfect_status()
    {
        ini_set('max_execution_time', 0); // 0 = Unlimited
        $get_data_db = DB::table('tercouriers')->select('id')->where('status', 3)->where('refrence_transaction_id', NULL)->where('finfect_response', NULL)->get()->toArray();
        if (empty($get_data_db)) {
            $get_data_db = DB::table('tercouriers')->select('id')->where('status', 3)->where('refrence_transaction_id', NULL)->get()->toArray();
        }
        // echo "<pre>";
        // print_r($get_data_db);
        // exit;
        $size = sizeof($get_data_db);
        // $size=3;
        // return $get_data_db;
        for ($i = 0; $i < $size; $i++) {
            // print_r($get_data_db[$i]->id);
            $id = $get_data_db[$i]->id;
            // echo "<pre>";
            // print_r($id);
            // $id="2577";

            $url = 'https://stagging.finfect.biz/api/check_refrence/' . $id;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            $res = json_decode($response);

            curl_close($curl);
            // echo"<pre>";
            // print_r($res);
            // exit;
            if ($res->status == "success") {
                $date = date("d-m-Y h:m a");
                $sent_to_finfect_date = date("Y-m-d");


                $update_ter_data = DB::table('tercouriers')->where('id', $get_data_db[$i]->id)->update([
                    'status' => 3, 'finfect_response' => $res->status,
                    'refrence_transaction_id' => $res->refrence_transaction_id, 'updated_at' => $date,
                    'sent_to_finfect_date' => $sent_to_finfect_date
                ]);
            } else {
                $update_ter_data = DB::table('tercouriers')->where('id',  $get_data_db[$i]->id)->update(array(
                    'finfect_response' => $res->status, 'payment_status' => 2,
                    'status' => 0,  'sent_to_finfect_date' => $sent_to_finfect_date
                ));
            }
        }
        // return 1;
    }

    public function addTrRow()
    {
        if (isset($_REQUEST['action']) and $_REQUEST['action'] == "addDataRow") {
            $senders =  DB::table('sender_details')->get();
            $couriers = DB::table('courier_companies')->select('id', 'courier_name')->distinct()->get();

            $decode  = json_decode(json_encode($senders));
            $decode_couriers  = json_decode(json_encode($couriers));
            //echo "<pre>";print_r($decode);die;
?>
            <tr>
                <td></td>
                <td></td>
                <td>
                    <input type="date" class="form-control" name="date_of_receipt" id="date_of_receipt" Required>
                </td>
                <td colspan="3">
                    <select class="form-control  basic" name="sender_id" id="select_employee">
                        <option selected disabled>search..</option>
                        <?php
                        foreach ($decode as $sender) { ?>
                            <option value="<?= $sender->id ?>"><?= $sender->name ?> : <?= $sender->ax_id ?> : <?= $sender->employee_id ?></option>
                        <?php
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" id="location" name="location" Required>
                </td>
                <td>
                    <select id="for" name="company_name" class="form-control" onchange="receveCheck(this);">
                        <option selected disabled>Select...</option>
                        <option value="FMC">FMC</option>
                        <option value="Corteva">Corteva</option>
                        <option value="Unit-HSB">Unit-HSB</option>
                        <option value="Remainco">Remainco</option>
                    </select>
                </td>
                <td>
                    <input type="text" class="form-control" id="amount" name="amount" Required>
                </td>
                <td><input type="date" class="form-control" id="terfrom_date" name="terfrom_date" Required></td>
                <td><input type="date" class="form-control" id="terto_date" name="terto_date" Required></td>
                <td><input type="text" class="form-control" id="details" name="details"></td>
                <td width=""><textarea name="remarks" id="remarks" placeholder="" class="form-control" rows="1" cols=""></textarea></td>
                <td>
                    <select style="padding:6px 0px 8px 0px;" class="form-control" id="given_to" name="given_to">
                        <!-- <option value="">Select</option> -->
                        <option value="Veena">Veena</option>
                    </select>
                </td>
                <td><input type="date" class="form-control" id="delivery_date" name="delivery_date"></td>
                <td>
                    <select id="slct" name="courier_id" class="form-control" onchange="yesnoCheck(this);">
                        <option selected disabled>Select..</option>
                        <?php
                        foreach ($decode_couriers as $courier) { ?>
                            <option value="<?= $courier->id ?>"><?= $courier->courier_name ?></option>
                        <?php
                        }
                        ?>
                        <option>Other</option>
                    </select>
                </td>
                <td><input type="text" class="form-control" placeholder="Docket No" id="docket_no" name="docket_no" autocomplete="off"></td>
                <td><input type="date" placeholder="Docket Date" class="form-control" id="docket_date" name="docket_date"></td>
            </tr>
            <tr>
                <th>UN ID</th>
                <th>Status</th>
                <th>Date of Receipt</th>
                <th>Sender Name</th>
                <th>AX ID</th>
                <th>Employee ID</th>
                <th>Location</th>
                <th>Company Name</th>
                <th>TER Amount</th>
                <th>TER Period From</th>
                <th>TER Period To</th>
                <th>Other Details</th>
                <th width="200px;">Remarks</th>
                <th>Given To</th>
                <th>Handover Date</th>
                <th>Courier Name</th>
                <th>Docket No</th>
                <th>Docket Date</th>
                <!-- <th class="dt-no-sorting">Actions</th> -->
            </tr>
<?php
            echo '|***|addmore';
        }
    }

    public function createRow(Request $request)
    {
        // echo'<pre>'; print_r($request->all()); die;
        $terdata['sender_id']    = $request->select_employee;
        $terdata['date_of_receipt'] = $request->date;
        $terdata['courier_id']  = $request->slct;
        $terdata['docket_no']   = $request->docket_no;
        $terdata['docket_date'] = $request->docket_date;
        $terdata['location']    = $request->location;
        $terdata['company_name'] = $request->company_name;
        $terdata['terfrom_date'] = $request->terfrom_date;
        $terdata['terto_date'] = $request->terto_date;
        $terdata['details'] = $request->details;
        $terdata['amount'] = $request->amount;
        $terdata['remarks'] = $request->remarks;
        $terdata['given_to'] = $request->given_to;
        $terdata['delivery_date'] = $request->delivery_date;
        $terdata['status'] = '1';

        $tercourier = Tercourier::create($terdata);
        if ($tercourier) {
            $response['success'] = true;
            $response['messages'] = 'Succesfully Submitted';
            $response['redirect_url'] = URL::to('/tercouriers');
        } else {
            $response['success'] = false;
            $response['messages'] = 'Can not created TER Courier please try again';
        }
        return Response::json($response);
    }

    // get Employees on change
    public function getEmployees(Request $request)
    {
        $getempoloyees = Sender::where('employee_id', $request->emp_id)->first();
        if ($getempoloyees) {
            $response['success']         = true;
            $response['success_message'] = "Employees list fetch successfully";
            $response['error']           = false;
            $response['data']            = $getempoloyees;
        } else {
            $response['success']         = false;
            $response['error_message']   = "Employee Id does not exist";
            $response['error']           = true;
        }
        return response()->json($response);
    }

    public function terBundles(Request $request)
    {
        $query = Tercourier::query();
        $tercouriers = $query->with('CourierCompany', 'SenderDetail')->orderby('id', 'DESC')->get();
        return view('tercouriers.terbundles-list', ['tercouriers' => $tercouriers]);
    }


    // Dhruv code
    public function change_status_to_handover(Request $request)
    {
        // return 'hello'; die;
        $data = $request->all();
        $new_data = explode("|", $data['selected_value']);
        $details = Auth::user();
        $log_in_user_name = $details->name;
        $log_in_user_id = $details->id;
        $info = Tercourier::get_details_of_employee($new_data, $log_in_user_id, $log_in_user_name);
        // $info=Tercourier::get_details_of_employee($data['selected_value']);
        return $info;
    }

    public function add_details_to_DB(Request $request)
    {
        // return [$amount,$voucher_code];
        $data = $request->all();
        $voucher_code = $data['coupon_code'];
        $amount = $data['amount'];
        $id = $data['selected_id'];
        if (Auth::check()) {
            $user = Auth::user()->roles()->get();
            $data = json_decode(json_encode($user));

            $details = Auth::user();
            $log_in_user_name = $details->name;
            $log_in_user_id = $details->id;

            $name = $data[0]->name;
            if ($name === "tr admin") {
                $add_data = Tercourier::add_data($voucher_code, $amount, $id, $log_in_user_id, $log_in_user_name);
                return $add_data;
            } else {
                return "You don't have rights for this step";
            }
            // else
            // {
            //     $tercouriers = $query->with('CourierCompany','SenderDetail')->orderby('id','DESC')->get();
            // }
            //    echo'<pre>'; print_r(); die;
            // return [$amount,$voucher_code];
        }
    }

    public function add_multi_details_to_DB(Request $request)
    {
        $data = $request->all();
        $voucher_code = explode("|", $data['coupon_code']);
        $amount = explode("|", $data['amount']);
        $id = explode("|", $data['selected_id']);
        $details = Auth::user();
        $log_in_user_name = $details->name;
        $log_in_user_id = $details->id;
        $add_multiple_data = Tercourier::add_multiple_data($voucher_code, $amount, $id, $log_in_user_id, $log_in_user_name);
        return $add_multiple_data;
    }

    public function update_ter($id)
    {
        return view('tercouriers.update-tercourier', ['unique_id' => $id]);
        // if($id == '0')
        // {
        //     return view('tercouriers.update-tercourier');

        // }else{
        //     return view('tercouriers.update-tercourier', ['unique_id' => $id]);
        // }

    }

    public function admin_update_ter($id)
    {
        return view('tercouriers.admin-update-tercourier', ['unique_id' => $id]);
    }


    public function payment_sheet()
    {
        return view('tercouriers.open-payment-sheet');
    }


    //     public function check_paid_status()
    //     {
    //         // ini_set('max_execution_time', 0); // 0 = Unlimited
    //         // $get_data_db = DB::table('tercouriers')->where('status', 3)->get()->toArray();
    //         // $size = sizeof($get_data_db);
    //         // $size=3;
    //         // return $get_data_db;
    //         // for ($i = 0; $i < $size; $i++) {
    //             // print_r($get_data_db[$i]->id);
    //             // $id = $get_data_db[$i]->id;
    //             $id="1508";
    //             $url = 'https://finfect.biz/api/get_payment_response/' . $id;
    //             $curl = curl_init();

    //             curl_setopt_array($curl, array(
    //                 CURLOPT_URL => $url,
    //                 CURLOPT_RETURNTRANSFER => true,
    //                 CURLOPT_ENCODING => '',
    //                 CURLOPT_MAXREDIRS => 10,
    //                 CURLOPT_TIMEOUT => 0,
    //                 CURLOPT_FOLLOWLOCATION => true,
    //                 CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //                 CURLOPT_CUSTOMREQUEST => 'GET',
    //             ));

    //             $response = curl_exec($curl);

    //             curl_close($curl);
    //             if ($response) {
    //                 $received_data = json_decode($response);
    //                 $status_code = $received_data->status_code;

    //                 if ($status_code == 2) {
    //                     $update_ter_data = DB::table('tercouriers')->where('id', '1919')->update([
    //                         'status' => 5, 'finfect_response' => 'Paid',
    //                         'utr' => $received_data->bank_refrence_no, 'updated_at' => date('Y-m-d H:i:s'),
    //                         'paid_date' => date('Y-m-d')
    //                     ]);

    //                     if ($update_ter_data) {
    // // My Code for updating ledger
    //                    $ter_id='1919';
    //                    $res= EmployeeLedgerData::finfect_paid_payment($ter_id);
    //                    return $res;

    //                     }
    //                     // return $res;
    //                 }
    //             }
    //         // }
    //         return 1;
    //     }


    public static function send_payment_advice($id)
    {

        $terdata = DB::table('tercouriers')->where('id', $id)->get();
        $sender_details = DB::table('sender_details')->where('employee_id', $terdata[0]->employee_id)->get();
        if (!empty($terdata[0]->deduction_options)) {
            $dedution_selected = explode(',', $terdata[0]->deduction_options);
        } else {
            $dedution_selected = "";
        }

        if (!empty($terdata[0]->advance_used)) {
            $advance_money = $terdata[0]->advance_used;
        } else {
            $advance_money = "";
        }

        $pay_array = json_decode($terdata[0]->payable_amount);
        $payable_sum = 0;
        for ($i = 0; $i < sizeof($pay_array); $i++) {
            $payable_sum = $payable_sum + $pay_array[$i];
        }

        //    return  view('pdf.paymentadvice',['terdata'=> $terdata,'payable_sum'=>$payable_sum,'dedution_selected'=>$dedution_selected,'sender_details'=>$sender_details,
        //    'advance_money'=>$advance_money]);

        $pdf = PDF::loadView('pdf.paymentadvice', [
            'terdata' => $terdata, 'payable_sum' => $payable_sum, 'dedution_selected' => $dedution_selected, 'sender_details' => $sender_details,
            'advance_money' => $advance_money
        ]);
        // return $pdf->download('invoice.pdf');

        $paid_date = Helper::ShowFormatDate($terdata[0]->paid_date);

        $data["title"] = "Payment Advice for Paid TER UNID " . $id;
        $data["body"] = "We have released TER payment in your account on " . $paid_date . " as per details attached. ";
        // $data["email"] = "dhroov.kanwar@eternitysolutions.net";
        $data["email"] = $sender_details[0]->official_email_id;
        $data['employee_id'] = $terdata[0]->employee_id;
        $data['employee_name'] = $terdata[0]->sender_name;
        $data['id'] = $id;


        if(!empty($data["email"]) && $data["email"] != 0) {


        Mail::mailer('smtp2')->send('emails.payadvicemail', $data, function ($message) use ($data, $pdf) {
            $message->to($data["email"], $data["email"])
                ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                ->subject($data["title"])
                ->attachData($pdf->output(), "payment_advice_" . $data['id'] . ".pdf");
        });
    }
    else {
        // dd("f");
        // print_r("DS");
        $mail_not_sent['mail_response'] ='No Email Id Found';
        $res = MailnotSent::create($mail_not_sent);
    }
    }


    public function check_email_trigger()
    {

        $live_host_name = request()->getHttpHost();
        // $live_host_name="ds";

        if ($live_host_name == 'localhost:8000' || $live_host_name == "test-courier.easemyorder.com") {
            return "not possible";
        } else {
            $today_date = date('Y-m-d');
            $received_ids_arr = array();
            $rejected_ids_arr = array();
            $sent_to_finfect_arr = array();
            $payment_failed_arr = array();
            $pay_later_arr = array();
            $full_n_final_arr = array();
            $handover_ids_arr_1=array();
            $handover_ids_arr_2=array();
            $handover_ids_arr_3=array();
            $handover_ids_arr_4=array();
            $finfect_ids_arr_1 = array();
            $finfect_ids_arr_2 = array();
            $finfect_ids_arr_3 = array();
            $rejected_ids_arr_1 = array();
            $rejected_ids_arr_2 = array();
            $rejected_ids_arr_3 = array();
            $pay_later_ids_arr_1 = array();
            $pay_later_ids_arr_2 = array();
            $full_n_final_ids_arr_1 = array();
            $full_n_final_ids_arr_2 = array();
            $unknown_ids_arr_1 = array();
            $unknown_ids_arr_2 = array();



            




            $check_received_email = Tercourier::where('status', 1)->whereDate('received_date', '<', $today_date)->get();
            // echo "<pre>";
            for ($i = 0; $i < sizeof($check_received_email); $i++) {
                $received_ids_arr[] = $check_received_email[$i]->id;
            }

                $date = date_create($today_date);
                date_add($date, date_interval_create_from_date_string("-3 days"));
                $date_check = date_format($date, "Y-m-d");
                

                $check_handover_email =  Tercourier::whereBetween('handover_date', [$date_check,$today_date])->where('status', 2)->where('ter_type',2)->get();
                
                $check_SD1_h1_count =  Tercourier::whereBetween('handover_date', [$date_check,$today_date])->where('status', 2)->where('ter_type',2)->where('pfu','SD1')->count();

                $check_MA2_h1_count =  Tercourier::whereBetween('handover_date', [$date_check,$today_date])->where('status', 2)->where('ter_type',2)->where('pfu','MA2')->count();

                $check_SD3_h1_count =  Tercourier::whereBetween('handover_date', [$date_check,$today_date])->where('status', 2)->where('ter_type',2)->where('pfu','SD3')->count();

                $check_MA4_h1_count =  Tercourier::whereBetween('handover_date', [$date_check,$today_date])->where('status', 2)->where('ter_type',2)->where('pfu','MA4')->count();

                $total_h1_count = $check_SD1_h1_count + $check_MA2_h1_count + $check_SD3_h1_count + $check_MA4_h1_count;



                for ($i = 0; $i < sizeof($check_handover_email); $i++) {
                    $handover_ids_arr_1[] = $check_handover_email[$i]->id;
                }


            

                $check_handover_email = "";



                $date = date_create($today_date);
                date_add($date, date_interval_create_from_date_string("-7 days"));
                $from = date_format($date, "Y-m-d");

            
                $date = date_create($today_date);
                date_add($date, date_interval_create_from_date_string("-4 days"));
                $to = date_format($date, "Y-m-d");

            

                $check_handover_email =  Tercourier::whereBetween('handover_date', [$from, $to])->where('status', 2)->where('ter_type',2)->get();
                                
                $check_SD1_h2_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 2)->where('ter_type',2)->where('pfu','SD1')->count();

                $check_MA2_h2_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 2)->where('ter_type',2)->where('pfu','MA2')->count();

                $check_SD3_h2_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 2)->where('ter_type',2)->where('pfu','SD3')->count();

                $check_MA4_h2_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 2)->where('ter_type',2)->where('pfu','MA4')->count();

                $total_h2_count = $check_SD1_h2_count + $check_MA2_h2_count + $check_SD3_h2_count + $check_MA4_h2_count;

               

                for ($i = 0; $i < sizeof($check_handover_email); $i++) {
                    $handover_ids_arr_2[] = $check_handover_email[$i]->id;
                }




                $check_handover_email = "";


                $date = date_create($today_date);
                date_add($date, date_interval_create_from_date_string("-30 days"));
                $from = date_format($date, "Y-m-d");

                $date = date_create($today_date);
                date_add($date, date_interval_create_from_date_string("-7 days"));
                $to = date_format($date, "Y-m-d");

            

                $check_handover_email =  Tercourier::whereBetween('handover_date', [$from, $to])->where('status', 2)->where('ter_type',2)->get();
               
                $check_SD1_h3_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 2)->where('ter_type',2)->where('pfu','SD1')->count();

                $check_MA2_h3_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 2)->where('ter_type',2)->where('pfu','MA2')->count();

                $check_SD3_h3_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 2)->where('ter_type',2)->where('pfu','SD3')->count();

                $check_MA4_h3_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 2)->where('ter_type',2)->where('pfu','MA4')->count();

                $total_h3_count = $check_SD1_h3_count + $check_MA2_h3_count + $check_SD3_h3_count + $check_MA4_h3_count;

                // return [$total_h3_count,sizeof($check_handover_email)];

                for ($i = 0; $i < sizeof($check_handover_email); $i++) {
                    $handover_ids_arr_3[] = $check_handover_email[$i]->id;
                }

                $check_handover_email = "";


                $date = date_create($today_date);
                date_add($date, date_interval_create_from_date_string("-30 days"));
                $to = date_format($date, "Y-m-d");

                $check_handover_email =  Tercourier::whereDate('handover_date','<', $to)->where('status', 2)->where('ter_type',2)->get();
              
                $check_SD1_h4_count =  Tercourier::whereDate('handover_date','<', $to)->where('status', 2)->where('ter_type',2)->where('pfu','SD1')->count();

                $check_MA2_h4_count =  Tercourier::whereDate('handover_date','<', $to)->where('status', 2)->where('ter_type',2)->where('pfu','MA2')->count();

                $check_SD3_h4_count =  Tercourier::whereDate('handover_date','<', $to)->where('status', 2)->where('ter_type',2)->where('pfu','SD3')->count();

                $check_MA4_h4_count =  Tercourier::whereDate('handover_date','<', $to)->where('status', 2)->where('ter_type',2)->where('pfu','MA4')->count();

                $total_h4_count = $check_SD1_h4_count + $check_MA2_h4_count + $check_SD3_h4_count + $check_MA4_h4_count;



                for ($i = 0; $i < sizeof($check_handover_email); $i++) {
                    $handover_ids_arr_4[] = $check_handover_email[$i]->id;
                }


            
            // Finfect 
            $date = date_create($today_date);
            date_add($date, date_interval_create_from_date_string("-1 days"));
            $from = date_format($date, "Y-m-d");
            $to=$today_date;

            $check_finfect_email = Tercourier::where('status', 3)->whereBetween('sent_to_finfect_date', [$from,$to])->where('ter_type',2)->get();
            // echo "<pre>";
            for ($i = 0; $i < sizeof($check_finfect_email); $i++) {
                $finfect_ids_arr_1[] = $check_finfect_email[$i]->id;
            }
            $check_SD1_f1_count =  Tercourier::whereBetween('sent_to_finfect_date', [$from,$to])->where('status', 3)->where('ter_type',2)->where('pfu','SD1')->count();
            $check_MA2_f1_count =  Tercourier::whereBetween('sent_to_finfect_date', [$from,$to])->where('status', 3)->where('ter_type',2)->where('pfu','MA2')->count();
            $check_SD3_f1_count =  Tercourier::whereBetween('sent_to_finfect_date', [$from,$to])->where('status', 3)->where('ter_type',2)->where('pfu','SD3')->count();
            $check_MA4_f1_count =  Tercourier::whereBetween('sent_to_finfect_date', [$from,$to])->where('status', 3)->where('ter_type',2)->where('pfu','MA4')->count();
            $total_f1_count = $check_SD1_f1_count + $check_MA2_f1_count + $check_SD3_f1_count + $check_MA4_f1_count;


            // 2ND
            $check_finfect_email ="";
            $date = date_create($today_date);
            date_add($date, date_interval_create_from_date_string("-2 days"));
            $from = date_format($date, "Y-m-d");
           
            $date_2 = date_create($today_date);
            date_add($date_2, date_interval_create_from_date_string("-1 days"));
            $to = date_format($date_2, "Y-m-d");

            $check_finfect_email = Tercourier::where('status', 3)->whereBetween('sent_to_finfect_date', [$from,$to])->where('ter_type',2)->get();
            // echo "<pre>";
            for ($i = 0; $i < sizeof($check_finfect_email); $i++) {
                $finfect_ids_arr_2[] = $check_finfect_email[$i]->id;
            }
            $check_SD1_f2_count =  Tercourier::whereBetween('sent_to_finfect_date', [$from,$to])->where('status', 3)->where('ter_type',2)->where('pfu','SD1')->count();
            $check_MA2_f2_count =  Tercourier::whereBetween('sent_to_finfect_date', [$from,$to])->where('status', 3)->where('ter_type',2)->where('pfu','MA2')->count();
            $check_SD3_f2_count =  Tercourier::whereBetween('sent_to_finfect_date', [$from,$to])->where('status', 3)->where('ter_type',2)->where('pfu','SD3')->count();
            $check_MA4_f2_count =  Tercourier::whereBetween('sent_to_finfect_date', [$from,$to])->where('status', 3)->where('ter_type',2)->where('pfu','MA4')->count();
            $total_f2_count = $check_SD1_f2_count + $check_MA2_f2_count + $check_SD3_f2_count + $check_MA4_f2_count;

            // 3rd
            $check_finfect_email ="";
        
           
            $date_2 = date_create($today_date);
            date_add($date_2, date_interval_create_from_date_string("-2 days"));
            $to = date_format($date_2, "Y-m-d");

            $check_finfect_email = Tercourier::where('status', 3)->whereDate('sent_to_finfect_date','<' ,$to)->where('ter_type',2)->get();
            // echo "<pre>";
            for ($i = 0; $i < sizeof($check_finfect_email); $i++) {
                $finfect_ids_arr_3[] = $check_finfect_email[$i]->id;
            }
            $check_SD1_f3_count =  Tercourier::whereDate('sent_to_finfect_date','<' ,$to)->where('status', 3)->where('ter_type',2)->where('pfu','SD1')->count();
            $check_MA2_f3_count =  Tercourier::whereDate('sent_to_finfect_date','<' ,$to)->where('status', 3)->where('ter_type',2)->where('pfu','MA2')->count();
            $check_SD3_f3_count =  Tercourier::whereDate('sent_to_finfect_date','<' ,$to)->where('status', 3)->where('ter_type',2)->where('pfu','SD3')->count();
            $check_MA4_f3_count =  Tercourier::whereDate('sent_to_finfect_date','<' ,$to)->where('status', 3)->where('ter_type',2)->where('pfu','MA4')->count();
            $total_f3_count = $check_SD1_f3_count + $check_MA2_f3_count + $check_SD3_f3_count + $check_MA4_f3_count;


            // Rejected

                
        
            $date = date_create($today_date);
            date_add($date, date_interval_create_from_date_string("-1 days"));
            $from = date_format($date, "Y-m-d");
            $to=$today_date;


            $check_reject_email = Tercourier::where('status', 8)->whereBetween('handover_date', [$from,$to])->where('ter_type',2)->get();
            // echo "<pre>";

            for ($i = 0; $i < sizeof($check_reject_email); $i++) {
                $rejected_ids_arr_1[] = $check_reject_email[$i]->id;
            }
            $check_SD1_r1_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 8)->where('ter_type',2)->where('pfu','SD1')->count();
            $check_MA2_r1_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 8)->where('ter_type',2)->where('pfu','MA2')->count();
            $check_SD3_r1_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 8)->where('ter_type',2)->where('pfu','SD3')->count();
            $check_MA4_r1_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 8)->where('ter_type',2)->where('pfu','MA4')->count();
            $total_r1_count = $check_SD1_r1_count + $check_MA2_r1_count + $check_SD3_r1_count + $check_MA4_r1_count;

             // 2ND
             $check_reject_email ="";
             $date = date_create($today_date);
             date_add($date, date_interval_create_from_date_string("-2 days"));
             $from = date_format($date, "Y-m-d");
            
             $date_2 = date_create($today_date);
             date_add($date_2, date_interval_create_from_date_string("-1 days"));
             $to = date_format($date_2, "Y-m-d");

             $check_reject_email = Tercourier::where('status', 8)->whereBetween('handover_date', [$from,$to])->where('ter_type',2)->get();
             // echo "<pre>";
 
             for ($i = 0; $i < sizeof($check_reject_email); $i++) {
                 $rejected_ids_arr_2[] = $check_reject_email[$i]->id;
             }
             $check_SD1_r2_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 8)->where('ter_type',2)->where('pfu','SD1')->count();
             $check_MA2_r2_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 8)->where('ter_type',2)->where('pfu','MA2')->count();
             $check_SD3_r2_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 8)->where('ter_type',2)->where('pfu','SD3')->count();
             $check_MA4_r2_count =  Tercourier::whereBetween('handover_date', [$from,$to])->where('status', 8)->where('ter_type',2)->where('pfu','MA4')->count();
             $total_r2_count = $check_SD1_r2_count + $check_MA2_r2_count + $check_SD3_r2_count + $check_MA4_r2_count;


               // 3rd
            $check_reject_email ="";
        
           
            $date_2 = date_create($today_date);
            date_add($date_2, date_interval_create_from_date_string("-2 days"));
            $to = date_format($date_2, "Y-m-d");

            $check_reject_email = Tercourier::where('status', 8)->whereDate('handover_date','<',$to)->where('ter_type',2)->get();
            // echo "<pre>";

            for ($i = 0; $i < sizeof($check_reject_email); $i++) {
                $rejected_ids_arr_3[] = $check_reject_email[$i]->id;
            }
            $check_SD1_r3_count =  Tercourier::whereDate('handover_date','<',$to)->where('status', 8)->where('ter_type',2)->where('pfu','SD1')->count();
            $check_MA2_r3_count =  Tercourier::whereDate('handover_date','<',$to)->where('status', 8)->where('ter_type',2)->where('pfu','MA2')->count();
            $check_SD3_r3_count =  Tercourier::whereDate('handover_date','<',$to)->where('status', 8)->where('ter_type',2)->where('pfu','SD3')->count();
            $check_MA4_r3_count =  Tercourier::whereDate('handover_date','<',$to)->where('status', 8)->where('ter_type',2)->where('pfu','MA4')->count();
            $total_r3_count = $check_SD1_r3_count + $check_MA2_r3_count + $check_SD3_r3_count + $check_MA4_r3_count;


            // Pay Later

            // 1st

            $date = date_create($today_date);
            date_add($date, date_interval_create_from_date_string("-7 days"));
            $from = date_format($date, "Y-m-d");
            $to = $today_date;

            $check_paylater_email = Tercourier::where('status', 4)->where('payment_status', 2)->whereBetween('verify_ter_date', [$from,$to])->where('ter_type',2)->get();
            // echo "<pre>";
            for ($i = 0; $i < sizeof($check_paylater_email); $i++) {
                $pay_later_ids_arr_1[] = $check_paylater_email[$i]->id;
            }
            $check_SD1_pl1_count =  Tercourier::where('status', 4)->where('payment_status', 2)->whereBetween('verify_ter_date', [$from,$to])->where('ter_type',2)->where('pfu','SD1')->count();
            $check_MA2_pl1_count =  Tercourier::where('status', 4)->where('payment_status', 2)->whereBetween('verify_ter_date', [$from,$to])->where('ter_type',2)->where('pfu','MA2')->count();
            $check_SD3_pl1_count =  Tercourier::where('status', 4)->where('payment_status', 2)->whereBetween('verify_ter_date', [$from,$to])->where('ter_type',2)->where('pfu','SD3')->count();
            $check_MA4_pl1_count =  Tercourier::where('status', 4)->where('payment_status', 2)->whereBetween('verify_ter_date', [$from,$to])->where('ter_type',2)->where('pfu','MA4')->count();
            $total_pl1_count = $check_SD1_pl1_count + $check_MA2_pl1_count + $check_SD3_pl1_count + $check_MA4_pl1_count;
             

            // 2nd 
            $check_paylater_email="";
            $date = date_create($today_date);
            date_add($date, date_interval_create_from_date_string("-7 days"));
            $to = date_format($date, "Y-m-d");
          

            $check_paylater_email = Tercourier::where('status', 4)->where('payment_status', 2)->whereDate('verify_ter_date','<',$to)->where('ter_type',2)->get();
            // echo "<pre>";
            for ($i = 0; $i < sizeof($check_paylater_email); $i++) {
                $pay_later_ids_arr_2[] = $check_paylater_email[$i]->id;
            }
            $check_SD1_pl2_count =  Tercourier::where('status', 4)->where('payment_status', 2)->whereDate('verify_ter_date','<',$to)->where('ter_type',2)->where('pfu','SD1')->count();
            $check_MA2_pl2_count =  Tercourier::where('status', 4)->where('payment_status', 2)->whereDate('verify_ter_date','<',$to)->where('ter_type',2)->where('pfu','MA2')->count();
            $check_SD3_pl2_count =  Tercourier::where('status', 4)->where('payment_status', 2)->whereDate('verify_ter_date','<',$to)->where('ter_type',2)->where('pfu','SD3')->count();
            $check_MA4_pl2_count =  Tercourier::where('status', 4)->where('payment_status', 2)->whereDate('verify_ter_date','<',$to)->where('ter_type',2)->where('pfu','MA4')->count();
            $total_pl2_count = $check_SD1_pl2_count + $check_MA2_pl2_count + $check_SD3_pl2_count + $check_MA4_pl2_count;



              // Full n Final 

            // 1st

            $date = date_create($today_date);
            date_add($date, date_interval_create_from_date_string("-15 days"));
            $from = date_format($date, "Y-m-d");
            $to = $today_date;

            $check_full_n_final_email = Tercourier::where('status', 4)->where('payment_status', 3)->whereBetween('verify_ter_date', [$from,$to])->where('ter_type',2)->get();
            // echo "<pre>";
            for ($i = 0; $i < sizeof($check_full_n_final_email); $i++) {
                $full_n_final_ids_arr_1[] = $check_full_n_final_email[$i]->id;
            }
            $check_SD1_fl1_count =  Tercourier::where('status', 4)->where('payment_status', 3)->whereBetween('verify_ter_date', [$from,$to])->where('ter_type',2)->where('pfu','SD1')->count();
            $check_MA2_fl1_count =  Tercourier::where('status', 4)->where('payment_status', 3)->whereBetween('verify_ter_date', [$from,$to])->where('ter_type',2)->where('pfu','MA2')->count();
            $check_SD3_fl1_count =  Tercourier::where('status', 4)->where('payment_status', 3)->whereBetween('verify_ter_date', [$from,$to])->where('ter_type',2)->where('pfu','SD3')->count();
            $check_MA4_fl1_count =  Tercourier::where('status', 4)->where('payment_status', 3)->whereBetween('verify_ter_date', [$from,$to])->where('ter_type',2)->where('pfu','MA4')->count();
            $total_fl1_count =   $check_SD1_fl1_count  + $check_MA2_fl1_count + $check_SD3_fl1_count + $check_MA4_fl1_count;

            // 2nd
            $check_full_n_final_email = "";

            $date = date_create($today_date);
            date_add($date, date_interval_create_from_date_string("-15 days"));
            $to = date_format($date, "Y-m-d");
    

            $check_full_n_final_email = Tercourier::where('status', 4)->where('payment_status', 3)->whereDate('verify_ter_date','<',$to)->where('ter_type',2)->get();
            // echo "<pre>";
            for ($i = 0; $i < sizeof($check_full_n_final_email); $i++) {
                $full_n_final_ids_arr_2[] = $check_full_n_final_email[$i]->id;
            }
            $check_SD1_fl2_count =  Tercourier::where('status', 4)->where('payment_status', 3)->whereDate('verify_ter_date','<',$to)->where('ter_type',2)->where('pfu','SD1')->count();
            $check_MA2_fl2_count =  Tercourier::where('status', 4)->where('payment_status', 3)->whereDate('verify_ter_date','<',$to)->where('ter_type',2)->where('pfu','MA2')->count();
            $check_SD3_fl2_count =  Tercourier::where('status', 4)->where('payment_status', 3)->whereDate('verify_ter_date','<',$to)->where('ter_type',2)->where('pfu','SD3')->count();
            $check_MA4_fl2_count =  Tercourier::where('status', 4)->where('payment_status', 3)->whereDate('verify_ter_date','<',$to)->where('ter_type',2)->where('pfu','MA4')->count();
            $total_fl2_count =   $check_SD1_fl2_count  + $check_MA2_fl2_count + $check_SD3_fl2_count + $check_MA4_fl2_count;



            // unknown 

            // 1st

            $date = date_create($today_date);
            date_add($date, date_interval_create_from_date_string("-1 days"));
            $from = date_format($date, "Y-m-d");
            $to = $today_date;

            $check_unknown_email = Tercourier::where('status', 9)->whereBetween('handover_date',[$from,$to])->where('ter_type',2)->get();
            // echo "<pre>";
            for ($i = 0; $i < sizeof($check_unknown_email); $i++) {
                $unknown_ids_arr_1[] = $check_unknown_email[$i]->id;
            }
            $check_SD1_u1_count =  Tercourier::where('status', 9)->whereBetween('handover_date',[$from,$to])->where('ter_type',2)->where('pfu','SD1')->count();
            $check_MA2_u1_count =  Tercourier::where('status', 9)->whereBetween('handover_date',[$from,$to])->where('ter_type',2)->where('pfu','MA2')->count();
            $check_SD3_u1_count =  Tercourier::where('status', 9)->whereBetween('handover_date',[$from,$to])->where('ter_type',2)->where('pfu','SD3')->count();
            $check_MA4_u1_count =  Tercourier::where('status', 9)->whereBetween('handover_date',[$from,$to])->where('ter_type',2)->where('pfu','MA4')->count();
            $total_u1_count = $check_SD1_u1_count + $check_MA2_u1_count + $check_SD3_u1_count + $check_MA4_u1_count;


            // 2nd

            $check_unknown_email = "";
            
            $date = date_create($today_date);
            date_add($date, date_interval_create_from_date_string("-1 days"));
            $to = date_format($date, "Y-m-d");

            $check_unknown_email = Tercourier::where('status', 9)->whereDate('handover_date','<',$to)->where('ter_type',2)->get();
            // echo "<pre>";
            for ($i = 0; $i < sizeof($check_unknown_email); $i++) {
                $unknown_ids_arr_2[] = $check_unknown_email[$i]->id;
            }
            $check_SD1_u2_count =  Tercourier::where('status', 9)->whereDate('handover_date','<',$to)->where('ter_type',2)->where('pfu','SD1')->count();
            $check_MA2_u2_count =  Tercourier::where('status', 9)->whereDate('handover_date','<',$to)->where('ter_type',2)->where('pfu','MA2')->count();
            $check_SD3_u2_count =  Tercourier::where('status', 9)->whereDate('handover_date','<',$to)->where('ter_type',2)->where('pfu','SD3')->count();
            $check_MA4_u2_count =  Tercourier::where('status', 9)->whereDate('handover_date','<',$to)->where('ter_type',2)->where('pfu','MA4')->count();
            $total_u2_count = $check_SD1_u2_count + $check_MA2_u2_count + $check_SD3_u2_count + $check_MA4_u2_count;



            $check_failed_email = Tercourier::where('status', 0)->whereDate('sent_to_finfect_date', '<', $today_date)->get();
            // echo "<pre>";
            for ($i = 0; $i < sizeof($check_failed_email); $i++) {
                $payment_failed_arr[] = $check_failed_email[$i]->id;
            }

           
            // return $handover_ids_arr_1;

            $handover_ids_1 = implode(', ',$handover_ids_arr_1);
            $handover_ids_2 = implode(', ',$handover_ids_arr_2);
            $handover_ids_3 = implode(', ',$handover_ids_arr_3);
            $handover_ids_4 = implode(', ',$handover_ids_arr_4);

            $finfect_ids_1 = implode(', ',$finfect_ids_arr_1);
            $finfect_ids_2 = implode(', ',$finfect_ids_arr_2);
            $finfect_ids_3 = implode(', ',$finfect_ids_arr_3);

            $rejected_ids_1 = implode(', ',$rejected_ids_arr_1);
            $rejected_ids_2 = implode(', ',$rejected_ids_arr_2);
            $rejected_ids_3 = implode(', ',$rejected_ids_arr_3);

            $pay_later_ids_1 = implode(', ',$pay_later_ids_arr_1);
            $pay_later_ids_2 = implode(', ',$pay_later_ids_arr_2);

            $full_n_final_ids_1 = implode(', ',$full_n_final_ids_arr_1);
            $full_n_final_ids_2 = implode(', ',$full_n_final_ids_arr_2);

            $unknown_ids_1 = implode(', ',$unknown_ids_arr_1);
            $unknown_ids_2 = implode(', ',$unknown_ids_arr_2);

            //    print_r($handover_ids);

            $terMailData = [
                'title' => "List of TER UNID's ",
                'handover_ids_1' => $handover_ids_1,
                'SD1_h1_count' => $check_SD1_h1_count,
                'MA2_h1_count' => $check_MA2_h1_count,
                'SD3_h1_count' => $check_SD3_h1_count,
                'MA4_h1_count' => $check_MA4_h1_count,
                'total_h1_count' => $total_h1_count,

                'handover_ids_2' => $handover_ids_2,
                'SD1_h2_count' => $check_SD1_h2_count,
                'MA2_h2_count' => $check_MA2_h2_count,
                'SD3_h2_count' => $check_SD3_h2_count,
                'MA4_h2_count' => $check_MA4_h2_count,
                'total_h2_count' => $total_h2_count,

                'handover_ids_3' => $handover_ids_3,
                'SD1_h3_count' => $check_SD1_h3_count,
                'MA2_h3_count' => $check_MA2_h3_count,
                'SD3_h3_count' => $check_SD3_h3_count,
                'MA4_h3_count' => $check_MA4_h3_count,
                'total_h3_count' => $total_h3_count,

                'handover_ids_4' => $handover_ids_4,
                'SD1_h4_count' => $check_SD1_h4_count,
                'MA2_h4_count' => $check_MA2_h4_count,
                'SD3_h4_count' => $check_SD3_h4_count,
                'MA4_h4_count' => $check_MA4_h4_count,
                'total_h4_count' => $total_h4_count,

                'finfect_ids_1' => $finfect_ids_1,
                'SD1_f1_count' => $check_SD1_f1_count,
                'MA2_f1_count' => $check_MA2_f1_count,
                'SD3_f1_count' => $check_SD3_f1_count,
                'MA4_f1_count' => $check_MA4_f1_count,
                'total_f1_count' => $total_f1_count,

                'finfect_ids_2' => $finfect_ids_2,
                'SD1_f2_count' => $check_SD1_f2_count,
                'MA2_f2_count' => $check_MA2_f2_count,
                'SD3_f2_count' => $check_SD3_f2_count,
                'MA4_f2_count' => $check_MA4_f2_count,
                'total_f2_count' => $total_f2_count,

                'finfect_ids_3' => $finfect_ids_3,
                'SD1_f3_count' => $check_SD1_f3_count,
                'MA2_f3_count' => $check_MA2_f3_count,
                'SD3_f3_count' => $check_SD3_f3_count,
                'MA4_f3_count' => $check_MA4_f3_count,
                'total_f3_count' => $total_f3_count,

                'rejected_ids_1' => $rejected_ids_1,
                'SD1_r1_count' => $check_SD1_r1_count,
                'MA2_r1_count' => $check_MA2_r1_count,
                'SD3_r1_count' => $check_SD3_r1_count,
                'MA4_r1_count' => $check_MA4_r1_count,
                'total_r1_count' => $total_r1_count,

                'rejected_ids_2' => $rejected_ids_2,
                'SD1_r2_count' => $check_SD1_r2_count,
                'MA2_r2_count' => $check_MA2_r2_count,
                'SD3_r2_count' => $check_SD3_r2_count,
                'MA4_r2_count' => $check_MA4_r2_count,
                'total_r2_count' => $total_r2_count,

                'rejected_ids_3' => $rejected_ids_3,
                'SD1_r3_count' => $check_SD1_r3_count,
                'MA2_r3_count' => $check_MA2_r3_count,
                'SD3_r3_count' => $check_SD3_r3_count,
                'MA4_r3_count' => $check_MA4_r3_count,
                'total_r3_count' => $total_r3_count,

                'pay_later_ids_1' => $pay_later_ids_1,
                'SD1_pl1_count' => $check_SD1_pl1_count,
                'MA2_pl1_count' => $check_MA2_pl1_count,
                'SD3_pl1_count' => $check_SD3_pl1_count,
                'MA4_pl1_count' => $check_MA4_pl1_count,
                'total_pl1_count' => $total_pl1_count,

                'pay_later_ids_2' => $pay_later_ids_2,
                'SD1_pl2_count' => $check_SD1_pl2_count,
                'MA2_pl2_count' => $check_MA2_pl2_count,
                'SD3_pl2_count' => $check_SD3_pl2_count,
                'MA4_pl2_count' => $check_MA4_pl2_count,
                'total_pl2_count' => $total_pl2_count,

                'full_n_final_ids_1' => $full_n_final_ids_1,
                'SD1_fl1_count' => $check_SD1_fl1_count,
                'MA2_fl1_count' => $check_MA2_fl1_count,
                'SD3_fl1_count' => $check_SD3_fl1_count,
                'MA4_fl1_count' => $check_MA4_fl1_count,
                'total_fl1_count' => $total_fl1_count,

                'full_n_final_ids_2' => $full_n_final_ids_2,
                'SD1_fl2_count' => $check_SD1_fl2_count,
                'MA2_fl2_count' => $check_MA2_fl2_count,
                'SD3_fl2_count' => $check_SD3_fl2_count,
                'MA4_fl2_count' => $check_MA4_fl2_count,
                'total_fl2_count' => $total_fl2_count,

                'unknown_ids_1' => $unknown_ids_1,
                'SD1_u1_count' => $check_SD1_u1_count,
                'MA2_u1_count' => $check_MA2_u1_count,
                'SD3_u1_count' => $check_SD3_u1_count,
                'MA4_u1_count' => $check_MA4_u1_count,
                'total_u1_count' => $total_u1_count,

                'unknown_ids_2' => $unknown_ids_2,
                'SD1_u2_count' => $check_SD1_u2_count,
                'MA2_u2_count' => $check_MA2_u2_count,
                'SD3_u2_count' => $check_SD3_u2_count,
                'MA4_u2_count' => $check_MA4_u2_count,
                'total_u2_count' => $total_u2_count,


            ];

            // echo "<pre>";

            // print_r($terMailData);
            // exit;
            
            // $pdf=PDF::loadView('emails.Hrpdf',['terMailData' => $terMailData]);
            // return $pdf->download('ter.xls');

   

            // $excel = Excel::download('emails.Hrpdf',['terMailData' => $terMailData], 'article-collection.xlsx');
            // return $excel;


            // return view('emails.Hrpdf',['terMailData' => $terMailData]);

            // return view('emails.hrMail',['terMailData' => $terMailData]);


            // Mail::to(['itsupport@frontierag.com','dhroov.kanwar@eternitysolutions.net'])->cc(['sahil.thakur@eternitysolutions.net','sahildhruv1@gmail.com'])->send(new SendMail($terMailData));


            Mail::to(['ter@frontierag.com', 'hrd@frontierag.com', 'sdaccounts@frontierag.com'])->cc(['shilpaca@frontierag.com', 'vidur@frontierag.com', 'shailendra@frontierag.com'])
                ->bcc('itsupport@frontierag.com')->send(new SendMail($terMailData));

            // Mail::to('vineet.thakur@eternitysolutions.net')->cc(['sahil.thakur@eternitysolutions.net', 'dhroov.kanwar@eternitysolutions.net'])->send(new SendMail($terMailData));


            // dd('Success! Email has been sent successfully.');
        }
    }



    public function check_paid_status()
    {

        ini_set('max_execution_time', 0); // 0 = Unlimited
        $get_data_db = DB::table('tercouriers')->select('*')->whereIn('status', [3, 7])->get()->toArray();
        // $get_data_db = DB::table('tercouriers')->select('*')->where('id', 1690)->get()->toArray();


        //    echo "<pre>";
        //    print_r($get_data_db);
        //    exit;
        $size = sizeof($get_data_db);
        // $size=3;
        // return $get_data_db;
        for ($i = 0; $i < $size; $i++) {
            // print_r($get_data_db[$i]->id);
            $id = $get_data_db[$i]->id;
            if ($get_data_db[$i]->status == "7") {
                // $type="deduction_setllement";
                $deduction_table = DB::table('ter_deduction_settlements')->where('parent_ter_id', $id)->orderby("book_date", "DESC")->first();
                // return $deduction_table;  
                if ($deduction_table->status != 3) {
                    $id = "FIN101";
                }
                $type = "deduction_settlement";
            } else {
                $type = "others";
            }
            // $id="1088";
            $live_host_name = request()->getHttpHost();

            if ($live_host_name == 'localhost:8000' || $live_host_name == "test-courier.easemyorder.com") {
                $url = 'https://stagging.finfect.biz/api/get_payment_response/' . $id . '/' . $type;
            } else {
                $url = 'https://finfect.biz/api/get_payment_response/' . $id . '/' . $type;
            }
            // dd($url);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            if ($response) {
                $received_data = json_decode($response);
                // print_r($id);
                // print_r($received_data);
                // exit;
                $status_code = $received_data->status_code;

                //    status needs to be checked before updating the finfect_response for deduction table
                if ($status_code == 2) {
                    if ($get_data_db[$i]->status == 7) {
                        $update_ter_data = DB::table('tercouriers')->where('id', $get_data_db[$i]->id)->update([
                            'status' => 5, 'finfect_response' => 'Paid', 'dedcution_paid' => 1,
                            'updated_at' => date('Y-m-d H:i:s')

                        ]);
                        $check_deduction_table = DB::table('ter_deduction_settlements')->where('parent_ter_id', $get_data_db[$i]->id)->orderby("book_date", "DESC")->first();

                        $settlement_deduction = DB::table('ter_deduction_settlements')->where('id', $check_deduction_table->id)->update([
                            'status' => 5, 'finfect_response' => 'Paid',
                            'utr' => $received_data->bank_refrence_no, 'updated_at' => date('Y-m-d H:i:s'),
                            'paid_date' => date('Y-m-d')
                        ]);
                    } else {
                        $update_ter_data = DB::table('tercouriers')->where('id', $get_data_db[$i]->id)->update([
                            'status' => 5, 'finfect_response' => 'Paid',
                            'utr' => $received_data->bank_refrence_no, 'updated_at' => date('Y-m-d H:i:s'),
                            'paid_date' => date('Y-m-d')
                        ]);
                        if ($update_ter_data) {

                            if ($live_host_name == 'localhost:8000' || $live_host_name == "test-courier.easemyorder.com") {
                            } else {

                                self::send_payment_advice($get_data_db[$i]->id);
                            };
                        }
                    }

                    if ($update_ter_data) {
                        // echo "<pre>";
                        // print_r($id);
                        // echo "<pre>";
                        // print_r($response);
                        $res = EmployeeLedgerData::finfect_paid_payment($get_data_db[$i]->id);
                        $amount = $received_data->amount;
                        $sms_lib = new Sms_lib();
                        $res = $sms_lib->send_paid_sms($id, $amount);
                        // $sms_lib->send_paid_sms($get_data_db[$i]->id);
                    }


                    // return $res;
                } elseif ($status_code == 4) {
                    $res = EmployeeLedgerData::finfect_failed_payment($get_data_db[$i]->id);

                    if ($res) {

                        if ($get_data_db[$i]->status == 7) {

                            DB::table('tercouriers')->where('id', $get_data_db[$i]->id)->update([
                                'status' => 5,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);


                            $check_deduction_table = DB::table('ter_deduction_settlements')->where('parent_ter_id', $get_data_db[$i]->id)->orderby("book_date", "DESC")->first();

                            $update_ter_data = DB::table('ter_deduction_settlements')->where('id', $check_deduction_table->id)->update([
                                'status' => 0, 'finfect_response' => $received_data->bank_refrence_no,
                                'final_payable' => "", 'voucher_code' => "", 'payable_amount' => "", 'sent_to_finfect_date' => "",
                                'updated_at' => date('Y-m-d H:i:s'), 'reference_transaction_id' => "",
                                'payment_type' => 'bank_failed_payment'
                            ]);
                        } else {


                            $update_ter_data = DB::table('tercouriers')->where('id', $get_data_db[$i]->id)->update([
                                'status' => 0, 'finfect_response' => $received_data->bank_refrence_no,
                                'final_payable' => "", 'voucher_code' => "", 'payable_amount' => "", 'sent_to_finfect_date' => "",
                                'updated_at' => date('Y-m-d H:i:s'), 'refrence_transaction_id' => "",
                                'payment_type' => 'bank_failed_payment'
                            ]);
                        }

                        // if ($update_ter_data) {
                        // echo "<pre>";
                        // print_r($id);
                        // echo "<pre>";
                        // print_r($response);

                        // $amount = $received_data->amount;
                        // $sms_lib = new Sms_lib();
                        // $res = $sms_lib->send_paid_sms($id, $amount);
                        // $sms_lib->send_paid_sms($get_data_db[$i]->id);
                        // }
                        // return $res;
                    }
                }
            }
        }
        return 1;
    }


    public function check_deduction_paid_status()
    {
        ini_set('max_execution_time', 0); // 0 = Unlimited
        $get_data_db = DB::table('ter_deduction_settlements')->where('status', 3)->get()->toArray();
        // echo "<pre>";
        // print_r($get_data_db);
        // exit;
        $size = sizeof($get_data_db);
        // $size=3;
        // return $get_data_db;
        for ($i = 0; $i < $size; $i++) {
            // print_r($get_data_db[$i]->id);
            $id = $get_data_db[$i]->parent_ter_id;
            // $id="1508";
            // $url = 'https://finfect.biz/api/get_payment_response/' . $id;
            $url = 'https://stagging.finfect.biz/api/get_payment_response/' . $id;
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            // print_r($response);
            curl_close($curl);
            if ($response) {
                $received_data = json_decode($response);
                $status_code = $received_data->status_code;

                //    status needs to be checked before updating the finfect_response for deduction table
                if ($status_code == 2) {
                    $update_ter_data = DB::table('ter_deduction_settlements')->where('id', $get_data_db[$i]->id)->update([
                        'status' => 5, 'finfect_response' => 'Paid',
                        'utr' => $received_data->bank_refrence_no, 'updated_at' => date('Y-m-d H:i:s'),
                        'paid_date' => date('Y-m-d')
                    ]);

                    if ($update_ter_data) {
                        // echo "<pre>";
                        // print_r($id);
                        // echo "<pre>";
                        // print_r($response);
                        $check_ter = DB::table('tercouriers')->where('id', $id)->get();
                        $new_amount_add = $get_data_db[$i]->final_payable;
                        $get_prev_amount = $check_ter[$i]->payable_amount;
                        $prev_amount = json_decode($get_prev_amount);
                        $arr_num = sizeof($prev_amount);
                        $prev_amount[$arr_num] = $new_amount_add;
                        $updated_payable_amount = $prev_amount;

                        $new_voucher_add = $get_data_db[$i]->voucher_code;
                        $get_prev_voucher = $check_ter[$i]->voucher_code;
                        $prev_voucher = json_decode($get_prev_voucher);
                        $arr_num = sizeof($prev_voucher);
                        $prev_voucher[$arr_num] = $new_voucher_add;
                        $updated_voucher = $prev_voucher;

                        $update_ter_data = DB::table('tercouriers')->where('id', $get_data_db[$i]->parent_ter_id)->update([
                            'status' => 5, 'finfect_response' => 'Paid',
                            'updated_at' => date('Y-m-d H:i:s'), 'payable_amount' => $updated_payable_amount,
                            'voucher_code' => $updated_voucher
                        ]);
                        // $update_ter_data = DB::table('tercouriers')->where('id', $get_data_db[$i]->parent_ter_id)->update([
                        //     'status' => 5, 'finfect_response' => 'Paid',
                        //     'updated_at' => date('Y-m-d H:i:s')
                        // ]);

                        EmployeeLedgerData::finfect_deduction_paid_payment($get_data_db[$i]->parent_ter_id);

                        $amount = $received_data->amount;
                        $sms_lib = new Sms_lib();
                        $res = $sms_lib->send_paid_sms($id, $amount);
                        // $sms_lib->send_paid_sms($get_data_db[$i]->id);
                    }
                    // return $res;
                }
            }
        }
        return 1;
    }

    // public function test()
    // {
    //     return view('tercouriers.test');
    // }

    public function update_by_hr_admin(Request $request)
    {
        $data = $request->all();
        $amount = $data['amount'];
        $company_name = $data['company_name'];
        $admin_remarks = $data['admin_remarks'];
        // return $admin_remarks;
        // $sender_id = $data['sender_id'];
        $sender_emp_id = $data['sender_emp_id'];
        $sender_name = $data['sender_name'];
        $ax_code = $data['ax_id'];
        $unique_id = $data['unique_id'];
        // $voucher_code = $data['voucher_code'];
        // $payable_amount = $data['payable_amount'];
        $payable_data = $data['payable_data'];
        $ter_total_amount = $data['amount'];
        $manaully_paid = $data['manually_paid'];
        $total_payable_sum = 0;
        if (!empty($payable_data)) {
            $length = sizeof($payable_data);
            for ($i = 0; $i < $length; $i++) {
                $total_payable_sum = $total_payable_sum + $payable_data[$i]['payable_amount'];
            }

            if ($total_payable_sum > $ter_total_amount) {
                return "error_sum_amount";
            }
            $length = sizeof($payable_data);
            for ($i = 0; $i < $length; $i++) {
                $pay_data[$i] = $payable_data[$i]['payable_amount'];
                $voucher_data[$i] = $payable_data[$i]['voucher_code'];
            }
            $pay_encode = json_encode($pay_data);
            $voucher_encode = json_encode($voucher_data);
        } else {
            $payable_data = "";
        }
        $terfrom_date = $data['terfrom_date'];
        $terto_date = $data['terto_date'];
        $sender_table = DB::table('sender_details')->where('employee_id', $sender_emp_id)->get();
        if (!count($sender_table)) {
            $sender_emp_id = '0' . $sender_emp_id;
            $sender_table = DB::table('sender_details')->where('employee_id', $sender_emp_id)->get();
        }
        $tercourier = DB::table('tercouriers')->where('id', $unique_id)->get();
        $details = Auth::user();
        $updated_details['user_id'] = $details->id;
        $updated_details['user_name'] = $details->name;
        $updated_details['updated_id'] = $unique_id;
        $updated_details['updated_date'] = date('Y-m-d');
        $updated_details['created_at'] = date('Y-m-d H:i:s');
        $updated_details['updated_at'] = date('Y-m-d H:i:s');

        // if ($sender_emp_id ==  $sender_table[0]->employee_id) {
        //   $tercourier=DB::table('tercouriers')->where('sender_id',$sender_id)->where('id',$unique_id)->get();
        if ($tercourier[0]->status == 2 || $tercourier[0]->status == 4 || $tercourier[0]->status == 0) {

            if ((int)$tercourier[0]->amount != $amount) {
                // dd("gggf");
                // $test="hello";
                $updated_details['updated_field'] = 'Amount Changed from ' . $tercourier[0]->amount . ' to ' . $amount;
                $tercourier_update_amount = DB::table('tercouriers')->where('id', $unique_id)->update(array('amount' => $amount));
                if ($tercourier_update_amount) {
                    $updated_record_detail = DB::table('update_table_data_details')->insert($updated_details);
                }
                // $response=Update_table_data::where('updated_id',$unique_id)->with('SaveUpdatedData')->get();
                // return $response;
                // return $updated_record_detail;
            }

            // echo "<pre>"; print_r($tercourier['0']->company_name); die;
            if ($tercourier[0]->terfrom_date != $terfrom_date) {
                $tercourier_update_terfrom_date = DB::table('tercouriers')->where('id', $unique_id)->update(array('terfrom_date' => $terfrom_date));
                if (!empty($tercourier[0]->terfrom_date)) {
                    $updated_details['updated_field'] = 'TER From Date Changed from ' . $tercourier[0]->terfrom_date . ' to ' . $terfrom_date;
                } else {
                    $updated_details['updated_field'] = 'TER From Date  added as ' . $terfrom_date;
                }
                if ($tercourier_update_terfrom_date) {
                    $updated_record_detail = DB::table('update_table_data_details')->insert($updated_details);
                }
            }
            if ($tercourier[0]->terto_date != $terto_date) {
                $tercourier_update_terto_date = DB::table('tercouriers')->where('id', $unique_id)->update(array('terto_date' => $terto_date));
                if (!empty($tercourier[0]->terto_date)) {
                    $updated_details['updated_field'] = 'TER To Date Changed from ' . $tercourier[0]->terto_date . ' to ' . $terto_date;
                } else {
                    $updated_details['updated_field'] = 'TER To Date  added as ' . $terto_date;
                }
                if ($tercourier_update_terto_date) {
                    $updated_record_detail = DB::table('update_table_data_details')->insert($updated_details);
                }
            }



            $updated_record_detail = DB::table('tercouriers')->where('id', $unique_id)->update(array('hr_admin_remark' => $admin_remarks));


            if ($tercourier[0]->company_name != $company_name) {
                // dd("ggg");
                $tercourier_update_company = DB::table('tercouriers')->where('id', $unique_id)->update(array('company_name' => $company_name));
                $updated_details['updated_field'] = 'Company Name Changed from ' . $tercourier[0]->company_name . ' to ' . $company_name;
                if ($tercourier_update_company) {
                    $updated_record_detail = DB::table('update_table_data_details')->insert($updated_details);
                }
            }

            // return $sender_table;
            if ($tercourier[0]->sender_id != $sender_table[0]->id) {
                $tercourier_update_sender_id = DB::table('tercouriers')->where('id', $unique_id)->update(array('sender_id' => $sender_table[0]->id));
                $updated_details['updated_field'] = 'Sender id Changed from ' . $tercourier[0]->sender_id . ' to ' . $sender_table[0]->id;
                if ($tercourier_update_sender_id) {
                    $updated_record_detail = DB::table('update_table_data_details')->insert($updated_details);
                }
            }

            if ($tercourier[0]->sender_name != $sender_name) {
                $tercourier_update_sender_name = DB::table('tercouriers')->where('id', $unique_id)->update(array('sender_name' => $sender_name));
                if (!empty($tercourier[0]->sender_name)) {
                    $updated_details['updated_field'] = 'Sender Name Changed from ' . $tercourier[0]->sender_name . ' to ' . $sender_name;
                } else {
                    $updated_details['updated_field'] = 'Sender Name Added as ' . $sender_name;
                }
                if ($tercourier_update_sender_name) {
                    $updated_record_detail = DB::table('update_table_data_details')->insert($updated_details);
                }
            }
            if ($tercourier[0]->ax_id != $ax_code) {
                $tercourier_update_sender_ax_id = DB::table('tercouriers')->where('id', $unique_id)->update(array('ax_id' => $ax_code));
                if (!empty($tercourier[0]->ax_id)) {
                    $updated_details['updated_field'] = 'Ax Code Changed from ' . $tercourier[0]->ax_id . ' to ' . $ax_code;
                } else {
                    $updated_details['updated_field'] = 'Ax Code added as ' . $ax_code;
                }
                if ($tercourier_update_sender_ax_id) {
                    $updated_record_detail = DB::table('update_table_data_details')->insert($updated_details);
                }
            }
            if ($tercourier[0]->employee_id != $sender_emp_id) {
                $tercourier_update_sender_emp_id = DB::table('tercouriers')->where('id', $unique_id)->update(array('employee_id' => $sender_emp_id));
                if (!empty($tercourier[0]->employee_id)) {
                    $updated_details['updated_field'] = 'Employee ID Changed from ' . $tercourier[0]->employee_id . ' to ' . $sender_emp_id;
                } else {
                    $updated_details['updated_field'] = 'Employee ID added as ' . $sender_emp_id;
                }
                if ($tercourier_update_sender_emp_id) {
                    $updated_record_detail = DB::table('update_table_data_details')->insert($updated_details);
                }
            }
            if (!empty($pay_data)) {
                $tercourier_update_payable = DB::table('tercouriers')->where('id', $unique_id)->update(array('payable_amount' => $pay_data));
                if (!empty($tercourier[0]->payable_amount)) {
                    $updated_details['updated_field'] = 'Payable Amount Changed from ' . $tercourier[0]->payable_amount . ' to ' . $pay_encode;
                } else {
                    $updated_details['updated_field'] = 'Payable Amount added as ' . $pay_encode;
                }
                if ($tercourier_update_payable) {
                    $updated_record_detail = DB::table('update_table_data_details')->insert($updated_details);
                }



                $tercourier_update_voucher = DB::table('tercouriers')->where('id', $unique_id)->update(array('voucher_code' => $voucher_data));
                if (!empty($tercourier[0]->voucher_code)) {
                    $updated_details['updated_field'] = 'Voucher Code Changed from ' . $tercourier[0]->voucher_code . ' to ' . $voucher_encode;
                } else {
                    $updated_details['updated_field'] = 'Voucher Code added as ' . $voucher_encode;
                }
                if ($tercourier_update_voucher) {
                    $updated_record_detail = DB::table('update_table_data_details')->insert($updated_details);
                }
                if ($manaully_paid) {
                    $updated_record_detail = DB::table('tercouriers')->where('id', $unique_id)->update(array(
                        'status' => '5', 'payment_status' => '5',
                        'payment_type' => 'manually_paid_payment', 'updated_by_id' => $updated_details['user_id'],
                        'updated_by_name' => $updated_details['user_name'], 'updated_at' => $updated_details['updated_at']
                    ));
                }
            }
            return $updated_record_detail;
        } elseif ($tercourier[0]->status == 9) {
            return "not_allowed";
        } else {
            return 0;
        }
        // $tercourier=DB::table('tercouriers')->where('id',$unique_id)->update('sender_id',$sender_id);
        //   return $tercourier;
        // } else {
        //     return 'error';
        // }
    }

    public function get_all_data(Request $request)
    {
        $data = $request->all();
        // return $data;
        $id = $data['unique_id'];
        $role = $data['role'];
        $query = Tercourier::query();
        // $tercourier_table= DB::table('tercouriers')->select ('*')->where('id',$id)->get()->toArray();
        $tercourier_table = $query->where('id', $id)->with('CourierCompany', 'SenderDetail')->orderby('id', 'DESC')->get();

        if (count($tercourier_table) < 1) {
            $data_error['status_of_data'] = "not_found";
            return $data_error;
        }
        if ($tercourier_table[0]->status == 0 && $role == "reception") {
            $data_error['status_of_data'] = "0";
            return $data_error;
        }
        if ($tercourier_table[0]->status == 9 && $role == "reception") {
            $data_error['status_of_data'] = "9";
            return $data_error;
        }
        if ($tercourier_table[0]->status == 9 && $role == "" && $tercourier_table[0]->employee_id == 0) {
            $data_error['status_of_data'] = "9";
            return $data_error;
        }
        if ($tercourier_table[0]->status == 4 && $role == "reception") {
            $data_error['status_of_data'] = "4";
            return $data_error;
        }
        if ($tercourier_table[0]->status == 2 && $role == "reception") {
            $data_error['status_of_data'] = "2";
            return $data_error;
        }
        if ($tercourier_table[0]->status == 3) {
            $data_error['status_of_data'] = "3";
            return $data_error;
        }
        if ($tercourier_table[0]->status == 5) {
            $data_error['status_of_data'] = "5";
            return $data_error;
        }
        if ($tercourier_table[0]->status == 6) {
            $data_error['status_of_data'] = "6";
            return $data_error;
        }
        if ($tercourier_table[0]->status == 7) {
            $data_error['status_of_data'] = "7";
            return $data_error;
        }
        if ($tercourier_table[0]->status == 8) {
            $data_error['status_of_data'] = "8";
            return $data_error;
        }
        if ($tercourier_table[0]->status == 11) {
            $data_error['status_of_data'] = "11";
            return $data_error;
        }
        $senders =  DB::table('sender_details')->get();
        $balance_data = DB::table('employee_balance')->select('current_balance')->where('employee_id', $tercourier_table[0]->employee_id)->orderBy('id', 'DESC')->first();;
        // return $balance_data;
        if (empty($balance_data)) {
            $e_id = '0' . $tercourier_table[0]->employee_id;
            $balance_data = DB::table('employee_balance')->select('current_balance')->where('employee_id', $e_id)->orderBy('id', 'DESC')->first();;
        }
        if (!empty($balance_data)) {
            $tercourier_table['current_balance'] = $balance_data->current_balance;
        } else {
            $tercourier_table['current_balance'] = 0;
        }
        $tercourier_table['all_senders_data'] = $senders;
        if ($tercourier_table[0]->payable_amount == "" && $tercourier_table[0]->voucher_code == "") {
            $tercourier_table['status_of_data'] = "0";
            return $tercourier_table;
        } else {
            $tercourier_table['status_of_data'] = "1";
            return $tercourier_table;
        }
    }

    public function ter_pay_later(Request $request)
    {
        $data = $request->all();
        // return json_decode($data['payable_data']);
        
        $pay_data =json_decode($data['payable_data']);
        $payable_data=array();
    
        $id = $data['unique_id'];
        $paylater_remarks=$data['pay_later_remarks'];
      
        $ter_total_amount = $data['ter_total_amount'];
        $total_payable_sum = 0;
        $length = sizeof($pay_data);
        $selected_options = $data['selected_options'];
        if (!empty($selected_options)) {
            DB::table('tercouriers')->where('id', $id)->update(['deduction_options' => $selected_options]);
        }

        $check_dates = DB::table('tercouriers')->where('id', $id)->get();

        $details = Auth::user();
        $ter_data_update['user_id'] = $details->id;
        $ter_data_update['user_name'] = $details->name;
        $ter_data_update['updated_id'] = $id;
        $ter_data_update['updated_date'] = date('Y-m-d');
        $ter_data_update['created_at'] = date('Y-m-d H:i:s');
        $ter_data_update['updated_at'] = date('Y-m-d H:i:s');

        if ($check_dates) {
            if ($data['terfrom'] != $check_dates[0]->terfrom_date) {
                $do_update = DB::table('tercouriers')->where('id', $id)->update(array(
                    'terfrom_date' => $data['terfrom']
                ));
                if ($do_update) {
                    $ter_data_update['updated_field'] = 'TER From Date Changed from ' . $check_dates[0]->terfrom_date . ' to ' . $data['terfrom'];
                    DB::table('update_table_data_details')->insert($ter_data_update);
                }
            }
            if ($data['terto'] != $check_dates[0]->terto_date) {
                $do_update = DB::table('tercouriers')->where('id', $id)->update(array(
                    'terto_date' => $data['terto']
                ));
                if ($do_update) {
                    $ter_data_update['updated_field'] = 'TER To Date Changed from ' . $check_dates[0]->terto_date . ' to ' . $data['terto'];
                    DB::table('update_table_data_details')->insert($ter_data_update);
                }
            }
        }

        if (!empty($pay_data)) {
            for ($i = 0; $i < $length; $i++) {
                $payable_data[$i]['voucher_code'] = $pay_data[$i]->voucher_code;
                $payable_data[$i]['payable_amount'] = $pay_data[$i]->payable_amount;
            }
          
        }

        /////////////////////////////////////////////// Start of duplicate voucher check /////////////////////////////////////////////////////////////////////////

        if (!empty($payable_data)) {
            for ($i = 0; $i < $length; $i++) {
                $voucher_data[$i] = $payable_data[$i]['voucher_code'];
            }
          
            $data['voucher_code'] = $voucher_data;
        }

        $decode2 = array();
        $check_duplicate = DB::table('tercouriers')->select('voucher_code')->whereIn('status', [3, 5])->get();
        $voucher_code_size = sizeof($check_duplicate);
        for ($l = 0; $l < sizeof($data['voucher_code']); $l++) {
            // this is for previous flow
            for ($i = 0; $i < $voucher_code_size; $i++) {
                if ($check_duplicate[$i]->voucher_code == $data['voucher_code'][$l]) {
                    return ["duplicate_voucher", $data['voucher_code'][$l]];
                }
            }
            for ($i = 0; $i < $voucher_code_size; $i++) {
                $decode2[$i] = json_decode($check_duplicate[$i]->voucher_code);
                // print_r($decode2[$i]);
                if (gettype($decode2[$i]) == "array") {
                    if (!empty($decode2[$i])) {
                        if (sizeof($decode2[$i]) > 1) {
                            // print_r("rt");
                            for ($j = 0; $j < sizeof($decode2[$i]); $j++) {
                                if ($decode2[$i][$j] == $data['voucher_code'][$l]) {
                                    return ["duplicate_voucher", $data['voucher_code'][$l]];
                                }
                            }
                        } else {
                            // echo "<pre>";
                            // print_r($data['voucher_code'][$l]);
                            // print_r($decode2[$i][0]);
                            if ($decode2[$i][0] == $data['voucher_code'][$l]) {
                                return ["duplicate_voucher", $data['voucher_code'][$l]];
                                // exit;
                            }
                        }
                    }
                } else {
                    if ($decode2[$i] == $data['voucher_code'][$l]) {
                        return ["duplicate_voucher", $data['voucher_code'][$l]];
                        // exit;
                    }
                }
            }
        }
        //////////////////////////////////////////////////// end of duplicate voucher check ////////////////////////////////////////////////////////////////////////////////////////////////

        for ($i = 0; $i < $length; $i++) {
            $total_payable_sum = $total_payable_sum + $payable_data[$i]['payable_amount'];
        }

        if ($total_payable_sum > $ter_total_amount) {
            return "error_sum_amount";
        }
        $data_ter_check = DB::table('tercouriers')->where('id', $id)->get()->toArray();
        $check_ifsc = DB::table('sender_details')->select('ifsc')->where('employee_id', $data_ter_check[0]->employee_id)->get();
        if (strlen($check_ifsc[0]->ifsc) != 11) {
            return "ifsc_error";
        }

        $details = Auth::user();
        $payment_status = $data['payment_status'];
        $log_in_user_name = $details->name;
        $log_in_user_id = $details->id;
        $final_payable = $total_payable_sum;
        $data_ter = DB::table('tercouriers')->where('id', $id)->get()->toArray();
        $tercourier_ax_check = $data_ter[0];

        $image = $request->file('file');
        $fileName = $image->getClientOriginalName();
        $destinationPath = 'paylater_ter_uploads';
        $image->move($destinationPath, $fileName);

        if ($tercourier_ax_check->ax_id  != 0) {

            DB::table('tercouriers')->where('id',$id)->update(['paylater_uploads'=>$fileName,'paylater_remarks'=>$paylater_remarks]);

            $response = Tercourier::add_voucher_payable($payable_data, $id, $log_in_user_id, $log_in_user_name, $payment_status, $final_payable);
            // $response = Tercourier::add_voucher_payable($payable_data, $id, $log_in_user_id, $log_in_user_name, $payment_status);
        } else {
            exit;
        }
        // $response = Tercourier::add_voucher_payable($voucher_code, $payable_amount, $id, $log_in_user_id, $log_in_user_name,$payment_status);
        return $response;
    }


    public function get_paylater_details(Request $request)
    {
        $data=$request->all();
        $id=$data['id'];
        $res=DB::table('tercouriers')->where('id',$id)->get();
        return $res;
    }

    public function ter_pay_now(Request $request)
    {

        $data = $request->all();
        $id = $data['unique_id'];
        $payable_data = $data['payable_data'];
        $ter_total_amount = $data['ter_total_amount'];
        $total_payable_sum = 0;
        $length = sizeof($payable_data);
        $check_dates = DB::table('tercouriers')->where('id', $id)->get();

        $details = Auth::user();
        $ter_data_update['user_id'] = $details->id;
        $ter_data_update['user_name'] = $details->name;
        $ter_data_update['updated_id'] = $id;
        $ter_data_update['updated_date'] = date('Y-m-d');
        $ter_data_update['created_at'] = date('Y-m-d H:i:s');
        $ter_data_update['updated_at'] = date('Y-m-d H:i:s');

        if ($check_dates) {
            if ($data['terfrom'] != $check_dates[0]->terfrom_date) {
                $do_update = DB::table('tercouriers')->where('id', $id)->update(array(
                    'terfrom_date' => $data['terfrom']
                ));
                if ($do_update) {
                    $ter_data_update['updated_field'] = 'TER From Date Changed from ' . $check_dates[0]->terfrom_date . ' to ' . $data['terfrom'];
                    DB::table('update_table_data_details')->insert($ter_data_update);
                }
            }
            if ($data['terto'] != $check_dates[0]->terto_date) {
                $do_update = DB::table('tercouriers')->where('id', $id)->update(array(
                    'terto_date' => $data['terto']
                ));
                if ($do_update) {
                    $ter_data_update['updated_field'] = 'TER To Date Changed from ' . $check_dates[0]->terto_date . ' to ' . $data['terto'];
                    DB::table('update_table_data_details')->insert($ter_data_update);
                }
            }
        }

        //////////////////////////////////////////////////// Start of duplicate voucher check ////////////////////////////////////////////////////////////////////////////////////////////////

        if (!empty($payable_data)) {
            for ($i = 0; $i < $length; $i++) {
                $voucher_data[$i] = $payable_data[$i]['voucher_code'];
            }
            $data['voucher_code'] = $voucher_data;
        }

        $decode2 = array();
        $check_duplicate = DB::table('tercouriers')->select('voucher_code')->whereIn('status', [3, 5])->get();
        $voucher_code_size = sizeof($check_duplicate);
        // return $voucher_code_size;
        for ($l = 0; $l < sizeof($data['voucher_code']); $l++) {
            // this is for previous flow
            for ($i = 0; $i < $voucher_code_size; $i++) {
                if ($check_duplicate[$i]->voucher_code == $data['voucher_code'][$l]) {
                    return ["duplicate_voucher", $data['voucher_code'][$l]];
                }
            }
            for ($i = 0; $i < $voucher_code_size; $i++) {
                $decode2[$i] = json_decode($check_duplicate[$i]->voucher_code);
                // print_r($decode2[$i]);exit;
                if (gettype($decode2[$i]) == "array") {
                    if (!empty($decode2[$i])) {
                        if (sizeof($decode2[$i]) > 1) {
                            // print_r("rt");
                            for ($j = 0; $j < sizeof($decode2[$i]); $j++) {
                                if ($decode2[$i][$j] == $data['voucher_code'][$l]) {
                                    return ["duplicate_voucher", $data['voucher_code'][$l]];
                                }
                            }
                        } else {
                            // echo "<pre>";
                            // print_r($data['voucher_code'][$l]);
                            // print_r($decode2[$i][0]);
                            if ($decode2[$i][0] == $data['voucher_code'][$l]) {
                                return ["duplicate_voucher", $data['voucher_code'][$l]];
                                // exit;
                            }
                        }
                    }
                } else {
                    if ($decode2[$i] == $data['voucher_code'][$l]) {
                        return ["duplicate_voucher", $data['voucher_code'][$l]];
                        // exit;
                    }
                }
            }
        }
        //////////////////////////////////////////////////// end of duplicate voucher check ////////////////////////////////////////////////////////////////////////////////////////////////

        $data_ter = DB::table('tercouriers')->where('id', $id)->get()->toArray();
        // return $data_ter[0]->employee_id;
        for ($i = 0; $i < $length; $i++) {
            $total_payable_sum = $total_payable_sum + $payable_data[$i]['payable_amount'];
        }

        if ($total_payable_sum > $ter_total_amount) {
            return "error_sum_amount";
        }

        $res = 0;
        $id = $data['unique_id'];
        $data_ter = DB::table('tercouriers')->where('id', $id)->get()->toArray();
        $check_ifsc = DB::table('sender_details')->select('ifsc')->where('employee_id', $data_ter[0]->employee_id)->get();
        // return $check_ifsc;
        if (strlen($check_ifsc[0]->ifsc) != 11) {
            return "ifsc_error";
        }

        $selected_options = $data['selected_options'];
        if (!empty($selected_options)) {
            DB::table('tercouriers')->where('id', $id)->update(['deduction_options' => $selected_options]);
        }

        $response = self::advance_payment_check($data, $total_payable_sum);
        // return $response;

        if ($response[1] == '4') {
            return $response[0];
        }
        // return $final_payable;
        // $voucher_code = $data['voucher_code'];
        // $payable_amount = $data['payable_amount'];

        if ($response) {
            $emp_sender_id = $data_ter[0]->employee_id;
            $check_last_working = DB::table('sender_details')->where('employee_id', $emp_sender_id)->get()->toArray();
            if (!empty($check_last_working[0]->last_working_date)) {
                $change_status = DB::table('tercouriers')->where("id", $data['unique_id'])->update(array(
                    'payment_type' => 'full_and_final_payment', 'verify_ter_date' => date('Y-m-d'), 'status' => 4, 'payment_status' => 3, 'book_date' => date('Y-m-d')
                ));
                return $change_status;
            } else {
                $res = self::api_call_finfect($id);
                $emp_id = $data_ter[0]->employee_id;
                // $res="dsd";
                if ($res != '1') {
                    $get_emp_ledger = EmployeeLedgerData::where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
                    $insert_data['ax_voucher_number'] = $get_emp_ledger->ax_voucher_number;
                    $insert_data['ledger_balance'] = $get_emp_ledger->ledger_balance + $get_emp_ledger->ter_expense;
                    $insert_data['wallet_id'] = 0;
                    $insert_data['incoming_payment'] = 0;
                    $insert_data['action_done'] = 'Payment_Failed';
                    $insert_data['ter_expense'] = $get_emp_ledger->ter_expense;
                    $insert_data['utilize_amount'] = 0;
                    $insert_data['updated_date'] = date('Y-m-d');
                    $insert_data['employee_id'] = $emp_id;
                    $insert_data['ter_id'] = $get_emp_ledger->ter_id;
                    $insert_data['user_id'] = $get_emp_ledger->user_id;
                    $insert_data['user_name'] = $get_emp_ledger->user_name;
                    $insert_data['created_at'] = date('Y-m-d H:i:s');
                    $insert_data['updated_at'] = date('Y-m-d H:i:s');
                    EmployeeLedgerData::insert($insert_data);

                    $get_emp_acc = EmployeeBalance::where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
                    if ($get_emp_acc->updated_date == date('Y-m-d') && $get_emp_ledger->ter_id == $get_emp_acc->ter_id) {
                        $insert_emp_data['updated_date'] = date('Y-m-d');
                        $insert_emp_data['employee_id'] = $emp_id;
                        $insert_emp_data['advance_amount'] = 0;
                        $insert_emp_data['ter_id'] = $get_emp_acc->ter_id;
                        $insert_emp_data['ax_voucher_number'] = $get_emp_acc->ax_voucher_number;
                        $insert_emp_data['utilize_amount'] = $get_emp_acc->utilize_amount;
                        $insert_emp_data['current_balance'] = $get_emp_acc->utilize_amount + $get_emp_acc->current_balance;
                        $insert_emp_data['action_done'] = 'Payment_Failed';
                        $insert_emp_data['user_id'] = $get_emp_acc->user_id;
                        $insert_emp_data['user_name'] = $get_emp_acc->user_name;
                        $insert_emp_data['created_at'] = date('Y-m-d H:i:s');
                        $insert_emp_data['updated_at'] = date('Y-m-d H:i:s');
                        // return $insert_data;
                        $table_update = EmployeeBalance::insert($insert_emp_data);
                    }
                } else {
                    $get_emp_ledger = EmployeeLedgerData::where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
                    $advance_amt = $get_emp_ledger->ledger_balance + $get_emp_ledger->ter_expense;
                    // dd($advance_amt);
                    if ($data_ter[0]->status == 7) {
                        if ($advance_amt > 0) {
                            DB::table('ter_deduction_settlements')->where('parent_ter_id', $id)->update(['advance_used' => $advance_amt]);
                        }
                    } else {
                        if ($advance_amt > 0) {
                            DB::table('tercouriers')->where('id', $id)->update(['advance_used' => $advance_amt]);
                        }
                    }
                }
                return $res;
            }
        }
    }


    public function advance_payment_check($data, $total_payable_sum)
    {
        // print_r($total_payable_sum);
        // exit;
        $id = $data['unique_id'];
        // print_r($id);
        // exit;
        $check_deduction_table = DB::table('ter_deduction_settlements')->where('parent_ter_id', $data['unique_id'])->orderby("book_date", "DESC")->first();
        $settlement_deduction = 0;
        $response = "";
        if (!empty($check_deduction_table)) {
            $emp_id = $check_deduction_table->employee_id;
            $payable_amount = $check_deduction_table->payable_amount;
            $voucher_code = $check_deduction_table->voucher_code;
            $settlement_deduction = 1;
            $ax_code = $check_deduction_table->ax_code;
        } else {
            $data_ter = DB::table('tercouriers')->where('id', $id)->get()->toArray();
            $emp_id = $data_ter[0]->employee_id;
            $payable_amount = $data_ter[0]->payable_amount;
            $voucher_code = $data_ter[0]->voucher_code;
            $ax_code = $data_ter[0]->ax_id;
            $iag_code = $data_ter[0]->iag_code;
        }

        // if(empty($ax_code))
        // {
        //     $get_ax_sender=DB::table('sender_details')->where('employee_id',$data_ter[0]->employee_id)->get();
        //     if(empty($get_ax_sender[0]->ax_id))
        //     {
        //         $ax_code=$get_ax_sender[0]->iag_code;
        //     }else{
        //         $ax_code=$get_ax_sender[0]->ax_id;
        //     }

        //     DB::table('tercouriers')->where('id', $id)->update(['ax_id' => $ax_code,'updated_at' => date('Y-m-d H:i:s')]);
        // }




        $current_balance = $data['current_balance'];
        // return $data;
        $final_payable = 0;
        $details = Auth::user();
        $log_in_user_name = $details->name;
        $log_in_user_id = $details->id;
        $flag = 0;
        $new_emp_id = '0' . $emp_id;
        // echo "<pre>";
        // print_r($data_ter);
        // exit;
        $payable_data = $data['payable_data'];

        // return $data_ter[0]->employee_id;

        $check = DB::table('sender_details')->where('employee_id', $emp_id)->get();

        if (sizeof($check) == 0) {
            $check = DB::table('sender_details')->where('employee_id', $new_emp_id)->get();
            if (sizeof($check) != 0) {
                $emp_id = $new_emp_id;
            }
        }
        // return $emp_id;
        $get_current_balance = EmployeeBalance::select('current_balance')->where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
        //   return $get_current_balance;
        if (!empty($get_current_balance)) {
            if ($current_balance != $get_current_balance->current_balance) {
                $current_balance = $get_current_balance->current_balance;
            }
        }
        // return $data;
        if (!empty($payable_data)) {
            $length = sizeof($payable_data);
            for ($i = 0; $i < $length; $i++) {
                $pay_amount[$i] = $payable_data[$i]['payable_amount'];
                $voucher_data[$i] = $payable_data[$i]['voucher_code'];
            }
            $payable_size = sizeof($pay_amount);
            if ($payable_size > 1) {
                $ter_pay_amount = array_sum($pay_amount);
            } else {
                $ter_pay_amount = $pay_amount[0];
            }

            $voucher_codes = $voucher_data;
        } else {
            if ($settlement_deduction) {
                $ter_pay_amount = $payable_amount;
            } else {
                if (gettype($payable_amount != "array")) {

                    $ter_pay_amount = $payable_amount;
                } else {
                    $decoding_arr = json_decode($payable_amount);
                    $payable_arr_size = sizeof($decoding_arr);
                    if ($payable_arr_size > 1) {
                        $ter_pay_amount = array_sum($decoding_arr);
                    } else {
                        $ter_pay_amount = $payable_amount;
                    }
                }
            }
            $voucher_codes = $voucher_code;
        }
        // echo "<pre>";
        // print_r($ter_pay_amount);
        // print_r($voucher_codes);
        // exit;
        // return $voucher_codes;
        if ($current_balance != 0) {
            if ($total_payable_sum > $current_balance) {
                $flag = 1;
                $final_payable = $total_payable_sum - $current_balance;
            } else if ($total_payable_sum == $current_balance) {
                $final_payable = 0;
                $flag = 1;
            } else {
                $final_payable = $current_balance - $total_payable_sum;
                $final_payable = 0;
            }
            if ($flag) {
                $utlized_amount = $current_balance;
            } else {
                $utlized_amount = $total_payable_sum;
            }

            $emp_sender_id = $emp_id;


            if (!$settlement_deduction) {
                $check_last_working = DB::table('sender_details')->where('employee_id', $emp_sender_id)->get()->toArray();
                if (!empty($check_last_working)) {
                    if ($check_last_working[0]->last_working_date) {
                        // return "Dsa";
                        $change_status = DB::table('tercouriers')->where("id", $data['unique_id'])->update(array(
                            'payment_type' => 'full_and_final_payment', 'verify_ter_date' => date('Y-m-d'), 'status' => 4, 'payment_status' => 3, 'book_date' => date('Y-m-d')
                        ));
                        return $change_status;
                    }
                }
            }

            // print_r($voucher_codes);
            // exit;

            $update_ledger_table = EmployeeLedgerData::employee_payment_detail($log_in_user_id, $log_in_user_name, $emp_id, $utlized_amount, $id, $ter_pay_amount, $voucher_codes);


            $update_employee_table = EmployeeBalance::utilized_advance($log_in_user_id, $log_in_user_name, $emp_id, $utlized_amount, $id, $ter_pay_amount, $voucher_codes);


            if ($current_balance > $total_payable_sum) {
                $payment_status = "4";
                if ($settlement_deduction) {
                    $update_deduction_table = DB::table('ter_deduction_settlements')->where('id', $check_deduction_table->id)->update([
                        'final_payable' => 0, 'status' => 5, 'updated_by_id' => $log_in_user_id, 'book_date' => date('Y-m-d'),
                        'paid_date' => date('Y-m-d'),
                        'updated_by_name' => $log_in_user_name
                    ]);
                    if ($update_deduction_table) {
                        $response = DB::table('tercouriers')->where('id', $id)->update([
                            'status' => 5, 'verify_ter_date' => date('Y-m-d'), 'updated_by_id' => $log_in_user_id,
                            'updated_by_name' => $log_in_user_name
                        ]);
                    }
                } else {
                    $response = Tercourier::add_voucher_payable($payable_data, $id, $log_in_user_id, $log_in_user_name, $payment_status, $final_payable);
                }
                $p_status = 4;
                return [$response, $p_status];
            } else {

                if ($ax_code != 0) {
                    $payment_status = 1;
                    if ($settlement_deduction) {
                        $update_deduction_table = DB::table('ter_deduction_settlements')->where('id', $check_deduction_table->id)->update([
                            'final_payable' => $final_payable, 'updated_by_id' => $log_in_user_id,
                            'updated_by_name' => $log_in_user_name
                        ]);
                        if ($update_deduction_table) {
                            $response = 1;
                        }
                    } else {
                        $response = Tercourier::add_voucher_payable($payable_data, $id, $log_in_user_id, $log_in_user_name, $payment_status, $final_payable);
                    }
                    $p_status = 1;
                    // return [$response,$p_status];
                } else {
                    exit;
                }
            }
        } else {
            $utlized_amount = 0;
            $final_payable = $total_payable_sum;
            $update_employee_table = EmployeeLedgerData::employee_payment_detail($log_in_user_id, $log_in_user_name, $emp_id, $utlized_amount, $id, $ter_pay_amount, $voucher_codes);
            $payment_status = $data['payment_status'];
            if ($ax_code != 0) {
                $p_status = 1;
                if ($settlement_deduction) {
                    $update_deduction_table = DB::table('ter_deduction_settlements')->where('id', $check_deduction_table->id)->update([
                        'final_payable' => $final_payable, 'updated_by_id' => $log_in_user_id,  'book_date' => date('Y-m-d'),
                        'updated_by_name' => $log_in_user_name
                    ]);
                    if ($update_deduction_table) {
                        $response = 1;
                    }
                } else {
                    $response = Tercourier::add_voucher_payable($payable_data, $id, $log_in_user_id, $log_in_user_name, $payment_status, $final_payable);
                }
            } else {
                exit;
            }
        }
        // print_r($response);
        // exit;
        return [$response, $p_status];
    }

    public function pay_later_ter_now(Request $request)
    {
        $data = $request->all();
        // $payment_status = 2;
        $data['unique_id'] = $data['selected_id'];
        $check_deduction_table = DB::table('ter_deduction_settlements')->where('parent_ter_id', $data['unique_id'])->orderby("book_date", "DESC")->first();
        // echo "<pre>";
        // print_r($check_deduction_table);
        // exit;

        if (!empty($check_deduction_table)) {
            $total_payable_sum = $check_deduction_table->payable_amount;
            $emp_id = $check_deduction_table->employee_id;
            // echo "<pre>";
            // print_r($emp_id);
            // exit;

        } else {
            $data_ter = DB::table('tercouriers')->where('id', $data['unique_id'])->get()->toArray();
            $new_emp_id = '0' . $data_ter[0]->employee_id;
            $emp_id = $data_ter[0]->employee_id;
            $total_payable_sum = $data_ter[0]->final_payable;
        }
        $check = DB::table('sender_details')->where('employee_id', $emp_id)->get();
        $data['payment_status'] = 2;

        if (sizeof($check) == 0) {
            $check = DB::table('sender_details')->where('employee_id', $new_emp_id)->get();
            if (sizeof($check) != 0) {
                $emp_id = $new_emp_id;
            }
        }
        $get_current_balance = EmployeeBalance::select('current_balance')->where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
        if (!empty($get_current_balance)) {
            $data['current_balance'] = $get_current_balance->current_balance;
        } else {
            $data['current_balance'] = 0;
        }
        // print_r($data);
        // exit;
        $data['payable_data'] = "";
        $response = self::advance_payment_check($data, $total_payable_sum);
        // print_r($response);
        // print_r("Ds");
        // exit;
        if ($response[1] == '4') {
            return $response[0];
        } else {
            $res = self::api_call_finfect($data['selected_id']);
        }

        // print_r($res);
        // print_r("dss");
        // exit;

        if ($res != '1') {
            $get_emp_ledger = EmployeeLedgerData::where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
            $insert_data['ax_voucher_number'] = $get_emp_ledger->ax_voucher_number;
            $insert_data['ledger_balance'] = $get_emp_ledger->ledger_balance + $get_emp_ledger->ter_expense;
            $insert_data['wallet_id'] = 0;
            $insert_data['incoming_payment'] = 0;
            $insert_data['action_done'] = 'Payment_Failed';
            $insert_data['ter_expense'] = $get_emp_ledger->ter_expense;
            $insert_data['utilize_amount'] = 0;
            $insert_data['updated_date'] = date('Y-m-d');
            $insert_data['employee_id'] = $emp_id;
            $insert_data['ter_id'] = $get_emp_ledger->ter_id;
            $insert_data['user_id'] = $get_emp_ledger->user_id;
            $insert_data['user_name'] = $get_emp_ledger->user_name;
            $insert_data['created_at'] = date('Y-m-d H:i:s');
            $insert_data['updated_at'] = date('Y-m-d H:i:s');
            EmployeeLedgerData::insert($insert_data);

            $get_emp_acc = EmployeeBalance::where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
            if ($get_emp_acc->updated_date == date('Y-m-d') && $get_emp_ledger->ter_id == $get_emp_acc->ter_id) {
                $insert_emp_data['updated_date'] = date('Y-m-d');
                $insert_emp_data['employee_id'] = $emp_id;
                $insert_emp_data['advance_amount'] = 0;
                $insert_emp_data['ter_id'] = $get_emp_acc->ter_id;
                $insert_emp_data['ax_voucher_number'] = $get_emp_acc->ax_voucher_number;
                $insert_emp_data['utilize_amount'] = $get_emp_acc->utilize_amount;
                $insert_emp_data['current_balance'] = $get_emp_acc->utilize_amount + $get_emp_acc->current_balance;
                $insert_emp_data['action_done'] = 'Payment_Failed';
                $insert_emp_data['user_id'] = $get_emp_acc->user_id;
                $insert_emp_data['user_name'] = $get_emp_acc->user_name;
                $insert_emp_data['created_at'] = date('Y-m-d H:i:s');
                $insert_emp_data['updated_at'] = date('Y-m-d H:i:s');
                // return $insert_data;
                $table_update = EmployeeBalance::insert($insert_emp_data);
            }
        } else {
            $get_emp_ledger = EmployeeLedgerData::where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
            $advance_amt = $get_emp_ledger->ledger_balance + $get_emp_ledger->ter_expense;
            // dd($advance_amt);
            if ($data_ter[0]->status == 7) {
                if ($advance_amt > 0) {
                    DB::table('ter_deduction_settlements')->where('parent_ter_id', $id)->update(['advance_used' => $advance_amt]);
                }
            } else {
                if ($advance_amt > 0) {
                    DB::table('tercouriers')->where('id', $id)->update(['advance_used' => $advance_amt]);
                }
            }
        }
        return $res;
    }

    public function group_pay_now(Request $request)
    {
        $data = $request->all();
        $unique_ids = explode("|", $data['selected_id']);


        // $checkquery=DB::table('tercouriers')->select('amount','id')->whereIn('id',$unique_ids)->get()->toArray();
        // return $checkquery;

        foreach ($unique_ids as $key => $newdata) {
            $id = $newdata;
            $payment_status = 2;
            $api_call = self::api_call_finfect($id);
        }

        return $api_call;
    }

    public function api_call_finfect($id)
    {
        // return "hello";
        $check_deduction_table = DB::table('ter_deduction_settlements')->where('parent_ter_id', $id)->orderby("book_date", "DESC")->first();

        $settlement_deduction = 0;
        if (empty($check_deduction_table)) {
            $all_data = DB::table('tercouriers')->where('id', $id)->get()->toArray();
            if ($all_data[0]->payment_type == "full_and_final_payment") {
                if ($all_data[0]->final_payable == 0) {
                    $data['paid_date'] = date('Y-m-d');
                    $query =  DB::table('tercouriers')->where('id', $all_data[0]->id)
                        ->update(['paid_date' => $data['paid_date'], 'status' => 5, 'utr' => "paid by hr"]);
                    return "f&fpaid";
                } else {
                    $data['sent_to_finfect_date'] = date('Y-m-d');
                    $query =  DB::table('tercouriers')->where('id', $all_data[0]->id)
                        ->update(['sent_to_finfect_date' => $data['sent_to_finfect_date']]);
                }
            } else if ($all_data[0]->payment_type == "pay_later_payment") {
                $data['sent_to_finfect_date'] = date('Y-m-d');
                $query =  DB::table('tercouriers')->where('id', $all_data[0]->id)
                    ->update(['sent_to_finfect_date' => $data['sent_to_finfect_date']]);
            }

            // print_r($all_data[0]->payment_type);
            // exit;
            $tercourier_data = $all_data[0];
            $pay_amount = $tercourier_data->payable_amount;
            $voucher_code = $tercourier_data->voucher_code;
            $string_pay_amount = str_replace(array(
                '\'', '"', ';', '[', ']'
            ), ' ', $pay_amount);
            $string_voucher_code = str_replace(array(
                '\'', '"', ';', '[', ']'
            ), ' ', $voucher_code);
            $payable_new_data = explode(",", $string_pay_amount);
            $voucher_new_data = explode(",", $string_voucher_code);

            // $payable_sum = 0;
            $size = sizeof($payable_new_data);
            for ($i = 0; $i < $size; $i++) {
                $ax_data[$i]['amount'] = trim($payable_new_data[$i]);
                $ax_data[$i]['ax_voucher_code'] = trim($voucher_new_data[$i]);
                // $payable_sum = $payable_sum + $payable_new_data[$i];
            }
            $encoded_data = json_encode($ax_data);

            $payable_sum = $tercourier_data->final_payable;
            // if ($tercourier_data->txn_type == "rejected_ter") {      
            // $payable_sum = $tercourier_data->payable_amount;

            // }
            $emp_id = $tercourier_data->employee_id;
            $sender_id = $tercourier_data->sender_id;
            $sender_table = DB::table('sender_details')->where('employee_id', $emp_id)->get()->toArray();
            $sender_data = $sender_table[0];
            $ax_id = $tercourier_data->ax_id;
            $emp_name = $tercourier_data->sender_name;
            $amount = $tercourier_data->amount;
            $ter_id = $tercourier_data->id;
            $payment_type = $tercourier_data->payment_type;
            $get_emp_id = DB::table('tercouriers')->where('id', $id)->get();
            $emp_id = $get_emp_id[0]->employee_id;
            $iag_code = $get_emp_id[0]->iag_code;
            $pfu = $get_emp_id[0]->pfu;
        } else {
            $ax_id = $check_deduction_table->ax_code;
            $pfu = $check_deduction_table->pfu;
            $iag_code = $check_deduction_table->iag_code;
            $payable_sum = $check_deduction_table->final_payable;
            $voucher_code = $check_deduction_table->voucher_code;
            $ax_data[0]['amount'] = $check_deduction_table->payable_amount;
            $ax_data[0]['ax_voucher_code'] = $check_deduction_table->voucher_code;
            $encoded_data = json_encode($ax_data);
            $emp_id = $check_deduction_table->employee_id;
            $sender_table = DB::table('sender_details')->where('employee_id', $emp_id)->get()->toArray();
            $sender_data = $sender_table[0];
            $emp_name = $check_deduction_table->employee_name;
            $amount = $check_deduction_table->actual_amount;
            $ter_id = $check_deduction_table->parent_ter_id;
            $payment_type = "deduction_settlement";
            $settlement_deduction = 1;
            $data['sent_to_finfect_date'] = date('Y-m-d');
            $query =  DB::table('ter_deduction_settlements')->where('id', $check_deduction_table->id)
                ->update(['sent_to_finfect_date' => $data['sent_to_finfect_date'], 'status' => 3]);
        }




        // return $ax_id;

        // $sender_table = DB::table('sender_details')->where('employee_id', $emp_id)->get()->toArray();





        // if (empty($ax_id)) {
        //     $check_sender=$sender_table[0]->ax_id;
        //     if(empty($check_sender))
        //     {
        //     $ax_id = $sender_table[0]->iag_code;
        //     }
        //     else
        //     {
        //         $ax_id=$check_sender;
        //     }
        //     //  $ax_id=

        //   DB::table('tercouriers')->where('id', $id)->update(['ax_id' => $ax_id,'updated_at' => date('Y-m-d H:i:s')]);
        // }


        // $pfu="";
        // if (empty($pfu)) {
        //     DB::table('tercouriers')->where('id', $id)->update(['status' => 0, 'voucher_code' => "", "payable_amount" => "", "final_payable" => "", 'remarks' => 'pfu is not available', 'updated_at' => date('Y-m-d H:i:s')]);

        //     return "pfu_missing";
        // }

        // $ax_id="";



        if (empty($ax_id) && empty($iag_code)) {
            DB::table('tercouriers')->where('id', $id)->update(['status' => 0, 'voucher_code' => "", "payable_amount" => "", "final_payable" => "", 'remarks' => 'IAG/AX-ID is not available', 'updated_at' => date('Y-m-d H:i:s')]);

            return "Both ax_id and iag_code missing";
        }

        $character = "FA";

        if (!empty($ax_id)) {
            if (strpos($ax_id, $character) !== 0) {
                DB::table('tercouriers')->where('id', $id)->update(['status' => 0, 'voucher_code' => "", "payable_amount" => "", "final_payable" => "", 'remarks' => 'IAG/AX-ID is not available', 'updated_at' => date('Y-m-d H:i:s')]);

                return $ax_id . " AX-ID is not correct";
            }
        }

        if (!empty($iag_code)) {
            if (!is_numeric($iag_code)) {
                DB::table('tercouriers')->where('id', $id)->update(['status' => 0, 'voucher_code' => "", "payable_amount" => "", "final_payable" => "", 'remarks' => 'IAG/AX-ID is not available', 'updated_at' => date('Y-m-d H:i:s')]);

                return $iag_code . " IAG Code is not correct";
            }
        }

        if (empty($sender_data->account_number) || empty($sender_data->beneficiary_name) || empty($sender_data->bank_name) || empty($sender_data->ifsc)) {
            DB::table('tercouriers')->where('id', $id)->update(['status' => 0, 'voucher_code' => "", "payable_amount" => "", "final_payable" => "", 'remarks' => 'Bank Details are missing', 'updated_at' => date('Y-m-d H:i:s')]);

            return "bank_details_missing";
        }
        // $ter_id="3243534";
        // print_r($pfu);
        // print_r($ax_id);
        // exit;

        // if (!empty($ax_id)) {
        //     $new_data = explode("-", $ax_id);
        //     if ($new_data[0] == "FAMA") {
        //         $pfu = "MA2";
        //     } else if ($new_data[0] == "FAGMA") {
        //         $pfu = "MA4";
        //     } else if ($new_data[0] == "FAGSD") {
        //         $pfu = "SD3";
        //     } else if ($new_data[0] == "FAPL") {
        //         $pfu = "SD1";
        //     } else {
        //         exit;
        //     }
        // } else {
        //     return "AX_ID not Available";
        // }

        $url_header = $_SERVER['HTTP_HOST'];

        // Append the requested resource location to the URL
        //    $url.= $_SERVER['REQUEST_URI'];
        // $send_data = '{
        //     "unique_code":"'.$emp_id.'",
        //     "name":"'.$emp_name.'",
        //     "acc_no":"'.$sender_data->account_number.'",
        //     "beneficiary_name":"'.$sender_data->beneficiary_name.'",
        //     "ifsc":"'.$sender_data->ifsc.'",
        //     "bank_name":"'.$sender_data->bank_name.'",
        //     "baddress":"'.$sender_data->branch_name.'",
        //     "payable_amount":"'.$payable_sum.'",
        //     "claimed_amount":"'.$amount.'",
        //     "pfu":"'. $pfu .'",
        //     "ax_voucher_code":"'.$encoded_data.'",
        //     "txn_route":"TER",
        //     "email":"'.$sender_data->official_email_id.'",
        //     "terid":"'.$ter_id.'",
        //     "ptype":"'.$payment_type.'",
        //     "ax_id":"'.$ax_id.'"
        //     "territory":"'.$sender_data->territory.'"
        //   }';

        // print_r($send_data);
        // exit;
        //$sen_data_encode=json_encode($send_data);
        // return $sen_data_encode;

        $curl = curl_init();
        // $URL = \Config::get('services.FINFECT_KEY.finfect_url');
        // $URL=config('services.FINFECT_KEY.FINFECT_API_URL');
        // $url=env('FINFECT_API_URL');
        $url =    config('services.finfect_key.finfect_url');
        // print_r($url);
        // print_r('hello');
        // exit;
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            // CURLOPT_URL => 'https://finfect.biz/api/non_finvendors_payments',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            // CURLOPT_POSTFIELDS => [$send_data],
            CURLOPT_POSTFIELDS => "[{
                            \"unique_code\":\"$emp_id\",
                            \"name\":\"$emp_name\",
                            \"acc_no\":\"$sender_data->account_number\",
                            \"beneficiary_name\":\"$sender_data->beneficiary_name\",
                            \"ifsc\": \"$sender_data->ifsc\",
                            \"bank_name\":\"$sender_data->bank_name\",
                            \"baddress\":\"$sender_data->branch_name\",
                            \"payable_amount\": \"$payable_sum\",
                            \"claimed_amount\": \"$amount\" ,
                            \"pfu\": \"$pfu\",
                            \"ax_voucher_code\":$encoded_data,
                            \"txn_route\": \"TER\",
                            \"email\": \"$sender_data->official_email_id\",
                            \"terid\": \"$ter_id\",
                            \"ptype\": \"$payment_type\",
                            \"ax_id\":\"$ax_id\",
                            \"iag_code\":\"$iag_code\",
                            \"territory\":\"$sender_data->territory\"
                            }]",

            CURLOPT_HTTPHEADER => array(
                'Access-Control-Request-Headers:' . $url_header,
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        // echo "<pre>";
        // print_r($response);
        // die;
        curl_close($curl);
        // $response="";
        $res_data = json_decode($response);

        //    status needs to be checked before updating the finfect_response for deduction table
        if (!empty($res_data)) {
            if ($res_data->message == "success") {
                if ($settlement_deduction) {
                    $new_string['refrence_transaction_id'] = $res_data->refrence_transaction_id;
                    $new_data['finfect_response'] = $res_data->message;
                    $res = DB::table('ter_deduction_settlements')->where('id', $check_deduction_table->id)->update(array(
                        'reference_transaction_id' => $new_string['refrence_transaction_id'],
                        'finfect_response' => $new_data['finfect_response'], 'status' => 3
                    ));
                } else {
                    $new_string['refrence_transaction_id'] = $res_data->refrence_transaction_id;
                    $new_data['finfect_response'] = $res_data->message;
                    $res = DB::table('tercouriers')->where('id', $tercourier_data->id)->update(array(
                        'refrence_transaction_id' => $new_string['refrence_transaction_id'],
                        'finfect_response' => $new_data['finfect_response'], 'status' => 3, 'payment_status' => 1
                    ));
                }
            } else {
                if ($settlement_deduction) {
                    $new_data['finfect_response'] = $res_data->message;
                    $res = DB::table('ter_deduction_settlements')->where('id', $check_deduction_table->id)->update(array(
                        'finfect_response' => $new_data['finfect_response'],
                        'status' => 0
                    ));
                } else {
                    $new_data['finfect_response'] = $res_data->message;
                    $res = DB::table('tercouriers')->where('id', $tercourier_data->id)->update(array(
                        'finfect_response' => $new_data['finfect_response'], 'payment_status' => 2,
                        'status' => 0
                    ));
                }
                $res = [0, $new_data['finfect_response']];
            }
        } else {
            if ($settlement_deduction) {
                $new_data['finfect_response'] = "Finfect is down temporarily, please click Pay later. You can pay this TER once Finfect is Live.";
                $res = DB::table('ter_deduction_settlements')->where('id', $check_deduction_table->id)->update(array(
                    'finfect_response' => $new_data['finfect_response'],
                    'status' => 0
                ));
            } else {
                $new_data['finfect_response'] = "Finfect is down temporarily, please click Pay later. You can pay this TER once Finfect is Live.";
                $res = DB::table('tercouriers')->where('id', $tercourier_data->id)->update(array(
                    'finfect_response' => $new_data['finfect_response'], 'payment_status' => 2,
                    'status' => 0
                ));
            }
            $res = [0, $new_data['finfect_response']];
        }

        return $res;
    }



    public function show_pay_later_data(Request $request)
    {


        if (Auth::check()) {
            $query = Tercourier::query();

            $tercouriers = $query->where('payment_status', 2)->whereIn('status', [4, 0])->with('CourierCompany', 'SenderDetail')->orderby('id', 'DESC')->get();

            // echo'<pre>'; print_r($tercouriers->status); die;
            $role = "tr admin";
            return view('tercouriers.show-pay-later-data', ['tercouriers' => $tercouriers, 'role' => $role]);
        }
        //    echo'<pre>'; print_r($name); die;
    }

    public function cancel_ter(Request $request)
    {
        $req_param = $request->all();
        $data['remarks'] = $req_param['remarks'];
        $data['updated_id'] = $req_param['ter_id'];
        $get_old_status = DB::table('tercouriers')->select('status')->where('id', $req_param['ter_id'])->get();
        if ($get_old_status[0]->status == 1) {
            $data['old_status'] = "Received";
        } else if ($get_old_status[0]->status == 2) {
            $data['old_status'] = "Handover";
        } else if ($get_old_status[0]->status == 0) {
            $data['old_status'] = "Failed";
        }
        $data['updated_date'] = date('Y-m-d');
        $details = Auth::user();
        $data['updated_by_user_id'] = $details->id;
        $data['updated_by_user_name'] = $details->name;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        if ($data['remarks'] != "") {
            $response = DB::table('tercouriers')->where('id', $req_param['ter_id'])->update([
                "status" => "6", "updated_by_id" => $data['updated_by_user_id'],
                "updated_by_name" => $data['updated_by_user_name'], 'updated_at' => $data['updated_at']
            ]);
            if ($response) {
                $res = DB::table('ter_data_cancel')->insert($data);
                return $res;
            }
        } else {
            $res = 0;
            return $res;
        }
    }

    public function check_duplicate_voucher_code($voucher_code)
    {
        /////////////////////////////////////////////// Start of duplicate voucher check /////////////////////////////////////////////////////////////////////////

        $data['voucher_code'] = $voucher_code;

        $decode2 = array();
        $check_duplicate = DB::table('tercouriers')->select('voucher_code')->whereIn('status', [3, 5])->get();
        // echo "<pre>";
        // print_r($check_duplicate);
        // exit;
        $voucher_code_size = sizeof($check_duplicate);
        // this is for previous flow
        for ($i = 0; $i < $voucher_code_size; $i++) {
            if ($check_duplicate[$i]->voucher_code == $data['voucher_code']) {
                return ["duplicate_voucher", $data['voucher_code']];
            }
        }
        for ($i = 0; $i < $voucher_code_size; $i++) {
            $decode2[$i] = json_decode($check_duplicate[$i]->voucher_code);
            // print_r($decode2[$i]);
            if (!empty($decode2[$i])) {
                if (gettype($decode2[$i]) == "array") {
                    if (sizeof($decode2[$i]) > 1) {
                        // print_r("rt");
                        for ($j = 0; $j < sizeof($decode2[$i]); $j++) {
                            if ($decode2[$i][$j] == $data['voucher_code']) {
                                return ["duplicate_voucher", $data['voucher_code']];
                            }
                        }
                    } else {
                        // echo "<pre>";
                        // print_r($decode2)
                        // print_r($data['voucher_code'][$l]);
                        // print_r($decode2[$i][0]);
                        // exit;

                        if ($decode2[$i][0] == $data['voucher_code']) {
                            return ["duplicate_voucher", $data['voucher_code']];
                            // exit;
                        }
                    }
                } else {
                    // return $decode2;
                    if ($decode2[0] == $data['voucher_code']) {
                        return ["duplicate_voucher", $data['voucher_code']];
                        // exit;
                    }
                }
            }
        }
        // exit;


        // $check_duplicate = DB::table('ter_deduction_settlements')->select('voucher_code')->whereIn('status', [3, 5])->get();
        $check_duplicate = DB::table('ter_deduction_settlements')->select('voucher_code')->where('status', 3)->get();
        $voucher_code_size = sizeof($check_duplicate);
        // print_r($voucher_code_size);
        // exit;
        // this is for ter_deduction_settlements table check
        for ($i = 0; $i < $voucher_code_size; $i++) {
            if ($check_duplicate[$i]->voucher_code == $data['voucher_code']) {
                return ["duplicate_voucher", $data['voucher_code']];
            }
        }

        return 1;

        //////////////////////////////////////////////////// end of duplicate voucher check ////////////////////////////////////////////////////////////////////////////////////////////////
    }


    public function update_rejected_ter(Request $request)
    {
        $data = $request->all();
        // $check_duplicate = self::check_duplicate_voucher_code($data['voucher_code']);
        // echo "<pre>";
        // print_r($check_duplicate);
        // exit;
        // if (gettype($check_duplicate) == "array") {
        //     return $check_duplicate;
        // }

        $image = $request->file('file');
        $fileName = $image->getClientOriginalName();
        $destinationPath = 'rejected_ter_uploads';
        $image->move($destinationPath, $fileName);

        // $get_ter_data=DB::table('tercouriers')->where('id',$data['ter_id'])->get();
        $details = Auth::user();

        if ($data['ter_type'] == 'cancel') {
            $insert['cancel_reject'] = 1;
        }

        if ($data['ter_type'] == 'accept') {
            $insert['cancel_reject'] = 0;
        }


        // $insert['payable_amount'][0] = $data['payable_amount'];
        // $insert['voucher_code'][0] = $data['voucher_code'];
        $insert['book_date'] = date('Y-m-d');
        $insert['payment_type'] = "ter_rejected";
        $insert['remarks'] = $data['remarks'];
        $insert['file_name'] = $fileName;
        $insert['saved_by_name'] = $details->name;
        $insert['saved_by_id'] = $details->id;
        $insert['created_at'] = date('Y-m-d H:i:s');
        $insert['updated_at'] = date('Y-m-d H:i:s');
        $id = $data['ter_id'];

        $check = DB::table('tercouriers')->where('id', $id)->get();
        if ($check[0]->status == 10) {
            $insert['status'] = 8;
        }
        $update_details = DB::table('tercouriers')->where('id', $id)->update($insert);

        //    if($update_details)
        //    {
        //  $res=   DB::table('tercouriers')->where('id',$data['ter_id'])->update(['status'=>7,'updated_by_id'=>$details->id,
        //     'updated_by_name'=>$details->name]);
        //    }

        // $t=Storage::disk('local')->put($fileName, 'Contents');
        return $update_details;
    }

    public function update_ter_deduction(Request $request)
    {
        $data = $request->all();
        $res = "";
        $check_duplicate = self::check_duplicate_voucher_code($data['voucher_code']);
        // echo "<pre>";
        // print_r($check_duplicate);
        // exit;
        if (gettype($check_duplicate) == "array") {
            return $check_duplicate;
        }
        $image = $request->file('file');
        $fileName = $image->getClientOriginalName();
        $destinationPath = 'uploads';
        $image->move($destinationPath, $fileName);
        $get_ter_data = DB::table('tercouriers')->where('id', $data['ter_id'])->get();
        $details = Auth::user();

        $sender_info = DB::table('sender_details')->where('employee_id', $get_ter_data[0]->employee_id)->get();

        $insert['pfu'] = $get_ter_data[0]->pfu;
        $insert['iag_code'] = $get_ter_data[0]->iag_code;
        $insert['ax_code'] = $get_ter_data[0]->ax_id;


        if (empty($insert['ax_code'])) {
            $insert['ax_code'] = $sender_info[0]->ax_id;
        }

        if (empty($insert['pfu'])) {
            $insert['pfu'] = $sender_info[0]->pfu;
        }
        if (empty($insert['iag_code'])) {
            $insert['iag_code'] = $sender_info[0]->iag_code;
        }
        $insert['parent_ter_id'] = $data['ter_id'];
        $insert['employee_name'] = $get_ter_data[0]->sender_name;
        $insert['employee_id'] = $get_ter_data[0]->employee_id;
        $insert['terfrom_date'] = $get_ter_data[0]->terfrom_date;
        $insert['terto_date'] = $get_ter_data[0]->terto_date;
        $insert['actual_amount'] = $data['actual_amount'];
        $insert['prev_payable_sum'] = $data['prev_payable_sum'];
        $insert['left_amount'] = $data['left_amount'];
        $insert['payable_amount'] = $data['payable_amount'];
        $insert['voucher_code'] = $data['voucher_code'];
        $insert['book_date'] = date('Y-m-d');
        $insert['payment_type'] = "deduction_setllement";
        $insert['remarks'] = $data['remarks'];
        $insert['file_name'] = $fileName;
        $insert['saved_by_name'] = $details->name;
        $insert['saved_by_id'] = $details->id;
        $insert['created_at'] = date('Y-m-d H:i:s');
        $insert['updated_at'] = date('Y-m-d H:i:s');
        $actual_id = $data['ter_id'];
        // $actual_id = 46;

        $check_id_exist = DB::table('ter_deduction_settlements')->select("*")->where('parent_ter_id', $actual_id)->first();

        if ($check_id_exist != null || $check_id_exist != '') {
            $update_details = TerDeductionSettlement::where('id', $check_id_exist->id)->update([
                'remarks' => $insert['remarks'],
                'payable_amount' => $insert['payable_amount'], 'voucher_code' => $insert['voucher_code'],
                'file_name' => $insert['file_name'], 'status' => 7
            ]);
            // return "Ds";
        } else {
            $update_details = TerDeductionSettlement::insert($insert);
        }
        // dd($update_details);
        if ($update_details) {
            $res =   DB::table('tercouriers')->where('id', $data['ter_id'])->update([
                'status' => 7, 'updated_by_id' => $details->id,
                'updated_by_name' => $details->name
            ]);
        }

        // $t=Storage::disk('local')->put($fileName, 'Contents');
        return $res;
    }



    public function check_deduction(Request $request)
    {
        $req_param = $request->all();
        $id = $req_param['ter_id'];
        $data = DB::table('tercouriers')->where('id', $id)->get();
        $payable =  $data[0]->payable_amount;
        $actual_amount = $data[0]->amount;
        $decode_payable = json_decode($payable);
        if (gettype($decode_payable) == "array") {
            $payable_sum = array_sum($decode_payable);
        } else {
            $payable_sum = $decode_payable;
        }
        if ($actual_amount > $payable_sum) {
            $difference = $actual_amount - $payable_sum;
        } else {
            return 0;
        }

        return ["success", $difference, $actual_amount, $payable_sum];

        //   print_r($actual_amount);
        //   print_r("payable");
        //   print_r($payable_sum);
        //   print_r("difference");
        //   print_r($difference);
        //   exit;

    }


    public function update_emp_details(Request $request)
    {
        // unknown_function
        $data = $request->all();
        // $update_data['hr_admin_remark']=$data['remarks'];
        // $update_data['sender_name']=$data['emp_name'];
        // $update_data['employee_id']=$data['emp_id'];
        // $update_data['ax_id']=$data['ax_id'];
        $id = $data['id'];
        // return $data['emp_id'];
        $get_sender_data = DB::table('sender_details')->where('employee_id', $data['emp_id'])->get();
        $sender_id = $get_sender_data[0]->id;
        $get_ter_data = DB::table('tercouriers')->where('id', $id)->get();
        $check_rejected = $get_ter_data[0]->is_rejected;


        if ($check_rejected == '1') {
            $tercourier_table = DB::table('tercouriers')->where('id', $id)->update([
                'hr_admin_remark' => $data['remarks'],
                'sender_name' => $data['emp_name'], 'employee_id' => $data['emp_id'], 'ax_id' => $data['ax_id'],
                'pfu' => $get_sender_data[0]->pfu,
                'sender_id' => $sender_id, 'status' => 8, 'txn_type' => 'rejected_ter', 'given_to' => 'TER-Team'
            ]);
        } else {
            $tercourier_table = DB::table('tercouriers')->where('id', $id)->update([
                'hr_admin_remark' => $data['remarks'],
                'sender_name' => $data['emp_name'], 'employee_id' => $data['emp_id'], 'ax_id' => $data['ax_id'], 'iag_code' => $get_sender_data[0]->iag_code,
                'pfu' => $get_sender_data[0]->pfu, 'sender_id' => $sender_id, 'status' => 2, 'given_to' => 'TER-Team'
            ]);
        }

        $live_host_name = request()->getHttpHost();

        if ($live_host_name == 'localhost:8000' || $live_host_name == "test-courier.easemyorder.com") {
            return 1;
        } else {


            if ($tercourier_table) {

                $getsender = Sender::where('employee_id', $data['emp_id'])->first();

                $API = "cBQcckyrO0Sib5k7y9eUDw"; // GET Key from SMS Provider
                $peid = "1201159713185947382"; // Get Key from DLT
                $sender_id = "FAPLHR"; // Approved from DLT
                $mob = $getsender->telephone_no; // Get Mobile Number from Sender
                // $mob = '9569096896'; // Get Mobile Number from Sender
                $name = $getsender->name;
                // print_r($getsender);
                // exit;


                $from_period = Helper::ShowFormat($get_ter_data[0]->terfrom_date);
                $to_period = Helper::ShowFormat($get_ter_data[0]->terto_date);

                $UNID = $get_ter_data[0]->id;
                $umsg = "Dear $name , your TER for Period $from_period to $to_period has been received and is under process. TER UNID is $UNID Thanks! Frontiers";

                $url = 'http://sms.innuvissolutions.com/api/mt/SendSMS?APIkey=' . $API . '&senderid=' . $sender_id . '&channel=Trans&DCS=0&flashsms=0&number=' . urlencode($mob) . '&text=' . urlencode($umsg) . '&route=2&peid=' . urlencode($peid) . '';

                $this->SendTSMS($url);


                self::send_unknown_mail($UNID);
                //   Mail::to($getsender->personal_email_id)->send(new SendUnknownMail($getsender));


            }
        }




        return 1;
    }

    public static function active_employees($getsender)
    {

        // $last_working_date=$getsender[0]->last_working_date;
        $today_date = date('Y-m-d');

        // echo "<pre>";
        // print_r($getsender->name);
        // exit;

        $final_date = "";
        $final_date = date_create($today_date);
        date_add($final_date, date_interval_create_from_date_string("14 days"));
        $last_date = date_format($final_date, "d-F-Y");
        // $last_date = Helper::ShowFormatDate($date_form);

        $save_date = "";
        $save_date = date_create($today_date);
        date_add($save_date, date_interval_create_from_date_string("44 days"));
        $save_last_date = date_format($save_date, "d-F-Y");
        // $save_last_date= date('F', strtotime($save_date_form));
        // $save_last_date = Helper::ShowFormatDate($save_date_form);

        // last_mail_date
        $mail_date = "";
        $mail_date = date_create($today_date);
        date_add($mail_date, date_interval_create_from_date_string("46 days"));
        $saved_last_mail_date = date_format($mail_date, "d-F-Y");
        // $saved_last_mail_date = Helper::ShowFormatDate($last_mail_date);

        $TER_month = "";
        $TER_month = date_create($today_date);
        date_add($TER_month, date_interval_create_from_date_string("-25 days"));
        $ter_date_form = date_format($TER_month, "d-m-Y");
        $ter_last_month = Helper::ShowFormatDate($ter_date_form);
        $Month_name = date('F', strtotime($ter_last_month));
        $get_month = explode("-", $ter_last_month);
        $ter_month =   $get_month[1];


        // echo "<pre>";
        // print_r($Month_name);
        // exit;


        $data["title"] = "Reminder to submit TER CLAIM for " . $Month_name . "-" . $get_month[2];
        // return $data['title'];

        // $data["email"] = "dhroov.kanwar@eternitysolutions.net";
        $data["email"] = $getsender->official_email_id;
        $data['employee_name'] = $getsender->name;
        $data['employee_id'] = $getsender->employee_id;
        $data['body'] = "Please prepare your Travel Expense Reimbursement Claim (TER Claim) for the month of " . $Month_name . "-" . $get_month[2] . ".";
        $data['body_2'] = "Ensure that the TER reaches the head office by " . $last_date . " to avoid deduction of Rs.200 as late fine.";
        // return  $employee_name;

        // return view('emails.TerSubmissionMail1',['body'=>$data['body'],'body_2'=>$data['body_2'],'title'=>$data['title'],'employee_id'=> $data['employee_id'],'employee_name'=> $data['employee_name']]);

        $check_mail_tracker = EmployeeMailTracker::where('employee_id', $getsender->employee_id)->where('ter_received', '0')->where('ter_month', $ter_month)->orderby('id', 'desc')->first();



        $emp_data['employee_id'] = $getsender->employee_id;
        $emp_data['ter_month'] = $ter_month;
        $emp_data['mail_date'] = $today_date;
        $emp_data['mail_number'] = '1';
        $emp_data['mail_sent'] = '1';
        $emp_data['saved_last_date'] = $save_last_date;
        $emp_data['last_mail_date'] = $saved_last_mail_date;

        $mail_not_sent['employee_id'] = $getsender->employee_id;
        $mail_not_sent['emp_email'] = $getsender->official_email_id;
        $mail_not_sent['mail_response'] = "";
        $mail_not_sent['mail_date'] = $today_date;



        if (empty($check_mail_tracker)) {

            if (true) {
               if(!empty($data["email"]) && $data["email"] != 0) {

           
                    $t =  Mail::mailer('smtp2')->send('emails.TerSubmissionMail1', $data, function ($message) use ($data) {
                        $message->to($data["email"], $data["email"])
                            ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                            ->subject($data["title"])
                            ->cc(config('services.cc_email.email_id'));
                    });
                    if (Mail::failures()) {
                        $mail_not_sent['mail_response'] = "No Email Id Found";
                        $res = MailnotSent::create($mail_not_sent);
                    }else{
                        $res = EmployeeMailTracker::create($emp_data);
                    }
                
                    
                } else {
                    // dd("f");
                    // print_r("DS");
                    $mail_not_sent['mail_response'] = "No Email Id Found";
                    $res = MailnotSent::create($mail_not_sent);
                }
            }
        } else {
            if ($check_mail_tracker->ter_month != $ter_month) {

                if(!empty($data["email"]) && $data["email"] != 0) {
                  
                    Mail::mailer('smtp2')->send('emails.TerSubmissionMail1', $data, function ($message) use ($data) {
                        $message->to($data["email"], $data["email"])
                            ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                            ->subject($data["title"])
                            ->cc(config('services.cc_email.email_id'));
                    });
                    if (Mail::failures()) {
                        $mail_not_sent['mail_response'] = "No Email Id Found";
                        $res = MailnotSent::create($mail_not_sent);
                    }else{
                        $res = EmployeeMailTracker::create($emp_data);
                    }

                    $res = EmployeeMailTracker::create($emp_data);
                } else {
                    // dd("f");
                    // print_r("DS");
                    $mail_not_sent['mail_response'] = 'No Email Id Found';
                    $res = MailnotSent::create($mail_not_sent);
                }
            }
        }



        return 1;
    }





    public function send_employee_mails()
    {
        ini_set('max_execution_time', -1);
        $live_host_name = request()->getHttpHost();


        if ($live_host_name == 'localhost:8000' || $live_host_name == "test-courier.easemyorder.com") {
            return "not possible";
        }
        //  2446,2437

        //   self::send_reject_mail(2437);
        //         self::send_unknown_mail('2308');
        //  return 33;
        $today_date = date('Y-m-d');
        // $today_date = date('2023-03-01');
        $final_date = "";


        $date_number = explode("-", $today_date);


        // start of final mail
        $check_date = date_create($today_date);
        $check_date_result = date_format($check_date, "d-F-Y");

        $check_details = EmployeeMailTracker::where('ter_received', '0')->where('last_mail_date', $check_date_result)->where('mail_number', '4')->get();


        if (!empty($check_details)) {

            // ter_reject

            $final_date = date_create($today_date);
            date_add($final_date, date_interval_create_from_date_string("-47 days"));
            $date_form = date_format($final_date, "d-m-Y");
            $last_date = Helper::ShowFormatDate($date_form);


            $check_date_month = date_format($final_date, "d-F-Y");
            $get_date_month_full = explode("-", $check_date_month);
            $get_ter_month = $get_date_month_full[1];

            $get_month = explode("-", $last_date);
            $ter_month = $get_month[1];
            // return $ter_month;

            // $mail_num = 4;

            // $get_details = EmployeeMailTracker::where('ter_received', '0')->where('ter_month', $ter_month)->where('mail_number', $mail_num)->get();
            $size = sizeof($check_details);


            for ($i = 0; $i < $size; $i++) {

                $check_ter_table = Tercourier::where('employee_id', $check_details[$i]->employee_id)->orderby('id', 'desc')->first();
                if (!empty($check_ter_table)) {
                    $check_ter_month = Helper::ShowFormatDate($check_ter_table->terto_date);
                    $month = explode("-", $check_ter_month);
                    if ($month[1] == $ter_month) {
                        $id = $check_details[$i]->id;
                        $res = EmployeeMailTracker::where('id', $id)->update(['ter_received' => '1']);
                    } else {
                        // return "FD";
                        // print_r($month[1]);

                        $getsender = Sender::where('employee_id', $check_details[$i]->employee_id)->get();


                        $data["title"] = "Rejection of TER for " . $get_ter_month . "-" . $get_month[2];

                        // $data["email"] = "itsupport@frontierag.com";
                        $data["email"] = $getsender[0]->official_email_id;
                        $data['employee_name'] = $getsender[0]->name;
                        $data['employee_id'] = $getsender[0]->employee_id;
                        // $data['body'] = "This is to inform you that you have failed to submit your TER for " . $ter_month . " till " . $check_details[$i]->saved_last_date . ". We presume you do not have any travel expense to claim for the month of " . $ter_month . ". The time period of 45 days for submission has been expired. TER claim received for " . $ter_month . " will not be paid.";
                        $data['body'] = "This is to inform you that you have failed to submit your Travel Expense Reimbursement (TER) to HO " . $get_ter_month . "-" . $get_month[2] . " till " . $check_details[$i]->saved_last_date . " . We presume you do not have any travel expense to claim for the month of " . $get_ter_month . "-" . $get_month[2] . " . The time of 45 days for submission has expired. TER Claim received for " . $get_ter_month . "-" . $get_month[2] . " will not be paid. ";
                        $data['body_2'] = "In future, please ensure to timely submit your claims to avoid any fine /rejection of your TER claim.";
                        // return   $data["title"];

                        // return view('emails.CancelTerSubmissionMail', ['body' => $data['body'], 'title' => $data['title'], 'employee_id' => $data['employee_id'], 'employee_name' => $data['employee_name'], 'body_2' => $data['body_2']]);
                        $check_mail_tracker = EmployeeMailTracker::where('employee_id', $check_details[$i]->employee_id)->where('ter_received', '0')->where('ter_month', $ter_month)->orderby('id', 'desc')->first();

                        $check_mail_sent = EmployeeMailTracker::where('employee_id', $check_details[$i]->employee_id)->where('ter_received', '1')->where('ter_month', $ter_month)->orderby('id', 'desc')->first();
                        if (!empty($check_mail_sent)) {
                        } else {

                            $emp_data['last_mail_date'] = $check_details[$i]->last_mail_date;
                            $emp_data['employee_id'] = $getsender[0]->employee_id;
                            $emp_data['ter_month'] = $ter_month;
                            $emp_data['mail_date'] = $today_date;
                            $emp_data['mail_sent'] = '1';
                            $emp_data['saved_last_date'] = $check_details[$i]->saved_last_date;
                            $emp_data['mail_number'] = '5';
                            $emp_data['ter_received'] = '1';
                            $emp_data['ter_reject'] = '1';



                            if ($check_mail_tracker->mail_number == 4 && $check_mail_tracker->mail_sent == 1) {
                                if(!empty($data["email"]) && $data["email"] != 0) {
                                    if (true) {
                                        Mail::mailer('smtp2')->send('emails.CancelTerSubmissionMail', $data, function ($message) use ($data) {
                                            $message->to($data["email"], $data["email"])
                                                ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                                                ->subject($data["title"])
                                                ->cc(config('services.cc_email.email_id'));
                                        });
                                    }

                                    $res =  EmployeeMailTracker::create($emp_data);
                                } else {
                                    // dd("f");
                                    // print_r("DS");
                                    $mail_not_sent['mail_response'] = 'No Email Id Found';
                                    $res = MailnotSent::create($mail_not_sent);
                                }
                            }
                        }
                    }
                } else {
                    // return "FD";
                    // print_r($month[1]);

                    $getsender = Sender::where('employee_id', $check_details[$i]->employee_id)->get();


                    $data["title"] = "Rejection of TER for " . $get_ter_month . "-" . $get_month[2];

                    // $data["email"] = "itsupport@frontierag.com";
                    $data["email"] = $getsender[0]->official_email_id;
                    $data['employee_name'] = $getsender[0]->name;
                    $data['employee_id'] = $getsender[0]->employee_id;
                    // $data['body'] = "This is to inform you that you have failed to submit your TER for " . $ter_month . " till " . $check_details[$i]->saved_last_date . ". We presume you do not have any travel expense to claim for the month of " . $ter_month . ". The time period of 45 days for submission has been expired. TER claim received for " . $ter_month . " will not be paid.";
                    $data['body'] = "This is to inform you that you have failed to submit your Travel Expense Reimbursement (TER) to HO " . $get_ter_month . "-" . $get_month[2] . " till " . $check_details[$i]->saved_last_date . " . We presume you do not have any travel expense to claim for the month of " . $get_ter_month . "-" . $get_month[2] . " . The time of 45 days for submission has expired. TER Claim received for " . $get_ter_month . "-" . $get_month[2] . " will not be paid. ";
                    $data['body_2'] = "In future, please ensure to timely submit your claims to avoid any fine /rejection of your TER claim.";
                    // return   $data["title"];

                    // return view('emails.CancelTerSubmissionMail', ['body' => $data['body'], 'title' => $data['title'], 'employee_id' => $data['employee_id'], 'employee_name' => $data['employee_name'], 'body_2' => $data['body_2']]);
                    $check_mail_tracker = EmployeeMailTracker::where('employee_id', $check_details[$i]->employee_id)->where('ter_received', '0')->where('ter_month', $ter_month)->orderby('id', 'desc')->first();

                    $check_mail_sent = EmployeeMailTracker::where('employee_id', $check_details[$i]->employee_id)->where('ter_received', '1')->where('ter_month', $ter_month)->orderby('id', 'desc')->first();
                    if (!empty($check_mail_sent)) {
                    } else {

                        $emp_data['last_mail_date'] = $check_details[$i]->last_mail_date;
                        $emp_data['employee_id'] = $getsender[0]->employee_id;
                        $emp_data['ter_month'] = $ter_month;
                        $emp_data['mail_date'] = $today_date;
                        $emp_data['mail_sent'] = '1';
                        $emp_data['saved_last_date'] = $check_details[$i]->saved_last_date;
                        $emp_data['mail_number'] = '5';
                        $emp_data['ter_received'] = '1';
                        $emp_data['ter_reject'] = '1';



                        if ($check_mail_tracker->mail_number == 4 && $check_mail_tracker->mail_sent == 1) {
                            if(!empty($data["email"]) && $data["email"] != 0) {
                                if (true) {
                                    Mail::mailer('smtp2')->send('emails.CancelTerSubmissionMail', $data, function ($message) use ($data) {
                                        $message->to($data["email"], $data["email"])
                                            ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                                            ->subject($data["title"])
                                            ->cc(config('services.cc_email.email_id'));
                                    });
                                }

                                $res =  EmployeeMailTracker::create($emp_data);
                            } else {
                                // dd("f");
                                // print_r("DS");
                                $mail_not_sent['mail_response'] = 'No Email Id Found';
                                $res = MailnotSent::create($mail_not_sent);
                            }
                        }
                    }
                }
            }
        }
        // end of final mail


        if ($date_number[2] == "01") {

            $getsender = Sender::where('status', 'Active')->get();
            // $getsender = Sender::whereIN('id', ['1946','3'])->get();
            // $getsender = Sender::whereIN('id', ['1753'])->get();

            // echo "<pre>";
            // print_r($getsender);
            // exit;
            // MARKET DEVELOPMENT REPRESENTATIVE
            for ($i = 0; $i < sizeof($getsender); $i++) {

                // echo"<pre>";
                // print_r(strtolower($getsender[$i]->designation));
                // exit;
                $designation_check = "";
                $designation_check = strtolower($getsender[$i]->designation);
                if (
                    $designation_check == 'market development representative' ||
                    $designation_check == 'field executive'
                    || $designation_check == 'project officer'
                ) {
                } else {
                    if (empty($last_working_date)) {

                        $res =   self::active_employees($getsender[$i]);
                        // return $res;
                    } else {
                        $last_working_date = $getsender[0]->last_working_date;
                        $month_number = explode("-", $last_working_date);
                        $final_exit_date = $month_number[2] . '-' . $month_number[1] . '-' . $month_number[0];

                        if (ctype_alpha($month_number[1])) {
                            switch ($month_number[1]) {
                                case "Jan":
                                    $month_number[1] = '01';
                                    break;
                                case "Feb":
                                    $month_number[1] = '02';
                                    break;
                                case "Mar":
                                    $month_number[1] = '03';
                                    break;
                                case "Apr":
                                    $month_number[1] = '04';
                                    break;
                                case "May":
                                    $month_number[1] = '05';
                                    break;
                                case "Jun":
                                    $month_number[1] = '06';
                                case "Jul":
                                    $month_number[1] = '07';
                                    break;
                                case "Aug":
                                    $month_number[1] = '08';
                                    break;
                                case "Sep":
                                    $month_number[1] = '09';
                                    break;
                                case "Oct":
                                    $month_number[1] = '10';
                                    break;
                                case "Nov":
                                    $month_number[1] = '11';
                                    break;
                                case "Dec":
                                    $month_number[1] = '12';
                                    break;
                            }


                            if ($final_exit_date >= $today_date) {
                                $res =  self::active_employees($getsender[$i]);
                            }
                        } else {
                            if ($final_exit_date >= $today_date) {
                                $res =  self::active_employees($getsender[$i]);
                            }
                        }
                    }
                }
            }
            // return $res;
            return 1;
        }

        if ($date_number[2] == "17" || $date_number[2] == "27" || $date_number[2] == "08") {
            //  return "DS";
            if ($date_number[2] == "17" || $date_number[2] == "27") {
                $final_date = date_create($today_date);
                date_add($final_date, date_interval_create_from_date_string("-30 days"));
                $date_form = date_format($final_date, "d-m-Y");
                $last_date = Helper::ShowFormatDate($date_form);
            }

            if ($date_number[2] == "08") {
                $final_date = date_create($today_date);
                date_add($final_date, date_interval_create_from_date_string("-60 days"));
                $date_form = date_format($final_date, "d-m-Y");
                $last_date = Helper::ShowFormatDate($date_form);
            }


            $get_month = explode("-", $last_date);
            $ter_month = $get_month[1];
            $Month_name = date('F', strtotime($last_date));

            if ($date_number[2] == "17") {
                $mail_num = 1;
                $reminder = 1;
            }
            if ($date_number[2] == "27") {
                $mail_num = 2;
                $reminder = 2;
            }
            if ($date_number[2] == "08") {
                $mail_num = 3;
                $reminder = 3;
            }
            $get_details = EmployeeMailTracker::where('ter_received', '0')->where('ter_month', $ter_month)->where('mail_number', $mail_num)->get();
            $size = sizeof($get_details);

            // return $ter_month;
            for ($i = 0; $i < $size; $i++) {
                // return "DFs";
                $check_ter_table = Tercourier::where('employee_id', $get_details[$i]->employee_id)->orderby('id', 'desc')->first();
                // return "DFs";
                if (!empty($check_ter_table)) {

                    $check_ter_month = Helper::ShowFormatDate($check_ter_table->terto_date);
                    $month = explode("-", $check_ter_month);
                    if ($month[1] == $ter_month) {
                        $id = $get_details[$i]->id;
                        $res = EmployeeMailTracker::where('id', $id)->update(['ter_received' => '1']);
                    } else {
                        // return "FD2";
                        // print_r($month[1]);

                        $getsender = Sender::where('employee_id', $get_details[$i]->employee_id)->get();


                        $data["title"] = "Alert: Reminder " . $reminder . ", TER Claim not submitted for  " . $Month_name . "-" . $get_month[2];

                        // $data["email"] = "itsupport@frontierag.com";
                        $data["email"] = $getsender[0]->official_email_id;
                        $data['employee_name'] = $getsender[0]->name;
                        $data['employee_id'] = $getsender[0]->employee_id;
                        $data['body'] = "This is to remind you that we have not received your TER Claim for " . $Month_name . "-" . $get_month[2] . ". Please ensure the TER Claim is submitted by " . $get_details[$i]->saved_last_date . " to HO. ";

                        $data['body_2'] = "In case TER claim for " . $Month_name . "-" . $get_month[2] . " is not submitted at HO by " . $get_details[$i]->saved_last_date . " then no TER Claim for " . $Month_name . "-" . $get_month[2] . " will be payable.";
                        // return   $data["title"] ;

                        // return view('emails.CommonTerSubmissionMail',['body'=>$data['body'],'title'=>$data['title'],'employee_id'=> $data['employee_id'],'employee_name'=> $data['employee_name'],'body_2'=>$data['body_2']]);
                        $check_mail_tracker = EmployeeMailTracker::where('employee_id', $get_details[$i]->employee_id)->where('ter_received', '0')->where('ter_month', $ter_month)->orderby('id', 'desc')->first();
                        $emp_data['employee_id'] = $getsender[0]->employee_id;
                        $emp_data['ter_month'] = $ter_month;
                        $emp_data['mail_date'] = $today_date;
                        $emp_data['mail_sent'] = '1';
                        $emp_data['saved_last_date'] = $get_details[$i]->saved_last_date;
                        $emp_data['last_mail_date'] = $get_details[$i]->last_mail_date;
                        // return   $data["title"] ;




                        if ($date_number[2] == "17") {
                            $emp_data['mail_number'] = '2';

                            if ($check_mail_tracker->mail_number == 1 && $check_mail_tracker->mail_sent == 1) {
                                if(!empty($data["email"]) && $data["email"] != 0) {
                                    if (true) {
                                        Mail::mailer('smtp2')->send('emails.CommonTerSubmissionMail', $data, function ($message) use ($data) {
                                            $message->to($data["email"], $data["email"])
                                                ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                                                ->subject($data["title"])
                                                ->cc(config('services.cc_email.email_id'));
                                        });
                                    }

                                    $res =  EmployeeMailTracker::create($emp_data);
                                } else {
                                    // dd("f");
                                    // print_r("DS");
                                    $mail_not_sent['mail_response'] = 'No Email Id Found';
                                    $res = MailnotSent::create($mail_not_sent);
                                }
                            }
                        }

                        // return view('emails.CommonTerSubmissionMail',['body'=>$data['body'],'title'=>$data['title'],'employee_id'=> $data['employee_id'],'employee_name'=> $data['employee_name'],'body_2'=>$data['body_2']]);


                        if ($date_number[2] == "27") {
                            $emp_data['mail_number'] = '3';
                            if ($check_mail_tracker->mail_number == 2 && $check_mail_tracker->mail_sent == 1) {
                                if(!empty($data["email"]) && $data["email"] != 0) {

                                    if (true) {
                                        Mail::mailer('smtp2')->send('emails.CommonTerSubmissionMail', $data, function ($message) use ($data) {
                                            $message->to($data["email"], $data["email"])
                                                ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                                                ->subject($data["title"])
                                                ->cc(config('services.cc_email.email_id'));
                                        });
                                    }
                                    $res =  EmployeeMailTracker::create($emp_data);
                                } else {
                                    // dd("f");
                                    // print_r("DS");
                                    $mail_not_sent['mail_response'] = 'No Email Id Found';
                                    $res = MailnotSent::create($mail_not_sent);
                                }
                            }
                        }

                        if ($date_number[2] == "08") {
                            $emp_data['mail_number'] = '4';
                            if ($check_mail_tracker->mail_number == 3 && $check_mail_tracker->mail_sent == 1) {
                                if(!empty($data["email"]) && $data["email"] != 0) {

                                    if (true) {
                                        Mail::mailer('smtp2')->send('emails.CommonTerSubmissionMail', $data, function ($message) use ($data) {
                                            $message->to($data["email"], $data["email"])
                                                ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                                                ->subject($data["title"])
                                                ->cc(config('services.cc_email.email_id'));
                                        });
                                    }
                                    $res =  EmployeeMailTracker::create($emp_data);
                                } else {
                                    // dd("f");
                                    // print_r("DS");
                                    $mail_not_sent['mail_response'] = 'No Email Found';
                                    $res = MailnotSent::create($mail_not_sent);
                                }
                            }
                        }
                    }
                } else {

                    // return "FD2";
                    // print_r($month[1]);

                    $getsender = Sender::where('employee_id', $get_details[$i]->employee_id)->get();


                    $data["title"] = "Alert: Reminder " . $reminder . ", TER Claim not submitted for  " . $Month_name . "-" . $get_month[2];

                    // $data["email"] = "itsupport@frontierag.com";
                    $data["email"] = $getsender[0]->official_email_id;
                    $data['employee_name'] = $getsender[0]->name;
                    $data['employee_id'] = $getsender[0]->employee_id;
                    $data['body'] = "This is to remind you that we have not received your TER Claim for " . $Month_name . "-" . $get_month[2] . ". Please ensure the TER Claim is submitted by " . $get_details[$i]->saved_last_date . " to HO. ";

                    $data['body_2'] = "In case TER claim for " . $Month_name . "-" . $get_month[2] . " is not submitted at HO by " . $get_details[$i]->saved_last_date . " then no TER Claim for " . $Month_name . "-" . $get_month[2] . " will be payable.";
                    // return   $data["title"] ;

                    // return view('emails.CommonTerSubmissionMail',['body'=>$data['body'],'title'=>$data['title'],'employee_id'=> $data['employee_id'],'employee_name'=> $data['employee_name'],'body_2'=>$data['body_2']]);
                    $check_mail_tracker = EmployeeMailTracker::where('employee_id', $get_details[$i]->employee_id)->where('ter_received', '0')->where('ter_month', $ter_month)->orderby('id', 'desc')->first();
                    $emp_data['employee_id'] = $getsender[0]->employee_id;
                    $emp_data['ter_month'] = $ter_month;
                    $emp_data['mail_date'] = $today_date;
                    $emp_data['mail_sent'] = '1';
                    $emp_data['saved_last_date'] = $get_details[$i]->saved_last_date;
                    $emp_data['last_mail_date'] = $get_details[$i]->last_mail_date;
                    // return   $data["title"] ;




                    if ($date_number[2] == "17") {
                        $emp_data['mail_number'] = '2';

                        if ($check_mail_tracker->mail_number == 1 && $check_mail_tracker->mail_sent == 1) {
                            if(!empty($data["email"]) && $data["email"] != 0) {
                                if (true) {
                                    Mail::mailer('smtp2')->send('emails.CommonTerSubmissionMail', $data, function ($message) use ($data) {
                                        $message->to($data["email"], $data["email"])
                                            ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                                            ->subject($data["title"])
                                            ->cc(config('services.cc_email.email_id'));
                                    });
                                }

                                $res =  EmployeeMailTracker::create($emp_data);
                            } else {
                                // dd("f");
                                // print_r("DS");
                                $mail_not_sent['mail_response'] = 'No Email Id Found';
                                $res = MailnotSent::create($mail_not_sent);
                            }
                        }
                    }

                    // return view('emails.CommonTerSubmissionMail',['body'=>$data['body'],'title'=>$data['title'],'employee_id'=> $data['employee_id'],'employee_name'=> $data['employee_name'],'body_2'=>$data['body_2']]);


                    if ($date_number[2] == "27") {
                        $emp_data['mail_number'] = '3';
                        if ($check_mail_tracker->mail_number == 2 && $check_mail_tracker->mail_sent == 1) {
                            if(!empty($data["email"]) && $data["email"] != 0) {
                                if (true) {
                                    Mail::mailer('smtp2')->send('emails.CommonTerSubmissionMail', $data, function ($message) use ($data) {
                                        $message->to($data["email"], $data["email"])
                                            ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                                            ->subject($data["title"])
                                            ->cc(config('services.cc_email.email_id'));
                                    });
                                }
                                $res =  EmployeeMailTracker::create($emp_data);
                            } else {
                                // dd("f");
                                // print_r("DS");
                                $mail_not_sent['mail_response'] = 'No Email Id Found';
                                $res = MailnotSent::create($mail_not_sent);
                            }
                        }
                    }

                    if ($date_number[2] == "08") {
                        $emp_data['mail_number'] = '4';
                        if ($check_mail_tracker->mail_number == 3 && $check_mail_tracker->mail_sent == 1) {
                            if(!empty($data["email"]) && $data["email"] != 0) {

                                if (true) {
                                    Mail::mailer('smtp2')->send('emails.CommonTerSubmissionMail', $data, function ($message) use ($data) {
                                        $message->to($data["email"], $data["email"])
                                            ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                                            ->subject($data["title"])
                                            ->cc(config('services.cc_email.email_id'));
                                    });
                                }
                                $res =  EmployeeMailTracker::create($emp_data);
                            } else {
                                // dd("f");
                                // print_r("DS");
                                $mail_not_sent['mail_response'] = 'No Email Id Found';
                                $res = MailnotSent::create($mail_not_sent);
                            }
                        }
                    }
                }
            }

            return 1;
        }



        return 1;
    }

    public static function send_unknown_mail($id)
    {
        // return 1;
        // $id = '1920';
        // return $data['emp_id'];
        $get_ter_data = DB::table('tercouriers')->where('id', $id)->get();
        $getsender = Sender::where('employee_id', $get_ter_data[0]->employee_id)->first();

        // $from_date = Helper::ShowFormatDate($get_ter_data[0]->terfrom_date);
        // $get_month = explode("-", $from_date);
        // $ter_month = $get_month[1];

        $from_date = date_create($get_ter_data[0]->terfrom_date);
        $received_date = date_format($from_date, "d-F-Y");
        $get_month =  explode("-", $received_date);
        $ter_month = $get_month[1];

        $data["title"] = "Missing Detail in – TER CLAIM for " . $ter_month;

        // $body = "We have received your TER with UNID ".$id.". You have not mentioned your E.Code. ";
        // $data["email"] = "itsupport@frontierag.com";
        $data["email"] = $getsender->official_email_id;
        // $employee_id=$getsender->employee_id;
        // $employee_name=$getsender->name;
        $data['id'] = $id;
        $data['employee_name'] = $getsender->name;
        $data['employee_id'] = $getsender->employee_id;
        $data['body'] = "We have received your TER with UNID " . $id . ". You have not mentioned your Employee Code (E.Code.) ";

        // return  $employee_name;

        // return view('emails.unknownEmployee',['body'=>$data['body'],'employee_id'=>$data['employee_id'],'employee_name'=>$data['employee_name']]);
        if(!empty($data["email"]) && $data["email"] != 0) {

            Mail::mailer('smtp2')->send('emails.unknownEmployee', $data, function ($message) use ($data) {
                $message->to($data["email"], $data["email"])
                    ->from($address = 'do-not-reply@frontierag.com', $name = 'Frontiers No Reply')
                    ->subject($data["title"])
                    ->cc(config('services.cc_email.email_id'));
            });
        } else {
            // dd("f");
            // print_r("DS");
            $mail_not_sent['mail_response'] = 'No Email Found';
            $res = MailnotSent::create($mail_not_sent);
        }
    }

    public function get_emp_list(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $tercourier_table = DB::table('tercouriers')->where('id', $id)->get();
        if ($tercourier_table[0]->employee_id == 0) {
            $senders =  DB::table('sender_details')->get();
            $tercourier_table['all_senders_data'] = $senders;
            return $tercourier_table;
        } else {
            return 0;
        }
    }

    public function show_emp_not_exist(Request $request)
    {

        if (Auth::check()) {
            $query = Tercourier::query();
            $user = Auth::user();
            $data = json_decode(json_encode($user));
            $name = $data->roles[0]->name;
            // return $name;

            $tercouriers = $query->where('status', 9)->where('txn_type', "emp_doesn't_exists")->orderby('id', 'ASC')->get();

            // echo'<pre>'; print_r($tercouriers->status); die;
            return view('tercouriers.emp-not-exist-tercourier-list', ['tercouriers' => $tercouriers, 'role' => $name]);
        }
        //    echo'<pre>'; print_r($name); die;
    }

    public function show_rejected_ter(Request $request)
    {


        if (Auth::check()) {
            $query = Tercourier::query();
            $user = Auth::user();
            $data = json_decode(json_encode($user));
            $name = $data->roles[0]->name;
            // return $name;

            $tercouriers = $query->whereIn('status', [8, 0, 10])->where('txn_type', 'rejected_ter')->orderby('id', 'ASC')->get();

            // echo'<pre>'; print_r($tercouriers->status); die;
            return view('tercouriers.rejected-tercourier-list', ['tercouriers' => $tercouriers, 'role' => $name]);
        }
        //    echo'<pre>'; print_r($name); die;
    }

    public function show_settlement_deduction(Request $request)
    {


        if (Auth::check()) {
            $query = TerDeductionSettlement::query();
            $user = Auth::user();
            $data = json_decode(json_encode($user));
            $name = $data->roles[0]->name;
            // return $name;

            $tercouriers = $query->orderby('id', 'ASC')->get();

            // echo'<pre>'; print_r($tercouriers->status); die;
            return view('tercouriers.show-settlement-deduction', ['tercouriers' => $tercouriers, 'role' => $name]);
        }
        //    echo'<pre>'; print_r($name); die;
    }

    public function show_unit_change(Request $request)
    {


        if (Auth::check()) {
            $user = Auth::user();
            $data = json_decode(json_encode($user));
            $name = $data->roles[0]->name;
            // return $name;
            if ($name == "Hr Admin") {
                $tercouriers = Tercourier::where('is_unit_changed', 1)->where('status', 12)->with('SenderDetail')->get();
                // echo'<pre>'; print_r($tercouriers); die;
            }
            return view('tercouriers.show-unit-change', ['tercouriers' => $tercouriers, 'role' => $name]);
        }
        //    echo'<pre>'; print_r($name); die;
    }

    public function get_unit_details(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $tercouriers = Tercourier::where('id', $id)->with('SenderDetail')->get();
        return $tercouriers;
    }




    public function show_full_and_final_data(Request $request)
    {


        if (Auth::check()) {
            $query = Tercourier::query();
            $user = Auth::user();
            $data = json_decode(json_encode($user));
            $name = $data->roles[0]->name;
            // return $name;

            $tercouriers = $query->where('payment_status', 3)->whereIn('status', [4, 0])->with('CourierCompany', 'SenderDetail')->orderby('id', 'DESC')->get();

            // echo'<pre>'; print_r($tercouriers->status); die;
            return view('tercouriers.show-full-and-final-data', ['tercouriers' => $tercouriers, 'role' => $name]);
        }
        //    echo'<pre>'; print_r($name); die;
    }


    public function edit_ter_reception()
    {
        $couriers = DB::table('courier_companies')->select('id', 'courier_name')->distinct()->get();
        return view('tercouriers.reception-edit-tercourier', ['couriers' => $couriers]);
    }

    public function get_rejected_details(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $ter = DB::table('tercouriers')->where('id', $id)->get();
        return $ter;
    }
    public function status_change_to_handover(Request $request)
    {
        $data = $request->all();
        $id = $data['selected_id'];
        $get_ter_data = DB::table('tercouriers')->where('id', $id)->get();
        if ($get_ter_data[0]->cancel_reject == 1) {
            $ter = DB::table('tercouriers')->where('id', $id)->update(['status' => 6]);
            $ter = 2;
        } else {
            $ter = DB::table('tercouriers')->where('id', $id)->update(['status' => 2]);
        }

        return $ter;
    }
    public function partially_paid_details(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $ter = DB::table('ter_deduction_settlements')->where('parent_ter_id', $id)->orderby("book_date", "DESC")->first();
        return $ter;
    }

    public function update_payable_amount(Request $request)
    {
        $data = $request->all();
        $hr_remarks = $data['hr_admin_remarks'];
        $id = $data['ter_id'];
        $new_payable = $data['new_payable'];
        $updated_payable[0] = $new_payable;
        $ter_data = Tercourier::where('id', $id)->get();
        if ($ter_data[0]->final_payable > $new_payable) {
            $ter = Tercourier::where('id', $id)->update(['hr_admin_remark' => $hr_remarks, 'payable_amount' => $updated_payable, 'final_payable' => $new_payable]);
        } else {
            return "New Payable is greater than Actual Payable Amount";
        }
        return $ter;
    }

    public function submit_hr_remarks(Request $request)
    {
        $data = $request->all();
        $hr_remarks = $data['hr_remarks'];
        $id = $data['id'];
        $type = $data['type'];
        if ($type == "partially_paid") {
            $ter_first = DB::table('ter_deduction_settlements')->where('parent_ter_id', $id)->orderby("book_date", "DESC")->first();
            $ter = DB::table('ter_deduction_settlements')->where('id', $ter_first->id)->update(['hr_admin_remark' => $hr_remarks, 'status' => 10]);
            // print_r($ter_first->id);
            // exit;
            // update(['hr_admin_remark'=> $hr_remarks,'status'=>10]);
        } else {
            $ter = DB::table('tercouriers')->where('id', $id)->update(['hr_admin_remark' => $hr_remarks, 'cancel_reject' => 0, 'status' => 10]);
        }
        return $ter;
    }

    public function edit_tercourier(Request $request)
    {
        $data = $request->all();
        // return $data;
        $id = $data['unique_id'];
        $details = Auth::user();
        $data['saved_by_name'] = $details->name;
        $data['saved_by_id'] = $details->id;
        unset($data['unique_id']);
        $senders =  DB::table('sender_details')->where('employee_id', $data['employee_id'])->get()->toArray();
        $data['sender_id'] = $senders[0]->id;
        $get_db_data = DB::table('tercouriers')->select('status')->where('id', $id)->get();
        if ($get_db_data[0]->status == 1) {
            $new = DB::table('tercouriers')->where('id', $id)->update($data);
            return $new;
        } else {
            return 0;
        }
    }

    public function sent_payment_response(Request $request)
    {
        $data = $request->all();
    }

    public function open_verify_ter(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $res = URL::to('/update_ter/' . $id);
        return $res;
    }


    public function open_hr_verify_ter(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $res = URL::to('/admin_update_ter/' . $id);
        return $res;
    }
}
