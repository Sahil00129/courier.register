<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildTercouriers extends Model
{
    use HasFactory;
    protected $table = 'child_tercouriers';
    protected $fillable = [
        'tercourier_id','unid_generated_date','created_at','updated_at','uploaded_file_name'
    ];

   
  
}
