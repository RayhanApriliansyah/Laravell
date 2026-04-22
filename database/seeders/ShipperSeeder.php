<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shipper;

class ShipperSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'name' => 'PT Alfa Trans',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
                'phone' => '021-123456',
                'email' => 'info@alfatrans.co.id',
                'contact' => 'Budi Santoso'
            ],
            [
                'name' => 'PT Sumber Logistik',
                'address' => 'Jl. Mangga 2, Bandung',
                'phone' => '022-567890',
                'email' => 'cs@sumberlogistik.com',
                'contact' => 'Siti Rahma'
            ],
            [
                'name' => 'CV Mitra Cargo',
                'address' => 'Jl. Kenanga 5, Surabaya',
                'phone' => '031-334455',
                'email' => 'admin@mitracargo.id',
                'contact' => 'Andi Wijaya'
            ],
        ];

        foreach ($data as $item) {
            Shipper::create($item);
        }
    }
}
