<?php

namespace Database\Seeders;

use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin Manager',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123123123'),
                'occupation' => 'Specialist Manager',
                'role' => 'admin',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Rayhan',
                'email' => 'rayhan@gmail.com',
                'password' => Hash::make('123123123'),
                'occupation' => 'Assistant',
                'role' => 'user',
                'status' => 'active',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
        $this->call(CountrySeeder::class);
    }
}
