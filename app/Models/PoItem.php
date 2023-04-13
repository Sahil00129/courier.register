<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoItem extends Model
{
    use HasFactory;
    protected $table = 'po_items';
    protected $fillable = [
      'item_type','item_desc','quantity','unit_price','total_amount','created_at','updated_at','po_id',
    ];
}
