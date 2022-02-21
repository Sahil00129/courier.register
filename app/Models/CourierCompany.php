<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourierCompany extends Model
{
    use HasFactory;
    protected $table = 'courier_companies';
    protected $fillable = [
        'courier_name'
    ];
}
