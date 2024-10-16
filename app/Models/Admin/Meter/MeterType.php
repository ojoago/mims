<?php

namespace App\Models\Admin\Meter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeterType extends Model
{
    use HasFactory;

    protected $fillable = ['type'];
}
