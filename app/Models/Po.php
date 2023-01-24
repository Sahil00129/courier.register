<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
    use HasFactory;
    protected $table = 'pos';
    protected $fillable = [
        'po_number', 'ax_code', 'vendor_name', 'po_value', 'unit', 'status', 'created_at', 'updated_at'
    ];
    
}
