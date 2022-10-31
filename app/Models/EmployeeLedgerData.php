<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EmployeeBalance;
use DB;


class EmployeeLedgerData extends Model
{
    use HasFactory;
    protected $table = 'employee_ledger_data';
    protected $fillable = [
        'employee_id', 'wallet_id', 'ter_id', 'ter_expense', 'ledger_balance', 'ax_voucher_number', 'updated_date', 'incoming_payment', 'utilize_amount', 'action_done', 'user_id', 'user_name', 'created_at', 'updated_at'
    ];


    public static function set_employee_in_ledger($created_date,$emp_id,$type,$user_id,$user_name)
    {
        $insert_data['updated_date']=date('Y-m-d');
        $insert_data['employee_id']=$emp_id;
        $insert_data['utilize_amount']=0;
        $insert_data['action_done']='new_emp';
        $insert_data['user_id']=$user_id;
        $insert_data['user_name']=$user_name;
        $insert_data['updated_date']=$created_date;
        $insert_data['created_at']= date('Y-m-d H:i:s');
        $insert_data['updated_at']= date('Y-m-d H:i:s');
        if($type == "imprest_ledger" )
        {
            $insert_data['advance_amount']=0;
            $insert_data['current_balance']=0;

            EmployeeBalance::insert($insert_data);
        }
        if($type == "emp_ledger" )
        {
            unset($insert_data['advance_amount']);
            unset($insert_data['current_balance']);
            $insert_data['incoming_payment']=0;
            $insert_data['ledger_balance']=0;

            EmployeeLedgerData::insert($insert_data);
        }

    }
    public static function employee_payment_detail($user_id, $user_name, $emp_id, $utilized_amount, $ter_id, $ter_pay_amount, $voucher_data)
    {
        $balance_data = EmployeeBalance::where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
        $ledger_data = EmployeeLedgerData::where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
        $date_created = DB::table('sender_details')->select('created_at')->where('employee_id', $emp_id)->get();
        $new_data = explode(" ", $date_created[0]->created_at);
        $created_date = date("d-m-Y", strtotime($new_data[0]));
        if(empty($balance_data))
        {
            self::set_employee_in_ledger($created_date,$emp_id,'imprest_ledger',$user_id,$user_name);
        }
        if(empty($ledger_data))
        {
            self::set_employee_in_ledger($created_date,$emp_id,'emp_ledger',$user_id,$user_name);
        }
        $balance_data = EmployeeBalance::where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
        $ledger_data = EmployeeLedgerData::where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();

            $current_balance = $balance_data->current_balance;
            if ($current_balance != 0) {
                    $insert_data['ledger_balance'] = $ledger_data->ledger_balance - (int)$ter_pay_amount;
         
                // $insert_data['current_balance']=$current_balance-$utilized_amount;
            } else {
                // $insert_data['current_balance']=$utilized_amount;
                $insert_data['ledger_balance'] = $ledger_data->ledger_balance - (int)$ter_pay_amount;
                $insert_data['wallet_id'] = 0;
                $insert_data['incoming_payment'] = 0;
            }
    

        $insert_data['action_done'] = 'Ter_Book';
        $insert_data['ter_expense'] = $ter_pay_amount;
        $insert_data['utilize_amount'] = 0;
        // $insert_data['ter_expense_balance']=
        $insert_data['updated_date'] = date('Y-m-d');
        $insert_data['employee_id'] = $emp_id;
        $insert_data['ter_id'] = $ter_id;
        $insert_data['ax_voucher_number'] = json_encode($voucher_data);
        $insert_data['user_id'] = $user_id;
        $insert_data['user_name'] = $user_name;
        $insert_data['created_at'] = date('Y-m-d H:i:s');
        $insert_data['updated_at'] = date('Y-m-d H:i:s');
        // return $insert_data;
        $table_update = EmployeeLedgerData::insert($insert_data);
        return $table_update;
    }
    

    public static function finfect_deduction_paid_payment($ter_id)
    {
        $get_ter_data=DB::table('ter_deduction_settlements')->where('parent_ter_id',$ter_id)->orderby("book_date","DESC")->first();
        // echo "<pre>";
        // print_r($get_ter_data);
        // exit;
        $data['employee_id']=$get_ter_data->employee_id;
        $data['incoming_payment']=$get_ter_data->final_payable;
        $data['ter_id']=$ter_id;
        $data['child_ter_id']=$get_ter_data->id;
        $data['updated_date']= date('Y-m-d');
        $data['action_done']="Ter_Paid";
        $data['ax_voucher_number']=$get_ter_data->voucher_code;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $get_ledger_balance=EmployeeLedgerData::where('employee_id', $data['employee_id'])->orderBy('id', 'DESC')->first();
        
        if($get_ledger_balance->ledger_balance > 0)
        {
            $data['ledger_balance'] = $data['incoming_payment'] + $get_ledger_balance->ledger_balance;
        }
       else if ($get_ledger_balance->ledger_balance) {
            $data['ledger_balance'] =  $data['incoming_payment'] - abs($get_ledger_balance->ledger_balance);
        } else {
            $data['ledger_balance'] =  $data['incoming_payment'];
        }
        //   echo "<pre>";
        // print_r($data);
        // exit;
      $res=  EmployeeLedgerData::insert($data);
      return $res;

    }

    public static function finfect_paid_payment($ter_id)
    {
        $get_ter_data=DB::table('tercouriers')->where('id',$ter_id)->get();
        // echo "<pre>";
        // print_r($get_ter_data);
        // exit;
        $data['employee_id']=$get_ter_data[0]->employee_id;
        $data['incoming_payment']=$get_ter_data[0]->final_payable;
        $data['ter_id']=$ter_id;
        $data['updated_date']= date('Y-m-d');
        $data['action_done']="Ter_Paid";
        $data['ax_voucher_number']=$get_ter_data[0]->voucher_code;
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        $get_ledger_balance=EmployeeLedgerData::where('employee_id', $data['employee_id'])->orderBy('id', 'DESC')->first();
        
        if($get_ledger_balance->ledger_balance > 0)
        {
            $data['ledger_balance'] = $data['incoming_payment'] + $get_ledger_balance->ledger_balance;
        }
       else if ($get_ledger_balance->ledger_balance) {
            $data['ledger_balance'] =  $data['incoming_payment'] - abs($get_ledger_balance->ledger_balance);
        } else {
            $data['ledger_balance'] =  $data['incoming_payment'];
        }
        //   echo "<pre>";
        // print_r($data);
        // exit;
      $res=  EmployeeLedgerData::insert($data);
      return $res;

    }


    public static function update_advance_in_ledger($user_id, $user_name, $emp_id, $ter_id, $advance_amount, $voucher_data)
    
    {
        $balance_data = EmployeeBalance::where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
        $ledger_data = EmployeeLedgerData::where('employee_id', $emp_id)->orderBy('id', 'DESC')->first();
        // return $balance_data->current_balance;

            $insert_data['action_done'] = 'Imprest';
            $insert_data['wallet_id'] = $balance_data->id;
            $insert_data['incoming_payment'] = $advance_amount;
            $insert_data['ter_expense'] = 0;

       
            $current_balance = $balance_data->current_balance;
            // print_r($current_balance);
            // exit;
            if ($current_balance != 0) {
                if($ledger_data->ledger_balance >0)
                {
                    $insert_data['ledger_balance'] = $insert_data['incoming_payment'] +$ledger_data->ledger_balance;
                    $utilize_amount_ledger=0;
                }
              else if ($ledger_data->ledger_balance) {
                    $insert_data['ledger_balance'] = $current_balance - abs($ledger_data->ledger_balance);
                    $utilize_amount_ledger=abs($ledger_data->ledger_balance);
                } else {
                    $insert_data['ledger_balance'] = $current_balance;
                    $utilize_amount_ledger=0;
                }
         
                // $insert_data['current_balance']=$current_balance-$utilized_amount;
                if($insert_data['ledger_balance'] < 0)
                {
               $set_data['current_balance']=0;
                }else{
                    $set_data['current_balance']=$insert_data['ledger_balance'];
                }

          
    
                $set_data['utilize_amount']=$utilize_amount_ledger;
                $set_data['updated_date']=date('Y-m-d');
                $set_data['employee_id']=$emp_id;
                $set_data['advance_amount']=0;
                $set_data['ter_id']=$ledger_data->ter_id;
                $set_data['ter_paid']=0;
                $set_data['action_done']='Ledger_Utilize';
                $set_data['user_id']=$user_id;
                $set_data['user_name']=$user_name;
                $set_data['created_at']= date('Y-m-d H:i:s');
                $set_data['updated_at']= date('Y-m-d H:i:s');
                if($utilize_amount_ledger != 0)
                {
                EmployeeBalance::insert($set_data);
                }
            } 
            else{
                return 1;
            }
            // else {
            //     // $insert_data['current_balance']=$utilized_amount;
            //     if (!empty($ledger_data)) {
            //         $insert_data['ledger_balance'] = $utilized_amount - $ter_pay_amount + $ledger_data->ledger_balance;
            //     } else {
            //         $insert_data['ledger_balance'] = $utilized_amount - $ter_pay_amount;
            //     }
            //     $insert_data['ledger_balance'] = $utilized_amount - $ter_pay_amount;
            //     $insert_data['wallet_id'] = 0;
            //     $insert_data['incoming_payment'] = 0;
            // }
        

        $insert_data['utilize_amount'] = 0;
        // $insert_data['ter_expense_balance']=
        $insert_data['updated_date'] = date('Y-m-d');
        $insert_data['employee_id'] = $emp_id;
        $insert_data['ter_id'] = $ter_id;
        $insert_data['ax_voucher_number'] = json_encode($voucher_data);
        $insert_data['user_id'] = $user_id;
        $insert_data['user_name'] = $user_name;
        $insert_data['created_at'] = date('Y-m-d H:i:s');
        $insert_data['updated_at'] = date('Y-m-d H:i:s');
        // return $insert_data;
        $table_update = EmployeeLedgerData::insert($insert_data);
        return $table_update;
    }
}
