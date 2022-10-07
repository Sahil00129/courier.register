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

class TercourierController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:tercouriers/create', ['only' => ['create']]);
        $this->middleware('permission:tercouriers', ['only' => ['index']]);
        $this->middleware('permission:ter_list_edit_user', ['only' => ['update_ter']]);
        $this->middleware('permission:hr_admin_edit_ter', ['only' => ['admin_update_ter']]);
        $this->middleware('permission:full-and-final-data', ['only' => ['show_full_and_final_data']]);
        $this->middleware('permission:payment_sheet', ['only' => ['payment_sheet']]);
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
            $role = 'Admin';
            // echo'<pre>'; print_r($name); die;
            if ($name === "tr admin" || $name === "Hr Admin") {
                $tercouriers = $query->whereIn('status', ['0', '2', '3', '4','5'])->with('CourierCompany', 'SenderDetail')->orderby('id', 'DESC')->get();
                $role = "Tr Admin";
                // echo'<pre>'; print_r($tercouriers->status); die;
                return view('tercouriers.tercourier-list', ['tercouriers' => $tercouriers, 'role' => $role]);
            } else {
                $tercouriers = $query->whereIn('status', ['1', '2'])->with('CourierCompany', 'SenderDetail')->orderby('id', 'DESC')->get();
            }
            //    echo'<pre>'; print_r($name); die;
        }


        // echo'<pre>';print_r($query); die;
        return view('tercouriers.tercourier-list', ['tercouriers' => $tercouriers, 'role' => $role]);
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

        $details = Auth::user();
        $terdata['saved_by_name'] = $details->name;
        $terdata['saved_by_id'] = $details->id;
        $terdata['employee_id']    = $request->sender_id;
        // return $terdata['employee_id'];  
        $terdata['date_of_receipt'] = $request->date_of_receipt;
        $terdata['courier_id']  = $request->courier_id;
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

        // echo "<pre>";print_r($terdata);

        $senders =  DB::table('sender_details')->where('employee_id', $terdata['employee_id'])->get()->toArray();
        $terdata['ax_id']    = $senders[0]->ax_id;
        $terdata['sender_id'] = $senders[0]->id;
        $terdata['sender_name']  = $senders[0]->name;

        // echo "<pre>";print_r($senders[0]->ax_id);die;
        // echo "<pre>";print_r($terdata);die;
        $tercourier = Tercourier::create($terdata);
        // dd($tercourier->id);
        if ($tercourier) {
            // return  $tercourier->id;
            // exit;
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

    public function update_ter()
    {
        return view('tercouriers.update-tercourier');
    }

    public function admin_update_ter()
    {
        return view('tercouriers.admin-update-tercourier');
    }

    public function payment_sheet()
    {
        return view('tercouriers.open-payment-sheet');
    }

    public function check_paid_status()
    {
        ini_set('max_execution_time', 0); // 0 = Unlimited
        $get_data_db = DB::table('tercouriers')->select('id')->where('status', 3)->get()->toArray();
        $size = sizeof($get_data_db);

        for ($i = 0; $i < $size; $i++) {
            // print_r($get_data_db[$i]->id);
            $id = $get_data_db[$i]->id;
            $url = 'https://finfect.biz/api/get_payment_response/' . $id;
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
                $status_code = $received_data->status_code;

                if ($status_code == 2) {
                    $update_ter_data = DB::table('tercouriers')->where('id', $get_data_db[$i]->id)->update([
                        'status' => 5, 'finfect_response' => 'Paid',
                        'utr' => $received_data->bank_refrence_no
                    ]);

                    if ($update_ter_data) {
                        // echo "<pre>";
                        // print_r($id);
                        // echo "<pre>";
                        // print_r($response);
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
            }


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
            return $updated_record_detail;
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
        $query = Tercourier::query();
        // $tercourier_table= DB::table('tercouriers')->select ('*')->where('id',$id)->get()->toArray();
        $tercourier_table = $query->where('id', $id)->with('CourierCompany', 'SenderDetail')->orderby('id', 'DESC')->get();
        if ($tercourier_table[0]->status == 3) {
            $data_error['status_of_data'] = "3";
            return $data_error;
        }
        $senders =  DB::table('sender_details')->get();
        $balance_data=DB::table('employee_balance')->select('current_balance')->where('employee_id',$tercourier_table[0]->employee_id)->orderBy('id', 'DESC')->first();;
        // return $balance_data;
        if(empty($balance_data))
        {
            $e_id='0'.$tercourier_table[0]->employee_id;
            $balance_data=DB::table('employee_balance')->select('current_balance')->where('employee_id',$e_id)->orderBy('id', 'DESC')->first();;
        }
        if(!empty($balance_data))
        {
            $tercourier_table['current_balance']=$balance_data->current_balance;
        }else{
            $tercourier_table['current_balance']=0;
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
        $id = $data['unique_id'];
        $payable_data = $data['payable_data'];
        $ter_total_amount = $data['ter_total_amount'];
        $total_payable_sum = 0;
        $length = sizeof($payable_data);
        for ($i = 0; $i < $length; $i++) {
            $total_payable_sum = $total_payable_sum + $payable_data[$i]['payable_amount'];
        }

        if ($total_payable_sum > $ter_total_amount) {
            return "error_sum_amount";
        }

        $details = Auth::user();
        $payment_status = $data['payment_status'];
        $log_in_user_name = $details->name;
        $log_in_user_id = $details->id;
        $final_payable=$total_payable_sum;
        $data_ter = DB::table('tercouriers')->where('id', $id)->get()->toArray();
        $tercourier_ax_check = $data_ter[0];
        if ($tercourier_ax_check->ax_id  != 0) {
            $response = Tercourier::add_voucher_payable($payable_data,$id, $log_in_user_id, $log_in_user_name, $payment_status,$final_payable);
            // $response = Tercourier::add_voucher_payable($payable_data, $id, $log_in_user_id, $log_in_user_name, $payment_status);
        } else {
            exit;
        }
        // $response = Tercourier::add_voucher_payable($voucher_code, $payable_amount, $id, $log_in_user_id, $log_in_user_name,$payment_status);
        return $response;
    }

    public function ter_pay_now(Request $request)
    {

        $data = $request->all();
        $id = $data['unique_id'];
        $payable_data = $data['payable_data'];
        $ter_total_amount = $data['ter_total_amount'];
        $total_payable_sum = 0;
        $length = sizeof($payable_data);
     
        $data_ter = DB::table('tercouriers')->where('id', $id)->get()->toArray();
        // return $data_ter[0]->employee_id;
        for ($i = 0; $i < $length; $i++) {
            $total_payable_sum = $total_payable_sum + $payable_data[$i]['payable_amount'];
        }

        if ($total_payable_sum > $ter_total_amount) {
            return "error_sum_amount";
        }
        $res=0;
        // return $data;
        $res=0;
        $id = $data['unique_id'];
        $data_ter = DB::table('tercouriers')->where('id', $id)->get()->toArray();
       $response= self::advance_payment_check($data,$total_payable_sum);

       if($response[1]=='4')
       {
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
                    'payment_type' => 'full_and_final_payment', 'status' => 4, 'payment_status' => 3
                ));
                return $change_status;     
            } 
        else {
            $res = self::api_call_finfect($id);
            return $res;
        }
        }

    
    }


    public function advance_payment_check($data,$total_payable_sum)
    {
        $id = $data['unique_id'];
        $data_ter = DB::table('tercouriers')->where('id', $id)->get()->toArray();
        $current_balance=$data['current_balance'];
        // return $data;
        $final_payable=0;
        $details = Auth::user();
        $log_in_user_name = $details->name;
        $log_in_user_id = $details->id;
        $flag=0;
        $emp_id=$data_ter[0]->employee_id;
        $new_emp_id='0'.$emp_id;
        $payable_data = $data['payable_data'];
        // return $data_ter[0]->employee_id;
        $check=DB::table('sender_details')->where('employee_id',$emp_id)->get();

        if(sizeof($check) == 0)
        {
            $check=DB::table('sender_details')->where('employee_id',$new_emp_id)->get();
            if(sizeof($check) != 0)
            {
                $emp_id=$new_emp_id;
            }
           
        }
// return $emp_id;
        $get_current_balance=EmployeeBalance::select('current_balance')->where('employee_id',$emp_id)->orderBy('id', 'DESC')->first();;
    //   return $get_current_balance;
    if(!empty($get_current_balance)){
    if($current_balance!=$get_current_balance->current_balance)
    {
       $current_balance=$get_current_balance->current_balance;
    }
}
        if($current_balance!=0)
        {
            if($total_payable_sum > $current_balance)
            {
                $flag=1;
                $final_payable=$total_payable_sum-$current_balance;
            }else if($total_payable_sum == $current_balance)
            {
                $final_payable=0;
                $flag=1;
            }
            else{
                $final_payable=$current_balance-$total_payable_sum;
                $final_payable=0;
            }
            if($flag){
            $utlized_amount=$current_balance;
            }else{
                $utlized_amount=$total_payable_sum;
            }
       
                $emp_sender_id = $data_ter[0]->employee_id;
                

                $check_last_working = DB::table('sender_details')->where('employee_id', $emp_sender_id)->get()->toArray();
                if(!empty($check_last_working)){
                if ($check_last_working[0]->last_working_date) {
                    // return "Dsa";
                    $change_status = DB::table('tercouriers')->where("id", $data['unique_id'])->update(array(
                        'payment_type' => 'full_and_final_payment', 'status' => 4, 'payment_status' => 3
                    ));
                    return $change_status;
                }             
            }
            $update_employee_table=EmployeeBalance::utilized_advance($log_in_user_id,$log_in_user_name,$emp_id,$utlized_amount,$id);
           
         if($current_balance >$total_payable_sum)
         {
            $payment_status="4";
            $response = Tercourier::add_voucher_payable($payable_data,$id, $log_in_user_id, $log_in_user_name, $payment_status,$final_payable);
            $p_status=4;
            return [$response,$p_status];
         }
          else
            {
                $tercourier_ax_check = $data_ter[0];
                if ($tercourier_ax_check->ax_id != 0) {
                $payment_status=1;
                $response = Tercourier::add_voucher_payable($payable_data,$id, $log_in_user_id, $log_in_user_name, $payment_status,$final_payable);
                $p_status=1;  
                // return [$response,$p_status];
            }
                else {
                    exit;
                }
            }
        }else{
            $final_payable=$total_payable_sum;
                 
        $payment_status = $data['payment_status'];
        $tercourier_ax_check = $data_ter[0];
        if ($tercourier_ax_check->ax_id != 0) {
            $p_status=1;
            $response = Tercourier::add_voucher_payable($payable_data,$id, $log_in_user_id, $log_in_user_name, $payment_status,$final_payable);
        } else {
            exit;
        }
        }
        return [$response,$p_status];
    }

    public function pay_later_ter_now(Request $request)
    {
        $data = $request->all();
        // $payment_status = 2;
        $data['unique_id']=$data['selected_id'];
        $data_ter = DB::table('tercouriers')->where('id',$data['unique_id'])->get()->toArray();
        $new_emp_id='0'.$data_ter[0]->employee_id;
        $emp_id=$data_ter[0]->employee_id;
        $total_payable_sum=$data_ter[0]->final_payable;
        $check=DB::table('sender_details')->where('employee_id',$emp_id)->get();
        $data['payment_status']=2;

        if(sizeof($check) == 0)
        {
            $check=DB::table('sender_details')->where('employee_id',$new_emp_id)->get();
            if(sizeof($check) != 0)
            {
                $emp_id=$new_emp_id;
            }
           
        }
        $get_current_balance=EmployeeBalance::select('current_balance')->where('employee_id',$emp_id)->orderBy('id', 'DESC')->first();
        if(!empty($get_current_balance)){
        $data['current_balance']=$get_current_balance->current_balance;
        }else{
            $data['current_balance']=0;
        }
        $data['payable_data']="";
        $response= self::advance_payment_check($data,$total_payable_sum);
        // return $response;

        if($response[1]=='4')
        {
         return $response[0];
        }else{
        $res = self::api_call_finfect($data['selected_id']);
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
        // return 1;
        $all_data = DB::table('tercouriers')->where('id', $id)->get()->toArray();
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

        $payable_sum=$tercourier_data->final_payable;

        $sender_id = $tercourier_data->sender_id;
        $sender_table = DB::table('sender_details')->where('id', $sender_id)->get()->toArray();
        $sender_data = $sender_table[0];
        $ax_id = $tercourier_data->ax_id;
        if (!empty($ax_id)) {
            $new_data = explode("-", $ax_id);
            if ($new_data[0] == "FAMA") {
                $pfu = "MA2";
            } else if ($new_data[0] == "FAGMA") {
                $pfu = "MA4";
            } else if ($new_data[0] == "FAGSD") {
                $pfu = "SD3";
            } else if ($new_data[0] == "FAPL") {
                $pfu = "SD1";
            } else {
                exit;
            }
        } else {
            exit;
        }


        // $send_data = '{
        //     "unique_code":"'.$tercourier_data->employee_id.'",
        //     "name":"'.$tercourier_data->sender_name.'",
        //     "acc_no":"'.$sender_data->account_number.'",
        //     "beneficiary_name":"'.$sender_data->beneficiary_name.'",
        //     "ifsc":"'.$sender_data->ifsc.'",
        //     "bank_name":"'.$sender_data->bank_name.'",
        //     "baddress":"'.$sender_data->branch_name.'",
        //     "payable_amount":"'.$payable_sum.'",
        //     "claimed_amount":"'.$tercourier_data->amount.'",
        //     "pfu":"'. $pfu .'",
        //     "ax_voucher_code":"'.$encoded_data.'",
        //     "txn_route":"TER",
        //     "email":"'.$sender_data->official_email_id.'",
        //     "terid":"'.$tercourier_data->id.'",
        //     "ptype":"Regular",
        //     "ax_id":"'.$ax_id.'"        
        //   }';

        // print_r($send_data);
        //$sen_data_encode=json_encode($send_data);
        // return $sen_data_encode;

        $curl = curl_init();
        // $URL = \Config::get('services.FINFECT_KEY.finfect_url');
// $URL=config('services.FINFECT_KEY.FINFECT_API_URL');
// $url=env('FINFECT_API_URL');
$url=    config('services.finfect_key.finfect_url');
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
                            \"unique_code\":\"$tercourier_data->employee_id\",
                            \"name\":\"$tercourier_data->sender_name\",
                            \"acc_no\":\"$sender_data->account_number\",
                            \"beneficiary_name\":\"$sender_data->beneficiary_name\",
                            \"ifsc\": \"$sender_data->ifsc\",
                            \"bank_name\":\"$sender_data->bank_name\",
                            \"baddress\":\"$sender_data->branch_name\",
                            \"payable_amount\": \"$payable_sum\",
                            \"claimed_amount\": \"$tercourier_data->amount\" , 
                            \"pfu\": \"$pfu\",
                            \"ax_voucher_code\":$encoded_data,
                            \"txn_route\": \"TER\",
                            \"email\": \"$sender_data->official_email_id\",
                            \"terid\": \"$tercourier_data->id\",
                            \"ptype\": \"$tercourier_data->payment_type\",
                            \"ax_id\":\"$ax_id\"
                            }]",

            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $res_data = json_decode($response);
        if ($res_data->message == "success") {
            $new_string['refrence_transaction_id'] = $res_data->refrence_transaction_id;
            $new_data['finfect_response'] = $res_data->message;
            $res = DB::table('tercouriers')->where('id', $tercourier_data->id)->update(array(
                'refrence_transaction_id' => $new_string['refrence_transaction_id'],
                'finfect_response' => $new_data['finfect_response'], 'status' => 3, 'payment_status' => 1
            ));
        } else {
            $new_data['finfect_response'] = $res_data->message;
            $res = DB::table('tercouriers')->where('id', $tercourier_data->id)->update(array(
                'finfect_response' => $new_data['finfect_response'], 'payment_status' => 2,
                'status' => 0
            ));
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
            return view('tercouriers.show-pay-later-data', ['tercouriers' => $tercouriers]);
        }
        //    echo'<pre>'; print_r($name); die;
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

    public function edit_tercourier(Request $request)
    {
        $data = $request->all();

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
}
