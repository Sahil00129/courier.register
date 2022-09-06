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
        'date_of_receipt', 'docket_no', 'docket_date', 'courier_id', 'sender_id', 'sender_name', 'location', 'company_name', 'terfrom_date', 'terto_date', 'details', 'amount', 'delivery_date', 'remarks', 'given_to', 'status', 'created_at', 'updated_at'
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
    public static function get_details_of_employee($unique_ids)
    {
        $change['status'] = 2;
        // $change['status'] = 1;
        $data =  DB::table('tercouriers')->whereIn('id', $unique_ids)->where('status',1)->update($change);
        // $data =  DB::table('tercouriers')->whereIn('id', $unique_ids)->update($change);
        return $data;
        
    }

   public static function add_data($voucher,$amount,$unique_ids)
   {
    $data['voucher_code'] = $voucher;
    $data['payable_amount'] = $amount;
    $data['status']=3;
    $data['updated_at'] = date('Y-m-d H:i:s');
    $query =  DB::table('tercouriers')->where('id', $unique_ids)
    ->update($data);

    // if($query)
    // {
    //     $new_query_data=DB::table('tercouriers')->whereIn('status',[2,3])->get()->toArray();
    // }else{
    //     $new_query_data=0;
    // }

    // return $new_query_data;
    return $query;
   }

   public static function add_multiple_data($voucher,$amount,$unique_ids)
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
            'status'=>3, 'updated_at'=>date('Y-m-d H:i:s')));
        }else {
            return 0;
        }
      
        }

        return $query;

        
   }

}
