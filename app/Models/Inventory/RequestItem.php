<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    use HasFactory;
    protected $fillable = ['region_pid', 'item_pid', 'quantity_requested', 'quantity_supplied' , 'quantity_returned'];

}
