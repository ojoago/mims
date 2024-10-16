<?php

namespace App\Models\Admin\Feeder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feeder33 extends Model
{
    use HasFactory;

    protected  $fillable = [
        'zone_pid' ,'name','pid'
    ];

    public function zone(){
        return $this->belongsTo(TradingZone::class, 'zone_pid','pid');
    }
}
