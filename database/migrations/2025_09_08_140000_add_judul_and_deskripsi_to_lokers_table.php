<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lokers', function (Blueprint $table) {
            $table->string('judul')->after('company_id');
            $table->text('deskripsi')->after('judul');
        });
    }

    public function down(): void
    {
        Schema::table('lokers', function (Blueprint $table) {
            $table->dropColumn(['judul', 'deskripsi']);
        });
    }
};
