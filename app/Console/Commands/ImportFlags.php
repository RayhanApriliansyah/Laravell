<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Flag;
use Illuminate\Support\Facades\File;

class ImportFlags extends Command
{
    protected $signature = 'flags:import {path}';
    protected $description = 'Import all PNG flags from a folder into the database and copy them to public/flags';

    public function handle()
    {
        $sourceFolder = $this->argument('path');
        $destinationFolder = public_path('flags');

        if (!File::exists($sourceFolder)) {
            $this->error("❌ Folder sumber tidak ditemukan: {$sourceFolder}");
            return;
        }

        // Buat folder tujuan kalau belum ada
        if (!File::exists($destinationFolder)) {
            File::makeDirectory($destinationFolder, 0755, true);
            $this->info("📁 Folder public/flags dibuat otomatis.");
        }

        $files = File::files($sourceFolder);
        $count = 0;

        foreach ($files as $file) {
            if (strtolower($file->getExtension()) === 'png') {
                // Salin ke public/flags
                $destinationPath = $destinationFolder . '/' . $file->getFilename();
                File::copy($file->getRealPath(), $destinationPath);

                // Simpan path relatif agar bisa dipanggil dengan asset()
                $relativePath = 'flags/' . $file->getFilename();

                // Masukkan ke database
                Flag::updateOrCreate(
                    ['filename' => $file->getFilename()],
                    [
                        'filepath' => $relativePath,
                        'filesize_kb' => round($file->getSize() / 1024, 2)
                    ]
                );

                $count++;
            }
        }

        $this->info("✅ Berhasil memasukkan {$count} file PNG ke database dan menyalinnya ke public/flags.");
    }
}
