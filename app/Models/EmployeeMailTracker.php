<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeMailTracker extends Model
{
 
    use HasFactory;
    protected $table = 'employee_mail_trackers';
    protected $fillable = [
        'employee_id','ter_month','mail_date','mail_number','ter_received','saved_last_date','ter_reject','mail_sent','created_at','updated_at','last_mail_date'
    ];
}
