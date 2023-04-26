<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tercourier;
use App\Models\Sender;
use DB;
use Illuminate\Support\Facades\Validator;


date_default_timezone_set('Asia/Kolkata');
ini_set('max_execution_time', -1);

class MobileController extends Controller
{
    //
    public function generate_unid()
    {
        // $senders =  DB::table('sender_details')->get();
        // $couriers = DB::table('courier_companies')->select('id', 'courier_name')->distinct()->get();
        // $categorys = DB::table('catagories')->select('catagories')->distinct()->get();
        // $forcompany = DB::table('for_companies')->select('for_company')->distinct()->get();
        // //$lastdate = DB::table('tercouriers')->select('date_of_receipt')->latest()->distinct();
        // $lastdate = DB::table('tercouriers')->select('date_of_receipt', 'docket_no')->orderby('id', 'desc')->first();
        // //echo'<pre>'; print_r($lastdate);die;
        return view('mobile-docs.unid-generate');
    }

    public function check_registered_mobile(Request $request)
    {
        $data=$request->all();
        $mobile_num=$data['mobile_number'];

    //   $data['mobile_number']="7997263365";
        $validator = Validator::make($data, [
            // 'mobile_number' => 'required|numeric',
            'mobile_number' => 'required|string|min:10|max:10|regex:/[0-9]{9}/'
        ]);
  
        if ($validator->fails()) {
              $errors                  = $validator->errors();
            $response['success']     = false;
            $response['validation']  = false;
            $response['formErrors']  = true;
            $response['errors']      = $errors;
            return response()->json($response);
        }

        // $rules = array(
        //     'mobile_number' => 'required|max:10|numeric',

        // );
        // $validator = Validator::make($request->all(), $rules);

        // if ($validator->fails()) {
        //     $errors                  = $validator->errors();
        //     $response['success']     = false;
        //     $response['validation']  = false;
        //     $response['formErrors']  = true;
        //     $response['errors']      = $errors;
        //     return response()->json($response);
        // }

        return $mobile_num;
    }
}
