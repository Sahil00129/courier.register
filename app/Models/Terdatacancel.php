<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Terdatacancel extends Model
{
    use HasFactory;
    protected $table = 'ter_data_cancel';
    protected $fillable = [
      'updated_id','old_status','remarks','updated_date','updated_by_user_id','updated_by_user_name','created_at','updated_at'
    ];
}




