<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;
    protected $fillable = [
        'location_id', 'name', 'status', 'created_at', 'updated_at'
    ];

    public function Locations()
    {
        return $this->belongsTo('App\Models\Location','location_id');
    }
}
