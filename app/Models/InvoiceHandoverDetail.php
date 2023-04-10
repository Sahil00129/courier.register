<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHandoverDetail extends Model
{
    use HasFactory;
    protected $table = 'invoice_handover_details';
    protected $fillable = [
        'invoice_handover_id','invoice_id_count','unids','handover_by_department','handover_to_department','handover_remarks','is_received',
        'action_done','created_user_id','handover_date','user_id','created_at','updated_at','user_action','acc_handover_date','acc_accept_reject_date',
        'scan_accept_reject_date'

    ];
}
