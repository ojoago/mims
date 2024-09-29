<?php

namespace Database\Seeders;

use App\Models\Region\Region;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        
        Region::create(['state'  => 'Bauchi', 'region' => 'Bauchi', 'pid' => public_id()]);
        Region::create(['state'  => 'Bauchi', 'region' => 'Azare', 'pid' => public_id()]);
        Region::create(['state'  => 'Benue', 'region' => 'Benue', 'pid' => public_id()]);
        Region::create(['state'  => 'Gombe', 'region' => 'Gombe', 'pid' => public_id()]);
        Region::create(['state'  => 'Plateau', 'region' => 'Jos', 'pid' => public_id()]);
        
    }
}
