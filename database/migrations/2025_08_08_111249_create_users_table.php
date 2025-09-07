<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Identitas dasar
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Tambahan data kontak
            $table->string('phone')->nullable();
            $table->string('address')->nullable();

            // CV (opsional, biasanya untuk user/pelamar)
            $table->string('cv_path')->nullable();

            // Role (hanya admin, company, user)
            $table->enum('role', ['admin', 'company', 'user'])->default('user')->index();

            // Company ID (optional untuk user yang terkait perusahaan)
            $table->unsignedBigInteger('company_id')->nullable();

            // NIK/NISN (untuk user pelamar saja, fleksibel)
            $table->string('nik_nisn')->nullable()->unique();

            // Laravel defaults
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};