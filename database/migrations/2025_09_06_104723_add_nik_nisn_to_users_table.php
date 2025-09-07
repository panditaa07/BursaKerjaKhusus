<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambah kolom NIK & NISN kalau belum ada
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik', 20)->nullable()->unique()->after('company_id');
            }

            if (!Schema::hasColumn('users', 'nisn')) {
                $table->string('nisn', 20)->nullable()->unique()->after('nik');
            } else {
                // kalau sudah ada nisn tapi belum unique
                $table->string('nisn', 20)->nullable()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nik')) {
                $table->dropColumn('nik');
            }
            if (Schema::hasColumn('users', 'nisn')) {
                $table->dropColumn('nisn');
            }
        });
    }
};