<?php

namespace App\Models\Region;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionStaff extends Model
{
    use HasFactory;
    protected $fillable = ['region_pid', 'pid' , 'user_pid'];
    


}
