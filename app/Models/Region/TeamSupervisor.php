<?php

namespace App\Models\Region;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamSupervisor extends Model
{
    use HasFactory;
    protected $fillable = [
        'region_pid',
        'team_pid',
        'user_pid'
    ];

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_pid', 'pid');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_pid', 'pid');
    }
    public function region()
    {
        return $this->belongsTo(Region::class, 'region_pid', 'pid');
    }
}
