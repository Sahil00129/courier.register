<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TerDeductionSettlement extends Model
{
    use HasFactory;
      protected $table = 'ter_deduction_settlements';
    protected $fillable = [
        'parent_ter_id', 'employee_name', 'employee_id', 'ax_code','terfrom_date','terto_date','actual_amount','prev_payable_sum','payable_amount',
        'voucher_code','book_date','payment_type','status','remarks','utr','file_name','reference_transaction_id','finfect_response','saved_by_id',
        'saved_by_name','left_amount','final_payable','updated_by_id','updated_by_name','created_at','updated_at','pfu','iag_code','advance_used',
    ];
}
