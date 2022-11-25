<?php

namespace App\Http\Controllers;

use App\Models\EmployeeBalance;
use App\Models\EmployeeLedgerData;
use Illuminate\Http\Request;
use App\Models\Sender;
use DB;
use URL;
use Response;
use Validator;
use Illuminate\Support\Facades\Auth;

class SenderController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:add-sender', ['only' => ['addSenderIndex']]);
        $this->middleware('permission:sender-table-show', ['only' => ['senderTable']]);
    }


    public function addSenderIndex()
    {
        return view('pages.add-sender');
    }

    public function senderTable(Request $request)
    {
        $sends = Sender::all();
        $user = Auth::user();
        $data = json_decode(json_encode($user));
        // echo'<pre>'; print_r($data); die;
        $name = $data->roles[0]->name;
        $flag = 0;
        $flag_hr = 0;
        // echo'<pre>'; print_r($name); die;
        if ($name === "tr admin" || $name === "Hr Admin" || $name === "reception") {
            $flag = 1;
        }
        if ($name === "Hr Admin") {
            $flag_hr = 1;
        }

        return view('pages.sender-table',  ['sends' => $sends, 'flag' => $flag, 'flag_hr' => $flag_hr])->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function get_emp_data(Request $request)
    {
        $data = $request->all();
        $id = $data['sender_id'];
        $get_db_data = DB::table('sender_details')->where('employee_id', $id)->get()->toArray();
        $balance_data = DB::table('employee_balance')->select('current_balance')->where('employee_id', $get_db_data[0]->employee_id)->orderBy('id', 'DESC')->first();;
        // return $balance_data;
        if (!empty($balance_data)) {
            $get_db_data['current_balance'] = $balance_data->current_balance;
        } else {
            $get_db_data['current_balance'] = 0;
        }
        return $get_db_data;
    }

    public static function set_employee_in_ledger($created_date,$emp_id,$type,$user_id,$user_name)
    {
        $insert_data['updated_date']=date('Y-m-d');
        $insert_data['employee_id']=$emp_id;
        $insert_data['utilize_amount']=0;
        $insert_data['action_done']='new_emp';
        $insert_data['user_id']=$user_id;
        $insert_data['user_name']=$user_name;
        $insert_data['updated_date']=$created_date;
        $insert_data['created_at']= date('Y-m-d H:i:s');
        $insert_data['updated_at']= date('Y-m-d H:i:s');
        if($type == "imprest_ledger" )
        {
            $insert_data['advance_amount']=0;
            $insert_data['current_balance']=0;

            EmployeeBalance::insert($insert_data);
        }
        if($type == "emp_ledger" )
        {
            unset($insert_data['advance_amount']);
            unset($insert_data['current_balance']);
            $insert_data['incoming_payment']=0;
            $insert_data['ledger_balance']=0;

            EmployeeLedgerData::insert($insert_data);
        }

    }

    public function add_advance_payment(Request $request)
    {
        $data = $request->all();
        $details = Auth::user();
        $emp_id=$data['emp_id'];
        $check_blocked_user=DB::table('sender_details')->where('employee_id',$emp_id)->get();
        if($check_blocked_user[0]->status == "Blocked" || $check_blocked_user[0]->last_working_day != "")
        {
            return "Blocked";
        }
        $balance_data = DB::table('employee_balance')->where('employee_id', $data['emp_id'])->orderBy('id', 'DESC')->first();
         $user_id=$details->id;
         $user_name = $details->name;
        $ledger_data = EmployeeLedgerData::where('employee_id', $data['emp_id'])->orderBy('id', 'DESC')->first();
        $date_created = DB::table('sender_details')->select('created_at')->where('employee_id',$data['emp_id'])->get();
        $new_data = explode(" ", $date_created[0]->created_at);
        $created_date = date("d-m-Y", strtotime($new_data[0]));
        if(empty($balance_data))
        {
            self::set_employee_in_ledger($created_date,$emp_id,'imprest_ledger',$user_id,$user_name);
        }
        if(empty($ledger_data))
        {
            self::set_employee_in_ledger($created_date,$emp_id,'emp_ledger',$user_id,$user_name);
        }
        $balance_data = DB::table('employee_balance')->where('employee_id', $data['emp_id'])->orderBy('id', 'DESC')->first();
        $ledger_data = EmployeeLedgerData::where('employee_id', $data['emp_id'])->orderBy('id', 'DESC')->first();
        if (!empty($balance_data->current_balance)) {
            $current_balance = $balance_data->current_balance;
            $insert_data['current_balance'] = $current_balance + $data['emp_advance_amount'];
        } else {
            $insert_data['current_balance'] = $data['emp_advance_amount'];
        }


        // employee_payment_detail($user_id, $user_name, $emp_id, $utilized_amount, $ter_id, $ter_pay_amount, $voucher_data)
        $insert_data['updated_date'] = date('Y-m-d');
        $insert_data['employee_id'] = $data['emp_id'];
        $insert_data['advance_amount'] = $data['emp_advance_amount'];
        $insert_data['ax_voucher_number'] = $data['ax_voucher_number'];    
        $insert_data['ter_id'] = 0;
        $insert_data['action_done'] = 'Advance';
        $insert_data['user_id'] = $details->id;
        $insert_data['user_name'] = $details->name;
        $insert_data['created_at'] = date('Y-m-d H:i:s');
        $insert_data['updated_at'] = date('Y-m-d H:i:s');
        $insert_data['utilize_amount'] = 0;
      
        $table_update = DB::table('employee_balance')->insert($insert_data);

        $balance_data = DB::table('employee_balance')->where('employee_id', $data['emp_id'])->get();
        $ledger_data =  DB::table('employee_ledger_data')->where('employee_id', $data['emp_id'])->get();
        // return $balance_data[1]->id;
        $count_rows_balance = $balance_data->count();
        $count_rows_ledger = $ledger_data->count();
// print_r($count_rows_balance);
// print_r($count_rows_ledger);
// exit;
        if($count_rows_balance == "2" && $count_rows_ledger < 2 )
        {
            $update_emp_ledger=DB::table('employee_ledger_data')->insert(['incoming_payment'=>$data['emp_advance_amount']
            ,'ledger_balance'=>$data['emp_advance_amount'],'action_done'=>'Imprest','ax_voucher_number'=>$data['ax_voucher_number'],
                     'updated_date'=>date('Y-m-d'),'wallet_id'=>$balance_data[1]->id,'employee_id'=>$emp_id,'user_id'=>$user_id,
                    'user_name'=>$user_name]);
            return $update_emp_ledger;
        }

        // $ledger_data = EmployeeLedgerData::where('employee_id', $data['emp_id'])->orderBy('id', 'DESC')->first();
        if($table_update)
        {
      $emp_ledger=EmployeeLedgerData::update_advance_in_ledger($insert_data['user_id'],$insert_data['user_name'],$data['emp_id'] , $insert_data['ter_id'], 
                                                              $data['emp_advance_amount'],$insert_data['ax_voucher_number']);
      return $emp_ledger;
    }
    //     if(!empty($balance_data))
    //     {
    //     if($balance_data->ter_expense_balance < 0)
    //     {
    //         // $current_balance-$ter_pay_amount+$balance_data->ter_expense_balance;
    //         // $insert_data['ter_expense_balance'] = $data['emp_advance_amount'];
    //         $insert_data['ter_expense_balance'] =$data['emp_advance_amount']+$balance_data->ter_expense_balance;
        
    //         $insert_data['current_balance']=$balance_data->ter_expense_balance+$data['emp_advance_amount'];
    //         if($insert_data['current_balance']<0)
    //         {
    //             $insert_data['current_balance']=0;
    //         }
    //     }
    // }
  
        return 1;
    }
    public function get_employee_passbook(Request $request)
    {
        $data = $request->all();
        $id = $data['id'];
        $db_data = DB::table('sender_details')->select('employee_id')->where('id', $id)->get();
        $emp_id = $db_data[0]->employee_id;;
        $res = URL::to('/employee_detail_passbook/' . $emp_id);
        return $res;
    }

    public function emp_passbook_view($emp_id)
    {
        // return $emp_id;
        $data_1 = EmployeeBalance::where('employee_id', $emp_id)->with('SenderDetailsTable')->orderby('updated_at', 'desc')->limit(1)->get();
        //    return $data_1;


        if (!empty($data_1[0])) {
            $current_balance = $data_1[0]->current_balance;
            // return $current_balance;
            $employee_balance_data = EmployeeBalance::where('employee_id', $emp_id)->orderby('updated_at', 'asc')->get();
            $employee_name = $data_1[0]->SenderDetailsTable->name;
            // echo"<pre>";
            // print_r(json_decode($employee_balance_data));
            // exit;
        } else {
            $current_balance = 0;
            $get_name = DB::table('sender_details')->select('name')->where('employee_id', $emp_id)->get()->toArray();
            $employee_name = $get_name[0]->name;
            $employee_balance_data = [];
        }
        $ledger_data=EmployeeLedgerData::where('employee_id', $emp_id)->orderby('id', 'asc')->get();
        if(empty($ledger_data))
        {
            $ledger_data = [];
        }

        // echo "<pre>";
        // print_r($ledger_data);
        // exit;

        //   return $employee_name;
        // return [$current_balance,$employee_name,$employee_balance_data];
        return view('pages.employee-passbook', [
            'current_balance' => $current_balance, 'employee_name' => $employee_name, 'employee_balance_data' => $employee_balance_data,
            'emp_id' => $emp_id,'ledger_data' =>$ledger_data
        ]);
    }

    // public function emp_passbook_view($emp_id)
    // {
    //     // return $emp_id;
    //     $data_1 = EmployeeBalance::where('employee_id', $emp_id)->with('SenderDetailsTable')->orderby('updated_at', 'desc')->limit(1)->get();
    //     //    return $data_1;
    //     $date_created = DB::table('sender_details')->select('created_at')->where('employee_id', $emp_id)->get();
    //     $new_data = explode(" ", $date_created[0]->created_at);
    //     $created_date = date("d-m-Y", strtotime($new_data[0]));

    //     if (!empty($data_1[0])) {
    //         $current_balance = $data_1[0]->current_balance;
    //         // return $current_balance;
    //         $employee_balance_data = EmployeeBalance::where('employee_id', $emp_id)->orderby('updated_at', 'asc')->get();
    //         $employee_name = $data_1[0]->SenderDetailsTable->name;
    //         // echo"<pre>";
    //         // print_r(json_decode($employee_balance_data));
    //         // exit;
    //     } else {
    //         $current_balance = 0;
    //         $get_name = DB::table('sender_details')->select('name')->where('employee_id', $emp_id)->get()->toArray();
    //         $employee_name = $get_name[0]->name;
    //         $employee_balance_data = [];
    //     }

    //     //   return $employee_name;
    //     // return [$current_balance,$employee_name,$employee_balance_data];
    //     return view('pages.employee-passbook', [
    //         'current_balance' => $current_balance, 'employee_name' => $employee_name, 'employee_balance_data' => $employee_balance_data,
    //         'emp_id' => $emp_id, "created_date" => $created_date
    //     ]);
    // }

    public function addSender(Request $request)
    {
        $sender = new Sender;
        $sender->name = $request->name;
        $sender->type = $request->type;
        // if($request->type == 'Other')
        // {
        //    $sender->type = $request->other_type;
        // }else{
        // $sender->type = $request->type;
        // }
        $sender->location = $request->location;
        $sender->telephone_no = $request->telephone_no;

        $S = DB::table('sender_details')
            ->where('name', '=', $request['name'])
            ->where('telephone_no', '=', $request['telephone_no'])
            ->first();
        if (is_null($S)) {
            $sender->save();
            $response['success'] = true;
            $response['messages'] = 'Succesfully imported';
        } else {
            $response['success'] = false;
            $response['messages'] = 'Data already exist';
        }
        return Response::json($response);
    }

    public function editSender($id)
    {
        $this->prefix = request()->route()->getPrefix();
        $id = decrypt($id);
        $sender = Sender::where('id', $id)->first();
        return view('pages.update-sender')->with(['prefix' => $this->prefix, 'sender' => $sender]);
    }

    public function updateSender(Request $request)
    {
        try {
            $this->prefix = request()->route()->getPrefix();
            $rules = array(
                'name' => 'required',
            );
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $errors                 = $validator->errors();
                $response['success']    = false;
                $response['formErrors'] = true;
                $response['errors']     = $errors;
                return response()->json($response);
            }
            $sendersave['name']         = $request->name;
            $sendersave['telephone_no'] = $request->telephone_no;
            $sendersave['location']   = $request->location;
            $sendersave['type']       = $request->type;

            $savesender = Sender::where('id', $request->sender_id)->update($sendersave);

            if ($savesender) {
                $url    =   URL::to($this->prefix . 'sender-table');

                $response['redirect_url']    = $url;
                $response['success']         = true;
                $response['success_message'] = "Sender Updated Successfully";
                $response['error']           = false;
                $response['page']            = 'sender-update';
                $response['redirect_url']  = $url;
            }
        } catch (Exception $e) {
            $response['error']         = false;
            $response['error_message'] = $e;
            $response['success']       = false;
            $response['redirect_url']  = $url;
        }
        return response()->json($response);
    }

    public function deleteSender(Request $request)
    {
        Sender::where('id', $request->senderid)->delete();
        $url    =   URL::to('sender-table');
        $response['success']         = true;
        $response['success_message'] = 'Sender deleted successfully';
        $response['error']           = false;
        $response['redirect_url']    = $url;
        return response()->json($response);
    }
}
