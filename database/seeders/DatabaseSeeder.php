<?php

namespace Database\Seeders;

use App\Models\Admin\Meter\MeterBrand;
use App\Models\Admin\Meter\MeterType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            RegionSeeder::class,
            MeterTypeSeeder::class,
            MeterBrandSeeder::class,
            ImportTableSeeder::class,
        ]);
    }
}
