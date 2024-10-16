<?php

namespace App\Models\Admin\Feeder;

use App\Models\State;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TradingZone extends Model
{
    use HasFactory;
    protected $fillable  = [ 'state_id' , 'zone','pid'];


    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    protected function zone(): Attribute
    {
        return Attribute::make(
            set:fn($val) => strtoupper($val)
        );
    }
}
