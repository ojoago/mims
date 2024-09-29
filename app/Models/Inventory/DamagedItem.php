<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DamagedItem extends Model
{
    use HasFactory;
    protected $fillable = ['region_pid', 'pid', 'item_pid', 'quantity'];

}
