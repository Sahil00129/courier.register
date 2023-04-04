<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
    use HasFactory;
    protected $fillable = [
        'po_number', 'vendor_code', 'vendor_name', 'po_value', 'unit','activity', 'status', 'created_at', 'updated_at','vendor_unique_id',
    ];
    
}
