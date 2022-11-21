<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeBalance extends Model
{
    use HasFactory;
    protected $table = 'employee_balance';
    protected $fillable = [
        'employee_id', 'current_balance', 'advance_amount','ter_expense_balance','ax_voucher_number', 'ter_id','ter_paid','utilize_amount','action_done','user_id','user_name','created_at','updated_at'
    ];

    public function SenderDetailsTable()
    {
        return $this->belongsTo('App\Models\Sender','employee_id', 'employee_id');
    }

    public static function utilized_advance($user_id,$user_name,$emp_id,$utilized_amount,$ter_id,$ter_pay_amount,$voucher_data)
    {
        
        $balance_data=EmployeeBalance::where('employee_id',$emp_id)->orderBy('id', 'DESC')->first();;
        // return $balance_data;
        if($balance_data->current_balance!=0)
        {
            $current_balance=$balance_data->current_balance;
            if($balance_data->ter_expense_balance){
            $insert_data['ter_expense_balance']=$current_balance-(int)$ter_pay_amount+$balance_data->ter_expense_balance;
            }
            $insert_data['ter_expense_balance']=$current_balance-(int)$ter_pay_amount;
            $insert_data['current_balance']=$current_balance-$utilized_amount;
        }else{
            $insert_data['current_balance']=$utilized_amount;
            $insert_data['ter_expense_balance']=$utilized_amount-(int)$ter_pay_amount;
        }
        // $insert_data['ter_expense_balance']=
        $insert_data['updated_date']=date('Y-m-d');
        $insert_data['employee_id']=$emp_id;
        $insert_data['advance_amount']=0;
        $insert_data['ter_id']=$ter_id;
        $insert_data['ax_voucher_number']=json_encode($voucher_data);
        $insert_data['ter_paid']=$ter_pay_amount;
        $insert_data['utilize_amount']=$utilized_amount;
        $insert_data['action_done']='Utilize';
        $insert_data['user_id']=$user_id;
        $insert_data['user_name']=$user_name;
        $insert_data['created_at']= date('Y-m-d H:i:s');
        $insert_data['updated_at']= date('Y-m-d H:i:s');
        // return $insert_data;
        $table_update=EmployeeBalance::insert($insert_data);
        return $table_update;
    }

    public static function employee_payment_detail($user_id,$user_name,$emp_id,$utilized_amount,$ter_id,$ter_pay_amount,$voucher_data)
    {
        $balance_data=EmployeeBalance::where('employee_id',$emp_id)->orderBy('id', 'DESC')->first();;
        // return $balance_data;
        if(!empty($balance_data))
        {
        if($balance_data->current_balance!=0)
        {
            $current_balance=$balance_data->current_balance;
            $insert_data['ter_expense_balance']=$current_balance-$ter_pay_amount;
            $insert_data['current_balance']=$current_balance-$utilized_amount;
        }else{
            $insert_data['current_balance']=0;
            if($balance_data->ter_expense_balance)
            {
            $insert_data['ter_expense_balance']=-$ter_pay_amount+$balance_data->ter_expense_balance;
            }else{
                $insert_data['ter_expense_balance']=-$ter_pay_amount;
            }
        }
    }else{
        $insert_data['current_balance']=0;
        $insert_data['ter_expense_balance']=-$ter_pay_amount;
    }
        // $insert_data['ter_expense_balance']=
        $insert_data['updated_date']=date('Y-m-d');
        $insert_data['employee_id']=$emp_id;
        $insert_data['advance_amount']=0;
        $insert_data['ter_id']=$ter_id;
        $insert_data['ax_voucher_number']=json_encode($voucher_data);
        $insert_data['ter_paid']=$ter_pay_amount;
        $insert_data['utilize_amount']=$utilized_amount;
        $insert_data['action_done']='Utilize';
        $insert_data['user_id']=$user_id;
        $insert_data['user_name']=$user_name;
        $insert_data['created_at']= date('Y-m-d H:i:s');
        $insert_data['updated_at']= date('Y-m-d H:i:s');
        // return $insert_data;
        $table_update=EmployeeBalance::insert($insert_data);
        return $table_update;
    }

}
