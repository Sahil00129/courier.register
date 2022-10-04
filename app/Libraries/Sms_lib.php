<?php
namespace App\Libraries;

use Illuminate\Support\Facades\Auth;
use DB;

class Sms_lib {

	public static function send_paid_sms($id,$amount){
     
        return 1;
        $get_data=DB::table('tercouriers')->where('id',$id)->get()->toArray();
        $get_emp_id=$get_data[0]->employee_id;
        $get_sender_data=DB::table('sender_details')->where('employee_id',$get_emp_id)->get()->toArray();
        if(!empty($get_sender_data)){
        // return $get_sender_data[0]->name;
        $API = "cBQcckyrO0Sib5k7y9eUDw"; // GET Key from SMS Provider
        $peid = "1201159713185947382"; // Get Key from DLT 
        $sender_id = "FAPLHR"; // Approved from DLT
        $mob='7997263365';
        // $mob = $get_sender_data[0]->telephone_no; // Get Mobile Number from Sender 
        $name = $get_sender_data[0]->name;
        // print_r($getsender);
        // exit;

        $utr=$get_data[0]->utr;


        $UNID = $get_data[0]->id;
        $umsg = "TER UNID: $UNID Dear $name, payment against TER UNID: $UNID, for Rs. $amount , has been processed vide UTR no. $utr. In case, payment not received within 24 hours,please call TER Helpline with TER UNID Reference.Thanks! Frontiers";

        $url = 'http://sms.innuvissolutions.com/api/mt/SendSMS?APIkey=' . $API . '&senderid=' . $sender_id . '&channel=Trans&DCS=0&flashsms=0&number=' . urlencode($mob) . '&text=' . urlencode($umsg) . '&route=2&peid=' . urlencode($peid) . '';

       $sms_res= self::SendTSMS($url);
    //    if($sms_res)
    // 1 is sms sent and 2 is sms_not sent
       $decode_sms=json_decode($sms_res);
    //    echo $decode_sms;
       if($decode_sms->ErrorMessage == "Done")
       {
        DB::table('tercouriers')->where('id',$id)->update(['sms_sent'=>1]);
       }else{
        DB::table('tercouriers')->where('id',$id)->update(['sms_sent'=>2]);
       }

    }
       return 1;
        // $response['success'] = true;
        // $response['messages'] = 'Succesfully Submitted';
        // $response['redirect_url'] = URL::to('/tercouriers');
	}

    public static function SendTSMS($hostUrl)
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



}
