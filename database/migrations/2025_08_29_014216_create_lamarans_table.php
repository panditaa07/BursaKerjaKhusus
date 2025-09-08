<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
       // database/migrations/xxxx_xx_xx_create_lamarans_table.php
    Schema::create('lamarans', function (Blueprint $table) {
        $table->id();
        $table->string('nama_pelamar');
        $table->string('email');
        $table->string('no_hp');
        $table->string('lowongan');      // misalnya: Software Engineer
        $table->string('perusahaan');    // misalnya: PT Maju Jaya
        $table->string('cv')->nullable();
        $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Tidak Aktif');
        $table->timestamps();
    });
    }

    public function down(): void
    {
        Schema::dropIfExists('lamarans');
    }
};
