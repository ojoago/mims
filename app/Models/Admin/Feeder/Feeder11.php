<?php

namespace App\Models\Admin\Feeder;

use App\Models\Region\Region;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feeder11 extends Model
{
    use HasFactory;
    protected  $fillable = [
        'region_pid',
        'name',
        'pid',
        'feeder_33_pid'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_pid', 'pid');
    }

    public function feeder33()
    {
        return $this->belongsTo(Feeder33::class, 'feeder_33_pid', 'pid');
    }
}
