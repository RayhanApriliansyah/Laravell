<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    public function run()
    {
        // ambil semua file gambar dari storage/app/public/flags
        $files = Storage::files('public/flags');

        $countries = [
            'AF' => ['Afghanistan', 'Afghani', 'AFN', '؋'],
            'AL' => ['Albania', 'Lek', 'ALL', 'L'],
            'DZ' => ['Algeria', 'Algerian Dinar', 'DZD', 'د.ج'],
            'AD' => ['Andorra', 'Euro', 'EUR', '€'],
            'AO' => ['Angola', 'Kwanza', 'AOA', 'Kz'],
            'AR' => ['Argentina', 'Argentine Peso', 'ARS', '$'],
            'ID' => ['Indonesia', 'Rupiah', 'IDR', 'Rp'],
            'MY' => ['Malaysia', 'Ringgit', 'MYR', 'RM'],
            'US' => ['United States', 'United States Dollar', 'USD', '$'],
            'GB' => ['United Kingdom', 'Pound Sterling', 'GBP', '£'],
            // tambahkan negara lain sesuai kebutuhan...
        ];

        $now = now();

        foreach ($countries as $code => $data) {
            $flagPath = "flags/" . strtolower($code) . ".png";

            DB::table('countries')->insert([
                'flag' => $flagPath,
                'country_name' => $data[0],
                'country_code' => $code,
                'currency_name' => $data[1],
                'currency_code' => $data[2],
                'currency_symbol' => $data[3],
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
