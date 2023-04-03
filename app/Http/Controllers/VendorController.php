<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorDetails;
use Illuminate\Support\Facades\Auth;
date_default_timezone_set('Asia/Kolkata');


class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function vendorTable(Request $request)
    {
        $vendors = VendorDetails::all();
        if (Auth::check()) {
            $user = Auth::user();
            $data = json_decode(json_encode($user));
            $name = $data->name;
           
        }
        return view('pages.vendors-table',  ['vendors' => $vendors,'role' =>$name])->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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

 public function add_vendor_details(Request $request)
 {
    $data=$request->all();
    // return $data['url'];
    // return  $data['url']->getClientOriginalName();
    $vendor_data=array();
    

    if(!empty($data['vname']))
    {
        $vendor_data['vname'] =$data['vname'];
    }
    if(!empty($data['nature_of_assessee']))
    {
        $vendor_data['nature_of_assessee'] =$data['nature_of_assessee'];
    }
    if(!empty($data['contact_name']))
    {
        $vendor_data['contact_name'] =$data['contact_name'];
    }
    if(!empty($data['email']))
    {
        $vendor_data['email'] =$data['email'];
    }
    if(!empty($data['phone']))
    {
        $vendor_data['phone'] =$data['phone'];
    }
    if(!empty($data['cdesignation']))
    {
        $vendor_data['cdesignation'] =$data['cdesignation'];
    }
    if(!empty($data['state']))
    {
        $vendor_data['state'] =$data['state'];
    }
    if(!empty($data['pincode']))
    {
        $vendor_data['pincode'] =$data['pincode'];
    }
    if(!empty($data['vaddress']))
    {
        $vendor_data['vaddress'] =$data['vaddress'];
    }
    if(!empty($data['bname']))
    {
        $vendor_data['bname'] =$data['bname'];
    }
    if(!empty($data['ano']))
    {
        $vendor_data['ano'] =$data['ano'];
    }
    if(!empty($data['ahn']))
    {
        $vendor_data['ahn'] =$data['ahn'];
    }
    if(!empty($data['ifsc']))
    {
        $vendor_data['ifsc'] =$data['ifsc'];
    }
    if(!empty($data['baddress']))
    {
        $vendor_data['baddress'] =$data['baddress'];
    }
    if(!empty($data['url']))
    {
        $vendor_data['url'] =new \CURLFILE($data['url']);
    }
    if(!empty($data['msme_reg_no']))
    {
        $vendor_data['msme_reg_no'] =$data['msme_reg_no'];
    }
    if(!empty($data['gst']))
    {
        $vendor_data['gst'] =$data['gst'];
    }

    if(!empty($data['owner_name']))
    {
        $vendor_data['owner_name'] =$data['owner_name'];
    }

    if(!empty($data['nosorg']))
    {
        $vendor_data['nosorg'] =$data['nosorg'];
    }

    
    if(!empty($data['gst_url']))
    {
        $vendor_data['gst_url'] = new \CURLFILE($data['gst_url']);
    }

    
    if(!empty($data['mmse_url']))
    {
        $vendor_data['mmse_url'] =new \CURLFILE($data['mmse_url']);
    }
    
    if(!empty($data['others_url']))
    {
        $vendor_data['others_url'] =new \CURLFILE($data['others_url']);
    }
    
    if(!empty($data['pfu']))
    {
        $vendor_data['pfu'] =$data['pfu'];
    }
    if(!empty($data['mode']))
    {
        $vendor_data['mode'] = 'api';
    }
 


    
// print_r($vendor_data);
// exit;

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://beta.finfect.biz/api/add_vendor',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS => array('vname' => $data['vname'],'nature_of_assessee' => $data['nature_of_assessee'],'contact_name'=>$data['contact_name'],'email' => $data['email'],'phone' => $data['phone'],'cdesignation' => $data['cdesignation'],'state' => $data['state'],'pincode' => $data['pincode'],'vaddress' => $data['vaddress'],'bname' => $data['bname'],'ano' => $data['ano'],'ahn' => $data['ahn'],'ifsc' => $data['ifsc'],'baddress' => $data['baddress'],'url'=> new \CURLFILE($data['url']),'msme_reg_no' => $data['msme_reg_no'],
//   'gst' => $data['gst'],'owner_name' => $data['owner_name'],'nosorg' => $data['nosorg'],'gst_url'=> new \CURLFILE($data['gst_url']),'mmse_url'=> new \CURLFILE($data['mmse_url']),'others_url'=> new \CURLFILE($data['others_url']),'pfu' => '','mode' => 'api'),
CURLOPT_POSTFIELDS => $vendor_data,
));

$response = curl_exec($curl);

curl_close($curl);
$res=json_decode($response);
return $res;

// {"status":1,"message":"Vendor saved","data":10208}

    // $get_vendor=VendorDetails::where('erp_code',$data['erp_code'])->first();
    // // return $get_vendor;
    // if(empty($get_vendor)){
    // $add_data=VendorDetails::create($data);
    // }
    // else{
    //     $add_data=0;
    // }
    // return $add_data;

 }

 public function show_vendors_form()
 {

$bank_json = file_get_contents('assets/json/banks.json');
$bank_json_data = json_decode($bank_json,true);
$state_json = file_get_contents('assets/json/states-and-districts.json');
$state_json_data = json_decode($state_json,true);
// return $bank_json_data['bnames'];
// echo "<pre>";
// print_r($state_json_data['states'][0]['state']);
// exit;

    return view('pages.add-vendors', ['bank_json_data' => $bank_json_data['bnames'],'state_json_data' =>$state_json_data['states']]);

 }

 public function get_vendors($type)
 {
    $url= "https://beta.finfect.biz/api/getVendorList/".$type;
    
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

            return json_decode($response);
    // $get_vendors=VendorDetails::where('unit',$type)->get();
    // return $get_vendors;
 }
}
