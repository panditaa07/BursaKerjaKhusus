<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lamarans', function (Blueprint $table) {
            // Add new columns without dropping old ones for compatibility
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('lowongan_id')->nullable()->constrained('lowongans')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('lamarans', function (Blueprint $table) {
            // Drop new columns
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropForeign(['lowongan_id']);
            $table->dropColumn('lowongan_id');
        });
    }
};
