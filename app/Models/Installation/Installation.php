<?php

namespace App\Models\Installation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    use HasFactory;
    protected $fillable = [
        'region_pid', 'pid', 'meter_number', 'preload', 'state' , 'doi', 'dt_name',
        'dt_type',
        'upriser' ,
        'pole' ,
        'tariff' ,
        'advtariff' ,
        'title' ,
        'fullname' ,
        'gsm' ,
        'email' ,
        'premises' ,
        'phase',
        'address',
        'remark',
        'feeder_33kv',
        'feeder_11kv',
        'meter_type',
        'meter_brand',
        'meter_tech' ,
        'estimated' ,
        'account_no' ,
        'business_unit',
        'x_cordinate',
        'y_cordinate' ,
        'installer' ,
        'supervisor' ,
        'rf_channel' ,
        'din' ,
        'seal' ,
        'dt_code'
    ];

    

























}
