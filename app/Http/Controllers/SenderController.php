<?php

namespace App\Http\Controllers;

use App\Models\EmployeeBalance;
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
        $this->middleware('permission:add-sender' ,['only' => ['addSenderIndex']]);
        $this->middleware('permission:sender-table-show', ['only' => ['senderTable']]);
    }


    public function addSenderIndex()
    {
        return view ('pages.add-sender');
    }

    public function senderTable(Request $request)
    {
        $sends = Sender::all();
        $user = Auth::user();
        $data = json_decode(json_encode($user));
        // echo'<pre>'; print_r($data); die;
        $name = $data->roles[0]->name;
        $flag=0;
        $flag_hr=0;
        // echo'<pre>'; print_r($name); die;
        if ($name === "tr admin" || $name === "Hr Admin") {
          $flag=1;
        }
        if ($name === "Hr Admin") {
            $flag_hr=1;
          }

        return view ('pages.sender-table',  ['sends' => $sends,'flag'=>$flag,'flag_hr'=>$flag_hr])->with('i', ($request->input('page', 1) - 1) * 5);
    }

    public function get_emp_data(Request $request)
    {
        $data=$request->all();
        $id=$data['sender_id'];
        $get_db_data=DB::table('sender_details')->where('employee_id',$id)->get()->toArray();
        $balance_data=DB::table('employee_balance')->select('current_balance')->where('employee_id',$get_db_data[0]->employee_id)->orderBy('id', 'DESC')->first();;
        // return $balance_data;
        if(!empty($balance_data))
        {
            $get_db_data['current_balance']=$balance_data->current_balance;
        }else{
            $get_db_data['current_balance']=0;
        }
        return $get_db_data;
    }

    public function add_advance_payment(Request $request)
    {
        $data=$request->all();
        $details = Auth::user();
        $balance_data=DB::table('employee_balance')->select('current_balance')->where('employee_id',$data['emp_id'])->orderBy('id', 'DESC')->first();;
        // return $balance_data;
        if(!empty($balance_data))
        {
            $current_balance=$balance_data->current_balance;
            $insert_data['current_balance']=$current_balance+$data['emp_advance_amount'];
        }else{
            $insert_data['current_balance']=$data['emp_advance_amount'];
        }
        $insert_data['updated_date']=date('Y-m-d');
        $insert_data['employee_id']=$data['emp_id'];
        $insert_data['advance_amount']=$data['emp_advance_amount'];
        $insert_data['ter_id']=0;
        $insert_data['utilize_amount']=0;
        $insert_data['action_done']='Advance';
        $insert_data['user_id']=$details->id;
        $insert_data['user_name']=$details->name;
        $insert_data['created_at']= date('Y-m-d H:i:s');
        $insert_data['updated_at']= date('Y-m-d H:i:s');
        // return $insert_data;
        $table_update=DB::table('employee_balance')->insert($insert_data);
        return $table_update;
    }
    public function get_employee_passbook(Request $request)
    {
        $data=$request->all();
        $id=$data['id'];
        $db_data=DB::table('sender_details')->select('employee_id')->where('id',$id)->get();
        $emp_id=$db_data[0]->employee_id;;
        $res= URL::to('/employee_detail_passbook/'.$emp_id);
        return $res;
    }

    public function emp_passbook_view($emp_id)
    {
        // return $emp_id;
        $data_1=EmployeeBalance::where('employee_id',$emp_id)->with('SenderDetailsTable')->orderby('updated_at','desc')->limit(1)->get();
    //    return $data_1;
        if(!empty($data_1[0])){
        $current_balance=$data_1[0]->current_balance;
        // return $current_balance;
        $employee_balance_data=EmployeeBalance::where('employee_id',$emp_id)->orderby('updated_at','asc')->get();
        $employee_name=$data_1[0]->SenderDetailsTable->name;
        // echo"<pre>";
        // print_r(json_decode($employee_balance_data));
        // exit;
       }
      else{
       $current_balance=0;
       $get_name=DB::table('sender_details')->select('name')->where('employee_id',$emp_id)->get()->toArray();
       $employee_name= $get_name[0]->name;
       $employee_balance_data=[];
      }
    //   return $employee_name;
    // return [$current_balance,$employee_name,$employee_balance_data];
        return view ('pages.employee-passbook',['current_balance'=>$current_balance,'employee_name'=>$employee_name,'employee_balance_data'=>$employee_balance_data,
                                                    'emp_id'=>$emp_id]);
    }

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
        if(is_null($S)) {
            $sender->save();
            $response['success'] = true;
            $response['messages'] = 'Succesfully imported';
        }else{
            $response['success'] = false;
            $response['messages'] = 'Data already exist';
        }
        return Response::json($response);
    }

    public function editSender($id)
    {
        $this->prefix = request()->route()->getPrefix();
        $id = decrypt($id);
        $sender = Sender::where('id',$id)->first();
        return view('pages.update-sender')->with(['prefix'=>$this->prefix,'sender'=>$sender]);
    }

    public function updateSender(Request $request)
    {
        try { 
            $this->prefix = request()->route()->getPrefix();
             $rules = array(
              'name' => 'required',
            );
            $validator = Validator::make($request->all(),$rules);
            if($validator->fails())
            {
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
            
            $savesender = Sender::where('id',$request->sender_id)->update($sendersave);

            if($savesender)
            {
                $url    =   URL::to($this->prefix.'sender-table');

                $response['redirect_url']    = $url;
                $response['success']         = true;
                $response['success_message'] = "Sender Updated Successfully";
                $response['error']           = false;
                $response['page']            = 'sender-update';
                $response['redirect_url']  = $url;
            }
        }catch(Exception $e) {
            $response['error']         = false;
            $response['error_message'] = $e;
            $response['success']       = false;
            $response['redirect_url']  = $url;   
        }
        return response()->json($response);
    }

    public function deleteSender(Request $request)
    {
        Sender::where('id',$request->senderid)->delete();
        $url    =   URL::to('sender-table');
        $response['success']         = true;
        $response['success_message'] = 'Sender deleted successfully';
        $response['error']           = false;
        $response['redirect_url']    = $url;
        return response()->json($response);
    }

}
