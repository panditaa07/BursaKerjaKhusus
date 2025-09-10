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
        Schema::create('lowongan_tidak_aktifs', function (Blueprint $table) {
            $table->id();
            $table->string('perusahaan');   // Nama perusahaan
            $table->string('no_hrd');       // Nomor HRD
            $table->string('alamat');       // Alamat perusahaan
            $table->enum('status', ['Aktif', 'Tidak Aktif'])->default('Tidak Aktif'); // Status loker
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan_tidak_aktifs');
    }
};
