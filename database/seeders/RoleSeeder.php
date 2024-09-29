<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::create(['name' => 'super admin']);
        Role::create(['name' => 'management']);
        Role::create(['name' => 'region admin']);
        Role::create(['name' => 'supervisor']);
        Role::create(['name' => 'data entry']);
        Role::create(['name' => 'staff']);
        Role::create(['name' => 'installer']);
        Role::create(['name' => 'store']);
    }
}
