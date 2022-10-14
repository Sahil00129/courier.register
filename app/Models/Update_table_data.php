<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Update_table_data extends Model
{
    use HasFactory;
    protected $table = 'update_table_data_details';
    protected $fillable = [
        'user_id', 'user_name', 'updated_field', 'updated_id','created_at','updated_at'
    ];

    public function SaveUpdatedData()
    {
        return $this->hasOne('App\Models\Tercourier', 'id','updated_id');
    }
}
