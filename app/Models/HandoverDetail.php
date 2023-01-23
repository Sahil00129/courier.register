<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HandoverDetail extends Model
{
    use HasFactory;
    protected $table = 'handover_details';
    protected $fillable = [
        'handover_id','ter_id_count','ter_ids','department','doc_type','handover_remarks','is_received',
        'created_user_id','user_id','created_at','updated_at','reception_action'

    ];
    
}
