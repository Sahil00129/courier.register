<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tercourier;
use DB;
use URL;
use Helper;
use Validator;
use Config;
use Session;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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
