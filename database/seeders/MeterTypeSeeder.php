<?php

namespace Database\Seeders;

use App\Models\Admin\Meter\MeterType;
use Illuminate\Database\Seeder;

class MeterTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        MeterType::create(['type' => 'Single Phase']);
        MeterType::create(['type' => 'Three Phase']);
    }
}
