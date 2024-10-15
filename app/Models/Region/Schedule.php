<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = [
        'account_number' ,  'account_name' , 'contact' , 'state' , 'region' , 'feeder_33' , 'feeder_11' , 'dt_name' , 'band' , 'load' ,
         'meter_type' , 'address' , 'connection_status',
        'region_pid'
    ];
}
