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

class TercourierController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
        $this->middleware('permission:tercouriers/create' ,['only' => ['create']]);
        $this->middleware('permission:tercouriers' ,['only' => ['index']]);

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Tercourier::query();
        $tercouriers = $query->with('CourierCompany','SenderDetail')->orderby('id','DESC')->get();
        //echo'<pre>';print_r($tercouriers); die;
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
        //$lastdate = DB::table('tercouriers')->select('date_of_receipt')->latest()->distinct();
        $lastdate = DB::table('tercouriers')->select('date_of_receipt','docket_no')->orderby('id', 'desc')->first();
        //echo'<pre>'; print_r($lastdate);die;
        return view('tercouriers.create-tercourier',  ['senders'=>$senders, 'couriers' => $couriers ,'categorys' => $categorys ,'forcompany' => $forcompany,'lastdate' => $lastdate]);
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
        // dd($tercourier->id);
        if($tercourier)
        {
            $getsender = Sender::where('id',$tercourier->sender_id)->first();

            $API = "cBQcckyrO0Sib5k7y9eUDw"; // GET Key from SMS Provider
            $peid = "1201159713185947382"; // Get Key from DLT 
            $sender_id = "FAPLHR"; // Approved from DLT
            $mob = $getsender->telephone_no; // Get Mobile Number from Sender
            $name = $getsender->name;

            $from_period = Helper::ShowFormat($tercourier->terfrom_date);
            $to_period = Helper::ShowFormat($tercourier->terto_date);

            $UNID = $tercourier->id;
            $umsg= "Dear $name , your TER for Period $from_period to $to_period has been received and is under process. TER UNID is $UNID Thanks! Frontiers";

            $url = 'http://sms.innuvissolutions.com/api/mt/SendSMS?APIkey='.$API.'&senderid='.$sender_id.'&channel=Trans&DCS=0&flashsms=0&number='.urlencode($mob).'&text='.urlencode($umsg).'&route=2&peid='.urlencode($peid).'';

            $this->SendTSMS($url);

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

    public function SendTSMS($hostUrl){
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

    public function addTrRow()
    {
        if(isset($_REQUEST['action']) and $_REQUEST['action']=="addDataRow"){
            $senders =  DB::table('sender_details')->get();
            $couriers = DB::table('courier_companies')->select ('id','courier_name')->distinct()->get();

            $decode  = json_decode(json_encode($senders));
            $decode_couriers  = json_decode(json_encode($couriers));
            //echo "<pre>";print_r($decode);die;
            ?>
            <tr>
                <td></td><td></td>
                <td>
                    <input type="date" class="form-control" name="date_of_receipt" id="date_of_receipt" Required>                                          
                </td>
                <td colspan="3">
                    <select class="form-control  basic" name="sender_id" id="select_employee">
                        <option selected disabled>search..</option>
                        <?php
                         foreach($decode as $sender){?>
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
                <td><input type="text" class="form-control"  id="details" name="details"></td>
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
                         foreach($decode_couriers as $courier){?>
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

    // get Employees on change
    public function getEmployees(Request $request)
    {
        $getempoloyees = Sender::where('id',$request->emp_id)->first();
        if($getempoloyees)
        {
            $response['success']         = true;
            $response['success_message'] = "Employees list fetch successfully";
            $response['error']           = false;
            $response['data']            = $getempoloyees;
        }else{
            $response['success']         = false;
            $response['error_message']   = "Can not fetch employee list please try again";
            $response['error']           = true;
        }
    	return response()->json($response);
    }

    public function terBundles(Request $request)
    {
        $query = Tercourier::query();
        $tercouriers = $query->with('CourierCompany','SenderDetail')->orderby('id','DESC')->get();
        return view('tercouriers.terbundles-list',['tercouriers'=>$tercouriers]);
    }

}
