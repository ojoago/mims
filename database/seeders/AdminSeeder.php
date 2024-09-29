<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'pid' => public_id(),
            'type' => 764,
            'email' => 'dhasmom01@gmail.com',
            'password' => '1234',])->assignRole('super admin');
    }
}
