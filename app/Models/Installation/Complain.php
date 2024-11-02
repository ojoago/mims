<?php

namespace App\Models\Installation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    use HasFactory;
    protected $fillable = ['region_pid', 'meter_pid', 'complain' , 'status' , 'resolution', 'creator', 'old_meter_number','old_seal_number'];

    public function meter(){
        return $this->belongsTo(Installation::class, 'meter_pid' , 'pid');
    }

}
