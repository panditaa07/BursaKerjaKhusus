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

            // CV
            $table->string('cv_path')->nullable();

            // Role
            $table->string('role')->default('student')->index(); // admin, company, student, alumni, school

            // Jika nanti ada tabel companies, bisa ditambahkan ulang foreign key-nya
            $table->unsignedBigInteger('company_id')->nullable();

            // Data tambahan untuk alumni
            $table->string('nisn')->nullable();
            $table->year('graduation_year')->nullable();
            $table->enum('status', ['bekerja', 'kuliah', 'wirausaha'])->nullable();

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