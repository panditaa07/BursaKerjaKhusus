<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('no_hrd')->nullable(); // nomor HRD
            $table->string('alamat')->nullable(); // alamat perusahaan
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('tidak_aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokers');
    }
};
