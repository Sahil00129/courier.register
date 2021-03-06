<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    use HasFactory;
    protected $table = 'sender_details';
    protected $fillable = [
        'ax_id', 'name', 'employee_id', 'type','location','telephone_no','last_working_date','status'
    ];
}
