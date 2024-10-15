<?php

namespace App\Models\Region;

use App\Models\Inventory\MeterList;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamAssignedMeter extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_pid' , 'date' ,'meter_pid' ,'creator' ,
    ];

    public function number(){
        return $this->belongsTo(MeterList::class, 'meter_pid', 'pid');
    }
}
