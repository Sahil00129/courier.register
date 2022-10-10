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
        'date_of_receipt', 'docket_no', 'docket_date', 'courier_id', 'sender_id', 'sender_name', 'ax_id', 'employee_id', 'location', 'company_name', 'terfrom_date', 'terto_date', 'details', 'amount', 'delivery_date', 'remarks', 'given_to', 'status', 'created_at', 'updated_at', 'finfect_response', 'refrence_transaction_id',
        'saved_by_id', 'saved_by_name'
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
        $change['status'] = 2;
        $change['given_to'] = 'TR-Department';
        $change['saved_by_id'] = $user_id;
        $change['saved_by_name'] = $user_name;
        $change['delivery_date'] = date('Y-m-d');
        // $change['status'] = 1;
        $data =  DB::table('tercouriers')->whereIn('id', $unique_ids)->where('status', 1)->update($change);
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
        //If Payment_Status = 1 than pay now if Payment_Status = 2 pay later payment_status=3 is full and final,payment_status=4 is advance_payment and status=5 is paid.
        // Status=1 is Received, Status=2 is Handover, Status=3 is Sent to Finfect,For pay later and full & final Status=4 is Pay, Status=0 is Failed Payment,Status=5 is Paid,Status=6 is cancelled ter
       $check_pay_type=DB::table('tercouriers')->select('payment_type')->where('id',$unique_id)->get();
        if ($payment_status == 1) {
            $data['status'] = 3;
            $data['payment_type'] = "regular_payment";
            if($check_pay_type[0]->payment_type == "pay_later_payment" )
            {
                $data['payment_type'] = "pay_later_payment";
            }else if($check_pay_type[0]->payment_type == "full_and_final_payment" )
            {
                $data['payment_type'] = "full_and_final_payment";
            }
        } else if ($payment_status == 2) {
            $data['status'] = 4;
            $data_ter = DB::table('tercouriers')->where('id', $unique_id)->get()->toArray();
            $id_sender = $data_ter[0]->sender_id;
            $check_last_working = DB::table('sender_details')->where('id', $id_sender)->get()->toArray();
            if ($check_last_working[0]->last_working_date) {
                $data['payment_type'] = "full_and_final_payment";
                $payment_status=3;
            } else {
                $data['payment_type'] = "pay_later_payment";
            }
        }
        else if ($payment_status == 4) {
            $data['status'] = 5;
            $data['payment_type'] = "advance_payment";
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
