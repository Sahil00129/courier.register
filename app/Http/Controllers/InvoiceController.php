<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tercourier;
use App\Models\Po;
use DB;
use URL;
use Helper;
use Validator;
use Config;
use Session;
use Illuminate\Support\Facades\Auth;
use ReflectionFunctionAbstract;
use App\Models\InvoiceHandoverDetail;
date_default_timezone_set('Asia/Kolkata');

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
  
     public function __construct()
     {
         // $this->middleware('auth');
         $this->middleware('permission:invoices', ['only' => ['index']]);
        $this->middleware('permission:invoice_handover', ['only' => ['invoice_handover']]);

     }
     
     public function index(Request $request)
     {
         if (Auth::check()) {
             $query = Tercourier::query();
             $user = Auth::user();
             $data = json_decode(json_encode($user));
             $name = $data->roles[0]->name;
             $couriers = DB::table('courier_companies')->select('id', 'courier_name')->distinct()->get();
                if($name == "sourcing")
                {
                $role="sourcing";
                $tercouriers = $query->whereIn('status', ['2', '3','4','11'])->where('ter_type',1)->with('CourierCompany','SenderDetail', 'HandoverDetail')->orderby('id', 'DESC')->paginate(20);
                }else if($name == "accounts")
                {
                $role="accounts";
                $tercouriers = $query->whereIn('status', [ '4','5', '6','7'])->where('ter_type',1)->orderby('id', 'DESC')->paginate(20);
                }
                else if($name == "reception"){
                 $role = "reception";
                 $tercouriers = $query->whereIn('status', ['0', '1', '2', '3', '4', '5', '6', '7', '8','9','11'])->where('ter_type',1)->with('CourierCompany','SenderDetail', 'HandoverDetail')->orderby('id', 'DESC')->paginate(20);
                }
                else if($name == "scanning"){
                    $role = "scanning";
                    $tercouriers = $query->whereIn('status', ['7','8','9'])->where('ter_type',1)->orderby('id', 'DESC')->paginate(20);
                   }

 
                 // $invoice_list = Tercourier::whereIn('status', ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '11'])->where('ter_type',1)->with('Po', 'HandoverDetail')->orderby('id', 'DESC')->paginate(2);
 
             
                // echo'<pre>'; print_r($tercouriers); die;
         }
 
        //  echo'<pre>'; print_r($role); die;
         return view('invoices.invoices-list', ['tercouriers' => $tercouriers, 'role' => $role, 'name' => $name, 'couriers' => $couriers]);
 
 
         // return view('tercouriers.tercourier-list', ['tercouriers' => $tercouriers,'invoice_list'=>$invoice_list, 'role' => $role, 'name' => $name, 'couriers' => $couriers]);
     }
    // public function index(Request $request)
    // {
    //     $peritem = Config::get('variable.PER_PAGE');
    //     $query = Tercourier::query();
        
    //     if ($request->ajax()) {
    //         if(isset($request->resetfilter)){
    //             Session::forget('peritem');
    //             $url = URL::to($this->prefix.'/'.$this->segment);
    //             return response()->json(['success' => true,'redirect_url'=>$url]);
    //         }
    //         $query = $query;

    //         if(!empty($request->search)){
    //             $search = $request->search;
    //             $searchT = str_replace("'","",$search);
    //             $query->where(function ($query)use($search,$searchT) {
    //                 $query->where('po_number', 'like', '%' . $search . '%')
    //                 ->orWhere('ax_code', 'like', '%' . $search . '%')
    //                 ->orWhere('vendor_name', 'like', '%' . $search . '%')
    //                 ->orWhere('po_value', 'like', '%' . $search . '%')
    //                 ->orWhere('unit', 'like', '%' . $search . '%');
    //             });
    //         }

    //         if($request->peritem){
    //             Session::put('peritem',$request->peritem);
    //         }
      
    //         $peritem = Session::get('peritem');
    //         if(!empty($peritem)){
    //             $peritem = $peritem;
    //         }else{
    //             $peritem = Config::get('variable.PER_PAGE');
    //         }

    //         $invoice = $query->where('ter_type',1)->orderBy('id', 'DESC')->paginate($peritem);
    //         $invoice = $invoice->appends($request->query());

    //         $html =  view('invoices.invoice-list-ajax',['invoice' => $invoice,'peritem'=>$peritem])->render();
            
    //         return response()->json(['html' => $html]);
    //     }


    //     $invoice = $query->where('ter_type',1)->orderBy('id','DESC')->paginate($peritem);
    //     $invoice = $invoice->appends($request->query());
        
    //     return view('invoices.invoice-list', ['invoice' => $invoice, 'peritem'=>$peritem]);
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pos =  Po::where('status', 1)->orderby('id', 'ASC')->get();

        return view('invoices.create-invoice',['pos'=>$pos]);
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
            // 'po_number'    => 'required|unique:pos',>
            // 'vendor_name' => 'required', 
            // 'po_value'  => 'required',
            // 'unit'  => 'required',
        );
        $validator = Validator::make($request->all() , $rules);
        if ($validator->fails())
        {
            $errors                 = $validator->errors();
            $response['success']    = false;
            $response['validation'] = false;
            $response['formErrors'] = true;
            $response['errors']     = $errors;
            return response()->json($response);
        }

        if(!empty($request->po_id)){
            $saveinvoice['po_id'] = $request->po_id;
        }


        $saveinvoice['sender_id'] = $request->po_id;

        $get_all_po=DB::table('pos')->where('id',$request->po_id)->get();
        $saveinvoice['ax_id']= $get_all_po[0]->ax_code;
        $saveinvoice['sender_id']= $request->po_id;
        $saveinvoice['sender_name']= $get_all_po[0]->vendor_name;
        $saveinvoice['pfu']= Helper::PoUnit($get_all_po[0]->unit);
        $saveinvoice['po_value']= $get_all_po[0]->po_value;

        

        if(!empty($request->basic_amount)){
            $saveinvoice['basic_amount'] = $request->basic_amount;
        }
        if(!empty($request->total_amount)){
            $saveinvoice['total_amount'] = $request->total_amount;
        }
        if(!empty($request->invoice_no)){
            $saveinvoice['invoice_no'] = $request->invoice_no;
        }
        if(!empty($request->invoice_date)){
            $saveinvoice['invoice_date'] = $request->invoice_date;
        }
        if(!empty($request->received_date)){
            $saveinvoice['received_date'] = $request->received_date;
        }
        
        
        $saveinvoice['ter_type'] = 1;
        $saveinvoice['status'] = 1;

        $savepo = Tercourier::create($saveinvoice);
        if($savepo){
            $response['success']    = true;
            $response['page']       = 'create-invoice';
            $response['error']      = false;
            $response['success_message'] = "Invoices created successfully";
            $response['redirect_url'] = URL::to('/invoices');
        }else{
            $response['success']       = false;
            $response['error']         = true;
            $response['error_message'] = "Can not created invoice please try again";
        }
        // echo "<pre>"; print_r($response); die;
        return response()->json($response);
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
        //
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

    public function get_po_list(Request $request)
    {

        $getpo = Po::where('id', $request->id)->get();
        return $getpo;


    }

    public function getPo(Request $request)
    {
        $getpo = Po::where('id', $request->po_id)->first();

        if ($getpo) {
            $response['success'] = true;
            $response['success_message'] = "Department list fetch successfully";
            $response['error'] = false;
            $response['data'] = $getpo;
        } else {
            $response['success'] = false;
            $response['error_message'] = "Can not fetch department list please try again";
            $response['error'] = true;
        }
        return response()->json($response);
    }

    public function get_all_invoice_data(Request $request)
    {
        $pos =  Po::where('status', 1)->orderby('id', 'ASC')->get();
        
        $data = $request->all();
       
        $id = $data['unique_id'];
        $role = $data['role'];
        $query = Tercourier::query();
        // $tercourier_table= DB::table('tercouriers')->select ('*')->where('id',$id)->get()->toArray();
        $invoice_table = $query->where('id', $id)->orderby('id', 'DESC')->get();
        $invoice_table['all_pos_data'] = $pos;
        return $invoice_table;
    }

    public function submit_sourcing_remarks(Request $request)
    {
        $data=$request->all();
        $submit_sourcing_remarks=$data['remarks'];
        $id=$data['unid'];
        $update_table=DB::table('tercouriers')->where('id',$id)->update(['sourcing_remarks'=>$submit_sourcing_remarks,'status'=>'3']);
        return $update_table;
    }

    public function handover_invoices_document(Request $request)
    {
        $data = $request->all();
        $user_type=$data['user_type'];
        $new_data = explode("|", $data['selected_value']);
        $details = Auth::user();
        $log_in_user_name = $details->name;
        $log_in_user_id = $details->id;
        $info = Tercourier::handover_invoice($new_data, $log_in_user_id, $log_in_user_name,$user_type);
        // $info=Tercourier::get_details_of_employee($data['selected_value']);
        return $info;
    }

    public function invoice_handover()
    {
        // $data = HandoverDetail::where('action_done', '0')->get();
        $data = InvoiceHandoverDetail::orderby('id', 'DESC')->get();
        $user = Auth::user();
        $user_type = json_decode(json_encode($user));
        $name = $user_type->roles[0]->name;

        // return $name;
        // if($name == 'reception')
        // {
        //     $data = HandoverDetail::where(['is_received'=>0])->get();
        // }
        // dd($data);
        return view('invoices.handover-invoice-list', ['handovers' => $data, 'name' => $name]);
    }

    public function accept_invoice_handover(Request $request)
    {

        $data = $request->all();
        $invoice_handover_id = $data['invoice_handover_id'];
        $user_type=$data['user_type'];
        $details = Auth::user();
        $user_id = $details->id;
        if($user_type == 'accounts'){
         $res = InvoiceHandoverDetail::where('invoice_handover_id', $invoice_handover_id)->update(array('is_received' => 1, 'action_done' => '1', 'user_id' => $user_id,'acc_accept_reject_date'=>date('Y-m-d'), 'updated_at' => date('Y-m-d H:i:s')));
        }
        else if($user_type == 'scanning'){
            $res = InvoiceHandoverDetail::where('invoice_handover_id', $invoice_handover_id)->update(array('is_received' => 1, 'action_done' => '1', 'user_id' => $user_id,'scan_accept_reject_date'=>date('Y-m-d'), 'updated_at' => date('Y-m-d H:i:s')));
            }
        if ($res) {
            $get_data = InvoiceHandoverDetail::where('invoice_handover_id', $invoice_handover_id)->get();
            $unids = $get_data[0]->unids;
            $explode_ter = explode(',', $unids);
            for ($i = 0; $i < sizeof($explode_ter); $i++) {
                $id = $explode_ter[$i];
                if($user_type == 'accounts'){
                $update_data = Tercourier::where('id', $id)->where('ter_type',1)->update(array('status' => 5));
                }
                else if($user_type == 'scanning'){
                    $update_data = Tercourier::where('id', $id)->where('ter_type',1)->update(array('status' => 8));

                }
             
            }
        }
        return $update_data;
    }

    public function reject_invoice_handover(Request $request)
    {

        $data = $request->all();
        $user_type=$data['user_type'];
        $invoice_handover_id = $data['invoice_handover_id'];
        $handover_remarks = $data['handover_remarks'];
        $details = Auth::user();
        $user_id = $details->id;
        if($user_type == 'accounts'){
        $res = InvoiceHandoverDetail::where('invoice_handover_id', $invoice_handover_id)->update(array('handover_remarks' => $handover_remarks, 'action_done' => '1','acc_accept_reject_date'=>date('Y-m-d'), 'user_id' => $user_id, 'user_action' => '0', 'updated_at' => date('Y-m-d H:i:s')));
        }
        else if($user_type == 'scanning'){
            $res = InvoiceHandoverDetail::where('invoice_handover_id', $invoice_handover_id)->update(array('handover_remarks' => $handover_remarks, 'action_done' => '1','scan_accept_reject_date'=>date('Y-m-d'), 'user_id' => $user_id, 'user_action' => '0', 'updated_at' => date('Y-m-d H:i:s')));
        }
        if ($res) {
            $get_data = InvoiceHandoverDetail::where('invoice_handover_id', $invoice_handover_id)->get();
            $unids = $get_data[0]->unids;
            $explode_ter = explode(',', $unids);
            for ($i = 0; $i < sizeof($explode_ter); $i++) {
                $id = $explode_ter[$i];
                // $get_ter_data=Tercourier::where('id',$id)->first();
                // $status= $get_ter_data->copy_status;
                if($user_type == 'accounts'){
                $update_data = Tercourier::where('id', $id)->update(array('status' => '3'));
                }
                else if($user_type == 'scanning'){
                    $update_data = Tercourier::where('id', $id)->update(array('status' => '6'));

                }
            }
        }
        return $update_data;
    }

    public function check_invoice_paid_status($id)
    {
        $check_invoice=DB::table('tercouriers')->where('id',$id)->update(['status'=>'6']);
    }


    public function update_scanning_data(Request $request)
    {
        $data = $request->all();
        $res = "";
      
        $image = $request->file('file');
        $fileName = $image->getClientOriginalName();
        $destinationPath = 'uploads/scan_doc';
        $image->move($destinationPath, $fileName);
        
        $res = DB::table('tercouriers')->where('id', $data['unid'])->update(['file_name'=>$fileName,'status'=>9,'scanning_remarks'=>$data['remarks']]);


        return $res;
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
            }else if ($check_status == 'fail') {
                $status = 0;
                $flag = 1;
            }
            $query = Tercourier::query();
            // return $flag;
            if ($flag) {

                $tercouriers = $query->where('ter_type',1)->where('status', $status)->orderby('id', 'DESC')->
                get();
                return [$tercouriers];
            } else {
                $tercouriers = $query->where('ter_type',1)->where('id', 'like', '%' . $searched_item . '%')->orWhere('invoice_no', 'like', '%' . $searched_item . '%')->orWhere('ax_id', 'like', '%' . $searched_item . '%')->orderby('id', 'DESC')->get();
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

    
    public function edit_invoice_details(Request $request)
    {
        $data = $request->all();
        $get_ter_details=DB::table('tercouriers')->where('id',$data['unid'])->where('ter_type',1)->get();
        if( $get_ter_details[0]->po_id != $data['po_id'])
        {
            $get_po_details=DB::table('pos')->where('id',$data['po_id'])->get();
            $data['ax_id']= $get_po_details[0]->ax_code;
            $data['sender_id']= $data['po_id'];
            $data['sender_name']= $get_po_details[0]->vendor_name;
            $data['pfu']= Helper::PoUnit($get_po_details[0]->unit);
            $data['po_value']= $get_po_details[0]->po_value;


        }

        $id = $data['unid'];
        $details = Auth::user();
        $data['saved_by_name'] = $details->name;
        $data['saved_by_id'] = $details->id;
        unset($data['unid']);

        $get_db_data = DB::table('tercouriers')->select('status')->where('id', $id)->get();
        if ($get_db_data[0]->status == 1) {
            $new = DB::table('tercouriers')->where('id', $id)->update($data);
            return $new;
        } else {
            return 0;
        }
    }
}
