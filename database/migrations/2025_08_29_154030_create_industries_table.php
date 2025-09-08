<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('industries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()
            ->constrained('users')->cascadeOnDelete(); // satu profil per akun industry


            $table->string('company_name');
            $table->string('company_number', 30)->unique(); // nomor perusahaan/NPWP/NIB, validasi format di FormRequest
            $table->string('address', 255)->nullable();
            $table->string('industry_field', 100)->nullable();
            $table->string('website')->nullable();
            $table->text('short_description')->nullable();
            $table->string('logo_path')->nullable();


            // Kontak HRD (hanya terlihat admin di UI, tetap disimpan di sini)
            $table->string('hrd_contact_name', 100)->nullable();
            $table->string('hrd_contact_email')->nullable();
            $table->string('hrd_contact_phone', 50)->nullable();


            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('industries');
    }
};