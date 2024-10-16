<?php

namespace Database\Seeders;

use App\Models\Admin\Meter\MeterBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeterBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MeterBrand::create(['brand' => 'Technovati']);
        MeterBrand::create(['brand' => 'YTL']);
    }
}
