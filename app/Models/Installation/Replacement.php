<?php

namespace App\Models\Installation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Replacement extends Model
{
    use HasFactory;
    protected $fillable = ['region_pid', 'meter_pid', 'old_meter_number', 'old_seal', 'old_installer', 'date', 'creator'];





}
