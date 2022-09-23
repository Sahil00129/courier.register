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
        'date_of_receipt', 'docket_no', 'docket_date', 'courier_id', 'sender_id', 'sender_name','ax_id','employee_id', 'location', 'company_name', 'terfrom_date', 'terto_date', 'details', 'amount', 'delivery_date', 'remarks', 'given_to', 'status', 'created_at', 'updated_at','finfect_response','refrence_transaction_id',
        'saved_by_id','saved_by_name'
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
    public static function get_details_of_employee($unique_ids,$user_id,$user_name)
    {
        $change['status'] = 2;
        $change['given_to'] = 'TR-Department';
        $change['saved_by_id']=$user_id;
        $change['saved_by_name']=$user_name;
        $change['delivery_date'] = date('Y-m-d');
        // $change['status'] = 1;
        $data =  DB::table('tercouriers')->whereIn('id', $unique_ids)->where('status',1)->update($change);
        // $data =  DB::table('tercouriers')->whereIn('id', $unique_ids)->update($change);
        return $data;
        
    }

   public static function add_data($voucher,$amount,$unique_ids,$user_id,$user_name)
   {
    $data['voucher_code'] = $voucher;
    $data['payable_amount'] = $amount;
    $data['status']=3;
    $data['saved_by_id']=$user_id;
    $data['saved_by_name']=$user_name;
    $data['updated_at'] = date('Y-m-d H:i:s');
    $query =  DB::table('tercouriers')->where('id', $unique_ids)
    ->update($data);
    return $query;
   }

   public static function add_voucher_payable($voucher,$amount,$unique_id,$user_id,$user_name,$payment_status)
   {
    //If Payment_Status = 1 than pay now if Payment_Status = 2 pay later.
    // Status=1 is Received, Status=2 is Handover, Status=3 is Sent to Finfect,For pay later Status=4 is Pay, Status=0 is Failed Payment
    if($payment_status == 1)
    {
        $data['status'] = 3;
    }else if($payment_status == 2)
    {
        $data['status'] = 4;
    }
    $data['voucher_code'] = $voucher;
    $data['payable_amount'] = $amount;
    $data['payment_status']=$payment_status;
    $data['updated_by_id']=$user_id;
    $data['updated_by_name']=$user_name;
    $data['updated_at'] = date('Y-m-d H:i:s');
    $query =  DB::table('tercouriers')->where('id', $unique_id)
    ->update($data);
    return $query;
   }

   public static function add_multiple_data($voucher,$amount,$unique_ids,$user_id,$user_name)
   {

    $data['voucher_code'] = $voucher;
    $data['payable_amount'] = $amount;
    $data['id']=$unique_ids;

    // $checkquery=DB::table('tercouriers')->select('amount','id')->whereIn('id',$unique_ids)->get()->toArray();
    // return $checkquery;

    foreach($data['id'] as $key => $newdata){
        $payable_amount=$data['payable_amount'][$key];
        $coupon=$data['voucher_code'][$key];
        $id=$newdata;
        $checkquery=DB::table('tercouriers')->select('amount','id')->where('id',$id)->get();


        if($checkquery[0]->amount > $payable_amount)
        {
            $query= DB::table('tercouriers')->
            where('id', $id)->
            update(array('payable_amount'=>$payable_amount,'voucher_code'=> $coupon,
            'status'=>3,'saved_by_id'=>$user_id,'saved_by_name'=>$user_name,'updated_at'=>date('Y-m-d H:i:s')));
        }else {
            return 0;
        }
      
        }

        return $query;

        
   }

}
