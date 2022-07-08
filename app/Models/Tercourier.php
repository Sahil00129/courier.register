<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tercourier extends Model
{
    use HasFactory;
    protected $fillable = [
        'date_of_receipt', 'docket_no', 'docket_date', 'courier_id', 'sender_id', 'sender_name', 'location', 'company_name', 'terfrom_date', 'terto_date', 'details', 'amount', 'delivery_date', 'remarks', 'given_to', 'status', 'created_at', 'updated_at'
    ];

    public function CourierCompany(){
        return $this->belongsTo('App\Models\CourierCompany','courier_id');
    }
    
}
