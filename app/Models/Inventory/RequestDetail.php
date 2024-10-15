<?php

namespace App\Models\Inventory;

use App\Models\Region\Team;
use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestDetail extends Model
{
    use HasFactory;
    protected $fillable = ['region_pid', 'pid', 'date' , 'note' , 'status' , 'region_pid' , 'receiver' , 'requested_by', 'team_pid'];

    protected $appends  = ['date_requested','request_status'] ;
    private $status = ['Pending', 'Treated','Comfirmed'];

    public function items()
    {
        return $this->hasMany(RequestItem::class, 'request_pid', 'pid');
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'team_pid', 'pid');
    }

    public function initiator()
    {
        return $this->belongsTo(UserDetail::class, 'requested_by', 'user_pid');
    }

    public function collector()
    {
        return $this->belongsTo(UserDetail::class, 'receiver', 'user_pid');
    }

    protected function dateRequested(): Attribute
    {
        return Attribute::make(
            get:fn()  => isset($this->attributes['date']) ? formatDate($this->attributes['date']) : null 
        );
    }
    protected function requestStatus(): Attribute
    {
        return Attribute::make(
            get:fn()  => isset($this->attributes['status']) ? $this->status[$this->attributes['status']] : null 
        );
    }

    

}
