<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_pid', 'firstname', 'staff_id' , 'lastname' , 'othername' , 'marital_status' , 'gender', 'religion' , 'pob' , 'dob' , 'state_of_origin' ,
        'lga_of_origin' , 'state_of_residence' , 'lga_of_residence' , 'address' , 'creator'
        ];

    















}
