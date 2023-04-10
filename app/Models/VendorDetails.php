<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorDetails extends Model
{
    use HasFactory;
    protected $table = 'vendor_details';
    protected $fillable = [
        'name', 'unit', 'erp_code','created_at','updated_at','api_sent_data','api_response','saved_on_finfect','data_id'
    ];

}
