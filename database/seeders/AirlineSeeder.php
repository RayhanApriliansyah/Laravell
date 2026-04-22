<?php

namespace Database\Seeders;

use App\Models\Airline;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AirlineSeeder extends Seeder
{
    public function run(): void
    {
        $afghanistan = Country::where('country_name', 'Afghanistan')->first();

        Airline::create([
            'logo' => 'logos/afg_airlines.png',
            'code' => 'AFG',
            'name' => 'Afghan Airlines',
            'country_id' => $afghanistan->id ?? 1,
            'type' => 'International',
        ]);
    }
}
