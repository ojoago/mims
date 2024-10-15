<?php

namespace App\Models\Region;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;
    protected $fillable = [
        'region_pid' ,'team', 'pid', 'supervisor'
    ];

    public function team() : Attribute
    {
        return Attribute::make(
            set:fn ($val) => strtoupper($val),
        );
    }

    public function supervisor(){
        return $this->belongsTo(User::class, 'supervisor','pid');
    }
    public function member(){
        return $this->hasMany(User::class, 'user_pid','pid');
    }
}
