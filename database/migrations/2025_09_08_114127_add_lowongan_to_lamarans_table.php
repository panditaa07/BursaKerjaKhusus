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
        Schema::table('lamarans', function (Blueprint $table) {
            if (!Schema::hasColumn('lamarans', 'lowongan')) {
                $table->string('lowongan')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('lamarans', function (Blueprint $table) {
            $table->dropColumn('lowongan');
        });
    }
};
