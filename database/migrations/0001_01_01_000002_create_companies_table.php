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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // nama perusahaan
            $table->string('email')->unique()->nullable(); // email perusahaan (opsional tapi unik)
            $table->string('address')->nullable();
            $table->string('website')->nullable();
            $table->text('description')->nullable();
            $table->string('logo')->nullable(); // simpan path/logo perusahaan
            $table->boolean('is_active')->default(true); // status perusahaan aktif/tidak
            $table->timestamps();
            $table->softDeletes(); // biar bisa dihapus sementara tanpa hilang data
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};