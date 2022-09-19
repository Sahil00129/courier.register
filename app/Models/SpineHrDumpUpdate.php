<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpineHrDumpUpdate extends Model
{
    use HasFactory;
    protected $table = 'spine_updates_table';
    protected $fillable = [
        'user_id', 'user_name', 'updated_field', 'updated_id'
    ];

    public function SaveUpdatedData()
    {
        return $this->hasMany('App\Models\Sender', 'id','updated_id');
    }
}
