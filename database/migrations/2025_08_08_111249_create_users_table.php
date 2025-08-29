<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Identitas user
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            // Role & relasi
            $table->string('role')->default('student')->index(); // admin, company, student, alumni, school
            $table->foreignId('company_id')
                  ->nullable()
                  ->constrained('companies')
                  ->onDelete('set null'); // bila user terkait company

            // Data tambahan untuk alumni
            $table->string('nisn')->nullable();
            $table->year('graduation_year')->nullable();
            $table->enum('status', ['bekerja', 'kuliah', 'wirausaha'])->nullable();

            // Laravel defaults
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};