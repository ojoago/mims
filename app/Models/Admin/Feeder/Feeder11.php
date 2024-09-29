<?php

namespace App\Models\Admin\Feeder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeder11 extends Model
{
    use HasFactory;
    protected  $fillable = [
        'region_pid',
        'name',
        'pid',
        'feeder_33_pid'
    ];
}
