<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;
    protected $fillable = ['region_pid', 'pid', 'date' , 'note' , 'status' , 'region_pid' , 'receiver' , 'requested_by'];

}
