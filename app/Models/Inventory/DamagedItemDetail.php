<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamagedItemDetail extends Model
{
    use HasFactory;
    protected $fillable = ['region_pid', 'item_pid', 'date', 'cause' , 'creator'];

}
