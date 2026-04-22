<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Kolom id auto increment
            $table->string('name'); // Nama user
            $table->string('email')->unique(); // Email user (unik)
            $table->string('password');
            $table->string('occupation')->nullable(); // Bisa kosong
            $table->string('role')->nullable(); // Bisa kosong
            $table->enum('status', ['active', 'inactive'])->default('active'); // Bisa kosong
            $table->timestamp('created_at')->nullable(); // Bisa kosong
            $table->timestamp('updated_at')->nullable(); // Bisa kosong
        });
    }

    /**
     * Balik migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
