<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChildTercouriers;
use App\Models\Tercourier;
use App\Models\Sender;
use DB;
use Helper;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\TercourierController;
use AshAllenDesign\ShortURL\Facades\ShortURL;



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
        $data = $request->all();
        $mobile_num = $data['mobile_number'];

        //   $data['mobile_number']="sd ";
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

        // return \Request::ip();

        $otp = mt_rand(100000, 999999);
        // return $otp;
        // $get_sender=DB::table('S')->where('telephone_no',$mobile_num)->get();
        // $get_sender =  DB::table('sender_details')->where('telephone_no',$mobile_num)->get();
        $get_sender =  Sender::where('telephone_no', $mobile_num)->get();



        if (count($get_sender) == 0) {
            return "empty_array";
        } else {
            // echo "<pre>"; print_r($get_sender);exit;
            $res = DB::table('sender_details')->where('employee_id', $get_sender[0]->employee_id)->update(['otp' => $otp]);
            if ($res) {
                return ['available', $get_sender];
            }
        }

        // if(empty(json_decode($get_sender)))
        // {
        //     return 101;
        // }else{
        //     return 1;
        // }


    }

    public static function generate_otp_in_DB($mobile_num)
    {
        $otp = mt_rand(100000, 999999);
        // return $otp;
        // $get_sender=DB::table('S')->where('telephone_no',$mobile_num)->get();
        // $get_sender =  DB::table('sender_details')->where('telephone_no',$mobile_num)->get();
        $get_sender =  Sender::where('telephone_no', $mobile_num)->get();



        if (count($get_sender) == 0) {
            return "empty_array";
        } else {
            // echo "<pre>"; print_r($get_sender);exit;
            $res = DB::table('sender_details')->where('employee_id', $get_sender[0]->employee_id)->update(['otp' => $otp]);
            if ($res) {
                return ['available', $get_sender];
            }
        }
    }

    public function send_otp(Request $request)
    {
        $data = $request->all();
        $emp_id = $data['emp_id'];
        // $data['emp_id']="dsd";
        $validator = Validator::make($data, [
            'emp_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors                  = $validator->errors();
            $response['success']     = false;
            $response['validation']  = false;
            $response['formErrors']  = true;
            $response['errors']      = $errors;
            return response()->json($response);
        }
        // $emp_id="dsd";
        $get_sender_data = DB::table('sender_details')->where('employee_id', $emp_id)->get();
        if (count($get_sender_data) == 0) {
            return "empty_array";
        } else {

            if (empty($get_sender_data[0]->otp)) {
                self::generate_otp_in_DB($get_sender_data[0]->telephone_no);
                $get_updated_otp = DB::table('sender_details')->where('employee_id', $emp_id)->get();
                $otp = $get_updated_otp[0]->otp;
            } else {
                $otp = $get_sender_data[0]->otp;
            }

            // $API = "PY95H00rx0aSJP7v8ofVsA"; // GET Key from SMS Provider

            $API = "cBQcckyrO0Sib5k7y9eUDw";

            $mob = $get_sender_data[0]->telephone_no; // Get Mobile Number from Sender

            // $mob="abc";
            $name = $get_sender_data[0]->name;

            $ip = \Request::ip();
            // print_r($getsender);
            // exit;

            // $text = 'Dear User, Your OTP is ' . $otp . ' for AgriWings registration . Thanks, Agriwings Team';
            $text = 'Your OTP for generating TER UNID is  ' . $otp . '  Thanks Frontiers.';

            $url = 'http://sms.innuvissolutions.com/api/mt/SendSMS?APIkey=' . $API . '&senderid=FAPLHR&channel=Trans&DCS=0&flashsms=0&number=' . urlencode($mob) . '&text=' . urlencode($text) . '&route=2&peid=1201159713185947382';

            $res = $this->SendTSMS($url);
            $data_res = json_decode($res);
            if ($data_res->ErrorCode == "000") {
                $update_data =  DB::table('sender_details')->where('employee_id', $emp_id)->update(['otp_sent_time' => date('Y-m-d H:i:s'), 'last_ip' => $ip, 'sms_api_response' => $data_res->ErrorMessage]);
                if ($update_data) {
                    return "msg_sent";
                }
            } else {
                $update_data =  DB::table('sender_details')->where('employee_id', $emp_id)->update(['otp_sent_time' => date('Y-m-d H:i:s'), 'last_ip' => $ip, 'sms_api_response' => $data_res->ErrorMessage]);

                if ($update_data) {
                    return "msg_not_sent";
                }
            }

            // $response['success'] = true;
            // $response['messages'] = 'Succesfully Submitted';
            // $response['redirect_url'] = URL::to('/tercouriers');

            // $res= DB::table('sender_details')->where('employee_id',$get_sender_data[0]->employee_id)->update(['otp' => $otp]);
            // if($res)
            // {
            // return ['available', $get_sender_data];
            // }
        }
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

    public function verify_user_otp(Request $request)
    {
        $data = $request->all();
        $emp_id = $data['emp_id'];
        $otp = $data['otp'];
        // $data['otp']="ds";

        $validator = Validator::make($data, [
            'emp_id' => 'required|numeric',
            'otp' => 'required|numeric',

        ]);

        if ($validator->fails()) {
            $errors                  = $validator->errors();
            $response['success']     = false;
            $response['validation']  = false;
            $response['formErrors']  = true;
            $response['errors']      = $errors;
            return response()->json($response);
        }

        $get_sender_data = DB::table('sender_details')->where('employee_id', $emp_id)->get();

        if (count($get_sender_data) == 0) {
            return "empty_array";
        } else {


            if ($get_sender_data[0]->otp == $otp) {

                $get_sender_data = DB::table('sender_details')->where('employee_id', $emp_id)->update(['otp' => ""]);
                return "otp_matched";
            } else {
                return "invalid_otp";
            }
        }
    }



    public function verify_otp_for_PR(Request $request)
    {
        $data = $request->all();
        $emp_id = $data['emp_id'];
        $otp = $data['otp'];
        $unid = $data['ter_unid'];
        // $data['otp']="ds";

        $validator = Validator::make($data, [
            'emp_id' => 'required|numeric',
            'otp' => 'required|numeric',
            'ter_unid' => 'required|numeric',

        ]);

        if ($validator->fails()) {
            $errors                  = $validator->errors();
            $response['success']     = false;
            $response['validation']  = false;
            $response['formErrors']  = true;
            $response['errors']      = $errors;
            return response()->json($response);
        }

        $get_sender_data = DB::table('sender_details')->where('employee_id', $emp_id)->get();

        if (count($get_sender_data) == 0) {
            return "empty_array";
        } else {


            if ($get_sender_data[0]->otp == $otp) {

                DB::table('sender_details')->where('employee_id', $emp_id)->update(['otp' => ""]);

                // TercourierController::send_payment_advice($unid);
                $result = (new TercourierController)->send_payment_advice($unid);
                // $result = "mail_sent";
                if ($result == "mail_sent") {
                    $API = "cBQcckyrO0Sib5k7y9eUDw";

                    $mob = $get_sender_data[0]->telephone_no; // Get Mobile Number from Sender

                    // $mob="abc";
                    $name = $get_sender_data[0]->name;

                    //    https://free-url-shortener.rb.gy/
                    $otp = $get_sender_data[0]->otp;


                    // print_r($getsender);
                    // exit;

                    // $text = 'Dear User, Your OTP is ' . $otp . ' for AgriWings registration . Thanks, Agriwings Team';

                    //    $text = 'Dear ' . $name . ' , Your UNID ' . $check_ter_table->terto_date . ' has been generated successfully. Please save & use ' . $check_ter_table->terto_date . ' to track your document. Thanks Frontiers.';

                    $text = 'Dear ' . $name . ', Your payment advice for UNID ' . $unid . ' has been generated and Shared on your registered mail ID. Please Check your mail ID. Thanks Frontiers.';
                    $url = 'http://sms.innuvissolutions.com/api/mt/SendSMS?APIkey=' . $API . '&senderid=FAPLHR&channel=Trans&DCS=0&flashsms=0&number=' . urlencode($mob) . '&text=' . urlencode($text) . '&route=2&peid=1201159713185947382';

                    $res = $this->SendTSMS($url);
                    $data_res = json_decode($res);
                    if ($data_res->ErrorCode == "000") {
                        return "otp_matched";
                    }
                }
            } else {
                return "invalid_otp";
            }
        }
    }

    public function track_unid_for_employee(Request $request)
    {
        $data = $request->all();
        $unid = $data['unid'];
        // $unid="d";
        // $data['file']="ds";
        //   $data['amount']='100001';

        $validator = Validator::make($data, [
            'unid' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $errors                  = $validator->errors();
            $response['success']     = false;
            $response['validation']  = false;
            $response['formErrors']  = true;
            $response['errors']      = $errors;
            return response()->json($response);
        }

        $ter_data = Tercourier::with('Tercourier')->where('id', $unid)->get();
        if (count($ter_data) == 0) {
            return "unid_doesnot_exist";
        } else {
            return ['100', $ter_data];
        }
    }
    public function generate_unid_for_employee(Request $request)
    {
        $data = $request->all();
        $emp_id = $data['emp_id'];
        // $data['file']="ds";
        //   $data['amount']='100001';

        $validator = Validator::make($data, [
            'emp_id' => 'required|numeric',
            'amount' => 'required|numeric|max:100000',
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'file' => 'required|mimes:jpeg,png,jpg,pdf|max:5000',

        ]);

        if ($validator->fails()) {
            $errors                  = $validator->errors();
            $response['success']     = false;
            $response['validation']  = false;
            $response['formErrors']  = true;
            $response['errors']      = $errors;
            return response()->json($response);
        }

        // Check Needs to be added for mutilple unid generation

        // $check_unid=DB::table('tercouriers')->where('employee_id',$emp_id)->where('ter')->get();
        $ter_month = Helper::ShowFormatDate($data['to_date']);
        $get_ter_month = explode("-", $ter_month);

        $check_ter_table = Tercourier::where('employee_id', $emp_id)->orderby('id', 'desc')->first();

        if (!empty($check_ter_table)) {
            $check_ter_month = Helper::ShowFormatDate($check_ter_table->terto_date);
            $month = explode("-", $check_ter_month);
            if ($month[1] == $get_ter_month[1]) {
                return ["unid_already_generated", $get_ter_month[1], $check_ter_table->id];
            }
        }

        $get_sender = DB::table('sender_details')->where('employee_id', $emp_id)->get();

        if ($get_sender[0]->status == "Blocked") {
            if (!empty($get_sender[0]->last_working_date)) {
                $month_number = explode("-", $get_sender[0]->last_working_date);

                switch ($month_number[1]) {
                    case "Jan":
                        $month_number[1] = '01';
                        break;
                    case "Feb":
                        $month_number[1] = '02';
                        break;
                    case "Mar":
                        $month_number[1] = '03';
                        break;
                    case "Apr":
                        $month_number[1] = '04';
                        break;
                    case "May":
                        $month_number[1] = '05';
                        break;
                    case "Jun":
                        $month_number[1] = '06';
                    case "Jul":
                        $month_number[1] = '07';
                        break;
                    case "Aug":
                        $month_number[1] = '08';
                        break;
                    case "Sep":
                        $month_number[1] = '09';
                        break;
                    case "Oct":
                        $month_number[1] = '10';
                        break;
                    case "Nov":
                        $month_number[1] = '11';
                        break;
                    case "Dec":
                        $month_number[1] = '12';
                        break;
                }
                $final_exit_date = $month_number[2] . '-' . $month_number[1] . '-' . $month_number[0];
                // $data['to_date'] ="2022-10-02";
                $terDate = $data['to_date'];
                $exit_date = strtotime($final_exit_date);
                $ter_date = strtotime($terDate);
                // return [$ter_date,$exit_date];

                // print_r($sender_table->last_working_date);
                if ($final_exit_date < $terDate) {
                    return ['last_working_date', $get_sender[0]->last_working_date];
                }
            }
        }


        $terdata = array();

        $senders =  DB::table('sender_details')->where('employee_id', $emp_id)->get();
        //    return $senders;

        $terdata['ax_id']    = $senders[0]->ax_id;


        $terdata['iag_code']  = $senders[0]->iag_code;
        $terdata['pfu'] = $senders[0]->pfu;
        $terdata['sender_id'] = $senders[0]->id;
        $terdata['sender_name']  = $senders[0]->name;

        $designation_check = strtolower($senders[0]->designation);
        //    $designation_check='market development representative';

        if (
            $designation_check == 'market development representative' ||
            $designation_check == 'field executive'
            || $designation_check == 'project officer'
        ) {
            return "not_possible";
        }

        //    dd($data['file']);

        if (!empty($data['file'])) {

            $images = $data['file'];
            $path = Storage::disk('s3')->put('employee_scan_docs', $images);
            $get_real_names = explode('/', $path);
            $file_name = Storage::disk('s3')->url($path);
        }

        // https://dpportal.s3.us-east-2.amazonaws.com/employee_scan_docs/9TibAX3b248uVtnX3T7eokI5u5DrVjkLWpyiA9Wr.png
        $uploaded_file_name = $get_real_names[1];

        $terdata['saved_by_name'] = $senders[0]->name;
        $terdata['employee_id']    = $senders[0]->employee_id;
        $terdata['location']    = $request->location;
        $terdata['amount'] = $data['amount'];
        $terdata['status'] = 14;
        $terdata['ter_type'] = 2;
        $terdata['terfrom_date'] = $data['from_date'];
        $terdata['terto_date'] = $data['to_date'];



        // echo "<pre>";print_r($ter_data);die;

        $tercourier_save = Tercourier::create($terdata);

        if ($tercourier_save) {
            $childata['tercourier_id'] = $tercourier_save->id;
            $childata['unid_generated_date'] = date('Y-m-d');
            $childata['uploaded_file_name'] = $uploaded_file_name;
            $childata['uploaded_file_name'] = $uploaded_file_name;


            $saved = ChildTercouriers::create($childata);

            if ($saved) {
                $API = "cBQcckyrO0Sib5k7y9eUDw";

                $mob = $senders[0]->telephone_no; // Get Mobile Number from Sender

                // $mob="abc";
                $name = $senders[0]->name;

                //    https://free-url-shortener.rb.gy/
                $otp = $senders[0]->otp;

                $live_host_name = request()->getHttpHost();

                if ($live_host_name == 'localhost:8000' || $live_host_name == "test-courier.easemyorder.com") {
                    // test-courier url
                    $send_url = "https://rb.gy/p47is";
                } else {
                    // live-ter-url
                    $send_url = "https://rb.gy/1oa2k";
                }




                // print_r($getsender);
                // exit;

                // $text = 'Dear User, Your OTP is ' . $otp . ' for AgriWings registration . Thanks, Agriwings Team';

                //    $text = 'Dear ' . $name . ' , Your UNID ' . $check_ter_table->terto_date . ' has been generated successfully. Please save & use ' . $check_ter_table->terto_date . ' to track your document. Thanks Frontiers.';

                $text = 'Dear ' . $name . ' , Your UNID ' . $tercourier_save->id . ' has been generated successfully. Please save & use ' . $send_url . ' to track your document. Thanks Frontiers.';
                $url = 'http://sms.innuvissolutions.com/api/mt/SendSMS?APIkey=' . $API . '&senderid=FAPLHR&channel=Trans&DCS=0&flashsms=0&number=' . urlencode($mob) . '&text=' . urlencode($text) . '&route=2&peid=1201159713185947382';

                $res = $this->SendTSMS($url);
                $data_res = json_decode($res);
                if ($data_res->ErrorCode == "000") {
                    return ["100", $tercourier_save->id];
                } else {
                    return "msg_not_sent";
                }
            }
        }


        // $create_unid=Tercourier::create($)

    }
}
