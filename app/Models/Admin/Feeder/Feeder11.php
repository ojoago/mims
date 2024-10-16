<?php

namespace App\Models\Admin\Feeder;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feeder11 extends Model
{
    use HasFactory;
    protected  $fillable = [
        'state_id',
        'zone_pid',
        'name',
        'pid',
        'feeder_33_pid'
    ];

    public function zone()
    {
        return $this->belongsTo(TradingZone::class, 'zone_pid', 'pid');
    }

    public function feeder()
    {
        return $this->belongsTo(Feeder33::class, 'feeder_33_pid', 'pid');
    }
}
