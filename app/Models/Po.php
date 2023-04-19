<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
    use HasFactory;
    protected $fillable = [
        'po_number', 'vendor_code', 'vendor_name', 'po_value', 'unit','activity', 'status', 'created_at', 'updated_at','vendor_unique_id',
        'total_tax_amount','gst_rate','gst_amount','source_po_num','erp_num','state','crop','amm_agm','po_date','product','initial_po_value'
    ];

    // status 1 is open, status 2 is semiclosed, status 3 is closed, status 4 is cancelled

    public function PoItems()
    {
        return $this->hasMany('App\Models\PoItem','po_id','id');
    }
    public function PoItem()
    {
        return $this->hasOne('App\Models\PoItem','po_id','id');
    }

    public function PoTercouriers()
    {
        return $this->hasMany('App\Models\Tercourier','po_id','id');
    }
    
}
