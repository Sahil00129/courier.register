<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sender extends Model
{
    use HasFactory;
    protected $table = 'sender_details';
    protected $fillable = [
        'ax_id', 'name', 'employee_id', 'type','location','telephone_no','last_working_date','status','grade',
        'designation','hq_state','territory','team','date_of_joining','category','date_of_birth','education_qualification',
       'gender','marital_status','official_email_id','personal_email_id','uan_number','esic_status',
        'esic_no','compliance_branch','department','pan','aadhar_number','account_number','ifsc','bank_name','branch_name','address_1',
        'address_2','address_3','address_district','address_state','address_pin_code'
    ];
}




