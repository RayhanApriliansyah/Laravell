<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Vessel;
use App\Models\Country;

class VesselSeeder extends Seeder
{
    public function run(): void
    {



        Vessel::insert([
            [
                'logo'       => 'vessels/logo1.png',
                'name'       => 'MV Ocean Explorer',
                'imo'        => 'IMO1234567',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'logo'       => 'vessels/logo2.png',
                'name'       => 'MV Sea Voyager',
                'imo'        => 'IMO7654321',

                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'logo'       => 'vessels/logo3.png',
                'name'       => 'MV Blue Horizon',
                'imo'        => 'IMO1112223',

                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
