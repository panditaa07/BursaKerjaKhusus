<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Hapus tabel/kolom lama yang tidak dipakai
        $tables = [
            'prestasi', 'berita', 'sambutan', 'events', 'galleries', 'testimonials',
            // tambahkan tabel legacy lain di sini jika ada
        ];
        foreach ($tables as $t) {
            Schema::dropIfExists($t);
        }
    }
    public function down(): void
    {
        //
    }
};
