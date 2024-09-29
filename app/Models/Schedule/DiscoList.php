<?php

namespace App\Models\Schedule;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscoList extends Model
{
    use HasFactory;
    protected $fillable =[
        'region_pid' ,'pid' , 'account_number' , 'customer_names' , 'phase' , 'gsm' , 'email' , 
        'address' ,  'disco_code' , 'installation_status'
    ];
}
