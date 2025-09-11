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
        Schema::create('pelamar_bulan_inis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelamar');
            $table->string('email')->unique();
            $table->string('no_hp');
            $table->string('perusahaan')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelamar_bulan_inis');
    }
};
