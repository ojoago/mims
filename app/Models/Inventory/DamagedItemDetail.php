<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamagedItemDetail extends Model
{
    use HasFactory;
    protected $fillable = ['region_pid', 'item_pid', 'date', 'cause' , 'creator', 'quantity'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_pid', 'pid');
    }

    public function region()
    {
        return $this->belongsTo(Item::class, 'region_pid', 'pid');
    }

    public function date(): Attribute
    {
        return Attribute::make(
            get:fn($val) => formatDate($val)
        );
    }


}
