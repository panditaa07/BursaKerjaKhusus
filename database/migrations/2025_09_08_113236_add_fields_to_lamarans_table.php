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
        if (!Schema::hasColumn('lamarans', 'email')) {
            $table->string('email');
        }
        if (!Schema::hasColumn('lamarans', 'no_hp')) {
            $table->string('no_hp')->nullable();
        }
        if (!Schema::hasColumn('lamarans', 'perusahaan')) {
            $table->string('perusahaan')->nullable();
        }
    });
}

public function down(): void
{
    Schema::table('lamarans', function (Blueprint $table) {
        $table->dropColumn(['email', 'no_hp', 'perusahaan']);
    });
}
};
