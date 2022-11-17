<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Maatwebsite\Excel\Concerns\ToArray;

class Tercourier extends Model
{
    use HasFactory;
    protected $table = 'tercouriers';
    protected $fillable = [
        'date_of_receipt', 'docket_no', 'docket_date', 'courier_id', 'sender_id', 'sender_name', 'ax_id', 'employee_id', 'location', 'company_name', 'terfrom_date', 'terto_date', 'details', 'amount', 'delivery_date', 'remarks','recp_entry_time', 'given_to', 'status', 'created_at', 'updated_at', 'finfect_response', 'refrence_transaction_id',
        'saved_by_id', 'saved_by_name','received_date','handover_date','sent_to_finfect_date','paid_date','created_at','updated_at','book_date','file_name'
    ];

    public function CourierCompany()
    {
        return $this->belongsTo('App\Models\CourierCompany', 'courier_id');
    }

    public function SenderDetail()
    {
        return $this->belongsTo('App\Models\Sender', 'sender_id');
    }

    // Dhruv's Code
    public static function get_details_of_employee($unique_ids, $user_id, $user_name)
    {
        // return $unique_ids;
        $res=DB::table('tercouriers')->whereIn('id',$unique_ids)->where('status',1)->get();
      
        
        // foreach($res as $r){
        //     print_r($r->id);
        //     exit;
        // }

        for($i=0;$i<sizeof($res);$i++)
        {
            
        $date=date_create($res[$i]->terto_date);
        date_add($date,date_interval_create_from_date_string("45 days"));
        $date_check= date_format($date,"Y-m-d");

        $today_date=date('Y-m-d');
        if($today_date<=$date_check)
        {
        $change['status'] = 2;
        }else{
        $change['status']=8;
        $change['txn_type']="rejected_ter";
        }
        if($res[$i]->employee_id == 0)
        {
            $change['status']=9;
            $change['txn_type']="emp_doesn't_exists";
        }
        // if (!empty($res[$i]->last_working_date)) {
        //     $change_status = DB::table('tercouriers')->where("id", $data['unique_id'])->update(array(
        //         'payment_type' => 'full_and_final_payment', 'status' => 4, 'payment_status' => 3, 'book_date' => date('Y-m-d')
        //     ));
        //     return $change_status;
        // }
        $change['given_to'] = 'TR-Department';
        $change['saved_by_id'] = $user_id;
        $change['saved_by_name'] = $user_name;
        $change['handover_date']=date('Y-m-d');
        $change['delivery_date'] = date('Y-m-d');
        // print_r($today_date);
        // print_r($date_check);
        // print_r($change);
        // exit;
        $data =  DB::table('tercouriers')->where('id', $res[$i]->id)->update($change);
        }
    
     
        // $change['status'] = 1;
     
        // $data =  DB::table('tercouriers')->whereIn('id', $unique_ids)->update($change);
        return $data;
    }

    public static function add_data($voucher, $amount, $unique_ids, $user_id, $user_name)
    {
        $data['voucher_code'] = $voucher;
        $data['payable_amount'] = $amount;
        $data['status'] = 3;
        $data['saved_by_id'] = $user_id;
        $data['saved_by_name'] = $user_name;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $query =  DB::table('tercouriers')->where('id', $unique_ids)
            ->update($data);
        return $query;
    }

    public static function add_voucher_payable($payable_data, $unique_id, $user_id, $user_name, $payment_status,$final_payable)
    {
        //If Payment_Status = 1 than pay now if Payment_Status = 2 pay later payment_status=3 is full and final,payment_status=4 is advance_payment, payment_status=5 is manually_paid,payment_status=6 deduction_settlement.
        // Status=1 is Received, Status=2 is Handover, Status=3 is Sent to Finfect,For pay later and full & final Status=4 is Pay, Status=0 is Failed Payment,Status=5 is Paid,Status=6 is cancelled ter,Status=7 Partially Paid,Status=8 Rejected TER,Status=9 Emp Doesn't Exists
        $check_pay_type=DB::table('tercouriers')->select('payment_type')->where('id',$unique_id)->get();
    //    echo "<pre>";
    //    print_r($payment_status);
    //    exit;
        if ($payment_status == 1) {
            $data['status'] = 3;
            if($check_pay_type[0]->payment_type == "pay_later_payment" )
            {
                $data['payment_type'] = "pay_later_payment";
                $data['sent_to_finfect_date']="";
                $data['book_date'] = date('Y-m-d');
            }else if($check_pay_type[0]->payment_type == "full_and_final_payment" )
            {
                $data['payment_type'] = "full_and_final_payment";
                $data['sent_to_finfect_date']="";
                $data['book_date'] = date('Y-m-d');
            }
            $data_ter = DB::table('tercouriers')->where('id', $unique_id)->get()->toArray();
            $id_sender = $data_ter[0]->sender_id;
            $check_last_working = DB::table('sender_details')->where('id', $id_sender)->get()->toArray();
            if ($check_last_working[0]->last_working_date) {
                $data['payment_type'] = "full_and_final_payment";
                $payment_status=3;
                $data['sent_to_finfect_date']="";
                $data['book_date'] = date('Y-m-d');
            } else {
                $data['payment_type'] = "regular_payment";
                $data['sent_to_finfect_date']=date('Y-m-d');
                $data['book_date'] = date('Y-m-d');
            }
        } else if ($payment_status == 2) {
            $data['status'] = 4;
            $data['sent_to_finfect_date']="";
            $data['book_date'] = date('Y-m-d');
            $data_ter = DB::table('tercouriers')->where('id', $unique_id)->get()->toArray();
            $id_sender = $data_ter[0]->sender_id;
            $check_last_working = DB::table('sender_details')->where('id', $id_sender)->get()->toArray();
            if ($check_last_working[0]->last_working_date) {
                $data['payment_type'] = "full_and_final_payment";
                $payment_status=3;
                $data['sent_to_finfect_date']="";
                $data['book_date'] = date('Y-m-d');
            } else {
                $data['payment_type'] = "pay_later_payment";
                $data['sent_to_finfect_date']="";
                $data['book_date'] = date('Y-m-d');
            }
        }
        else if ($payment_status == 4) {
            $data['status'] = 5;
            $data['payment_type'] = "advance_payment";
            $data['paid_date']=date('Y-m-d');
            $data['sent_to_finfect_date']="";
            $data['book_date'] = date('Y-m-d');
        }

        // $data['payment_status'] = $payment_status;
        $data['final_payable'] =$final_payable;
        $data['updated_by_id'] = $user_id;
        $data['updated_by_name'] = $user_name;
        $data['updated_at'] = date('Y-m-d H:i:s');
        

        if(!empty($payable_data))
        {
          
        $data['payment_status'] = $payment_status;
        $length = sizeof($payable_data);
        for ($i = 0; $i < $length; $i++) {
            $pay_data[$i] = $payable_data[$i]['payable_amount'];
            $voucher_data[$i] = $payable_data[$i]['voucher_code'];
        }

        $data['payable_amount'] = $pay_data;
        $data['voucher_code'] = $voucher_data;
        }
// return $data;
        $query =  DB::table('tercouriers')->where('id', $unique_id)
            ->update($data);

        return $query;
    }

    public static function add_multiple_data($voucher, $amount, $unique_ids, $user_id, $user_name)
    {

        $data['voucher_code'] = $voucher;
        $data['payable_amount'] = $amount;
        $data['id'] = $unique_ids;

        // $checkquery=DB::table('tercouriers')->select('amount','id')->whereIn('id',$unique_ids)->get()->toArray();
        // return $checkquery;

        foreach ($data['id'] as $key => $newdata) {
            $payable_amount = $data['payable_amount'][$key];
            $coupon = $data['voucher_code'][$key];
            $id = $newdata;
            $checkquery = DB::table('tercouriers')->select('amount', 'id')->where('id', $id)->get();


            if ($checkquery[0]->amount > $payable_amount) {
                $query = DB::table('tercouriers')->where('id', $id)->update(array(
                        'payable_amount' => $payable_amount, 'voucher_code' => $coupon,
                        'status' => 3, 'saved_by_id' => $user_id, 'saved_by_name' => $user_name, 'updated_at' => date('Y-m-d H:i:s')
                    ));
            } else {
                return 0;
            }
        }

        return $query;
    }
}
