<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Consignee;

class ConsigneeSeeder extends Seeder
{
    public function run()
    {
        Consignee::insert([
            [
                'name' => 'PT Maju Bersama',
                'npwp' => '01.234.567.8-901.000',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'CV Sukses Selalu',
                'npwp' => '02.987.654.3-210.000',
                'address' => 'Jl. Mawar No. 5, Bandung',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'PT Berkah Logistik',
                'npwp' => '03.111.222.3-456.000',
                'address' => 'Jl. Kenanga No. 22, Surabaya',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
