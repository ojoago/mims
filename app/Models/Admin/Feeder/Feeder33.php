<?php

namespace App\Models\Admin\Feeder;

use App\Models\Region\Region;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeder33 extends Model
{
    use HasFactory;

    protected  $fillable = [
        'region_pid' ,'name','pid'
    ];

    public function region(){
        return $this->belongsTo(Region::class,'region_pid','pid');
    }
}
