<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class RenameFlagsCommand extends Command
{
    protected $signature = 'flags:rename';
    protected $description = 'Rename flag images to match country codes or names';

    public function handle()
    {
        $csvPath = base_path('countries.csv');
        $flagsPath = storage_path('app/public/flags_temp/');
        $newPath = storage_path('app/public/flags/');

        if (!File::exists($csvPath)) {
            $this->error("File countries.csv tidak ditemukan!");
            return;
        }

        if (!File::exists($newPath)) {
            File::makeDirectory($newPath, 0755, true);
        }

        $countries = array_map('str_getcsv', file($csvPath));
        array_shift($countries); // hapus header CSV

        $flagFiles = File::files($flagsPath);
        $i = 0;

        foreach ($countries as $country) {
            [$name, $code] = $country;
            if (!isset($flagFiles[$i])) break;

            $ext = $flagFiles[$i]->getExtension();
            $newName = strtolower(str_replace(' ', '_', $name)) . '.' . $ext;
            File::copy($flagFiles[$i]->getPathname(), $newPath . $newName);

            $this->info("✅ {$flagFiles[$i]->getFilename()} → {$newName}");
            $i++;
        }

        $this->info("Selesai! Semua file sudah di-rename ke folder flags/");
    }
}
