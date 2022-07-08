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
use Illuminate\Support\Facades\Response;

class TercourierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Tercourier::query();
        $tercouriers = $query->with('CourierCompany')->orderBy('id','DESC')->get();
        return view('tercouriers.tercourier-list',['tercouriers'=>$tercouriers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $senders =  DB::table('sender_details')->get();
        $couriers = DB::table('courier_companies')->select ('id','courier_name')->distinct()->get();
        $categorys = DB::table('catagories')->select ('catagories')->distinct()->get();
        $forcompany = DB::table('for_companies')->select ('for_company')->distinct()->get();
        return view('tercouriers.create-tercourier',  ['senders'=>$senders, 'couriers' => $couriers ,'categorys' => $categorys ,'forcompany' => $forcompany]);
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
        $validator = Validator::make($request->all(),$rules);
    
        if($validator->fails())
        {
            $errors                  = $validator->errors();
            $response['success']     = false;
            $response['validation']  = false;
            $response['formErrors']  = true;
            $response['errors']      = $errors;
            return response()->json($response);
        }
        $terdata['sender_id']    = $request->sender_id;
        // $terdata['sender_name']  = $request->sender_name;
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

        $tercourier = Tercourier::create($terdata);
        if($tercourier)
        {
            $response['success'] = true;
            $response['messages'] = 'Succesfully Submitted';
            $response['redirect_url'] = URL::to('/tercouriers');
        }
        else
        {
            $response['success'] = false;
            $response['messages'] = 'Can not created TER Courier please try again';
        }
        return Response::json($response);  
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
}
