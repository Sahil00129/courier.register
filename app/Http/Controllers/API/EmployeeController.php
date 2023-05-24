<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sender;
use Helper;

class EmployeeController extends Controller
{
    public function getEmployee(){
        try{
            $query = Sender::select('id','name','employee_id','grade','status','personal_email_id')->get();
            if($query){
                $data = $query;
                $message = "Employee fetched Successfully";
                $status = true;
                $errorCode = 200;
            }
        }catch(Exception $e) {
            $data = '';
            $message = "Invalid Record";
            $status = false;
            $errorCode = 401;
        }
        return Helper::apiResponseSend($message,$data,$status,$errorCode);
    }

    public function getEmployeeDetail($emp_id) {
        try{
            $query = Sender::where('id',$emp_id)->select('id','name','employee_id','grade','status','personal_email_id')->get();
            if($query){
                $data = $query;
                $message = "Employee fetched Successfully";
                $status = true;
                $errorCode = 200;
            }
        }catch(Exception $e) {
            $data = '';
            $message = "Invalid Record";
            $status = false;
            $errorCode = 401;
        }
        return Helper::apiResponseSend($message,$data,$status,$errorCode);
    }
}
