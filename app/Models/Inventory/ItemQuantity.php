<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemQuantity extends Model
{
    use HasFactory;

    protected $fillable = [
        'region_pid',
        'item_pid',
        'quantity',
        'pid',
        'creator'
    ];

    public function item(){
        return $this->belongsTo(Item::class, 'item_pid','pid');
    }
    public function region(){
        return $this->belongsTo(Item::class, 'region_pid','pid');
    }
}
