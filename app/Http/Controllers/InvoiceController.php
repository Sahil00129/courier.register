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
     }
     
     public function index(Request $request)
     {
         if (Auth::check()) {
             $query = Tercourier::query();
             $user = Auth::user();
             $data = json_decode(json_encode($user));
             $name = $data->roles[0]->name;
             $couriers = DB::table('courier_companies')->select('id', 'courier_name')->distinct()->get();
                 $tercouriers = $query->whereIn('status', ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '11'])->where('ter_type',1)->with('CourierCompany','SenderDetail', 'HandoverDetail')->orderby('id', 'DESC')->paginate(20);
                 $role = "reception";

 
                 // $invoice_list = Tercourier::whereIn('status', ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '11'])->where('ter_type',1)->with('Po', 'HandoverDetail')->orderby('id', 'DESC')->paginate(2);
 
             
                // echo'<pre>'; print_r($tercouriers); die;
         }
 
         // echo'<pre>'; print_r($invoice_list); die;
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
            // 'po_number'    => 'required|unique:pos',
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
}
