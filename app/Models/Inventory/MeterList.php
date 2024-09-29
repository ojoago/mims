<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterList extends Model
{
    use HasFactory;
    protected $fillable = [
        'region_pid' , 'pid' ,'meter_number' ,'status' ,'phase' ,'type' ,'user_pid'
    ];
}
