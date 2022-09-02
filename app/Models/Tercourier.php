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
}
