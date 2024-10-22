<?php

namespace App\Models\Region;

use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    use HasFactory;
    protected $fillable = [
        'region_pid' , 'team_pid' , 'user_pid'
    ];

    public function team(){
        return $this->belongsTo(Team::class,'team_pid','pid');
    }
    public function user(){
        return $this->belongsTo(UserDetail::class,'user_pid', 'user_pid');
    }
    public function region(){
        return $this->belongsTo(Region::class, 'region_pid','pid');
    }

}
