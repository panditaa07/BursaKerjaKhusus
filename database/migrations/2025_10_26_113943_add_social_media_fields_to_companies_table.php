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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('linkedin')->nullable()->after('website')->comment('LinkedIn profile URL');
            $table->string('facebook')->nullable()->after('linkedin')->comment('Facebook profile URL');
            $table->string('twitter')->nullable()->after('facebook')->comment('Twitter profile URL');
            $table->string('tiktok')->nullable()->after('twitter')->comment('TikTok profile URL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['linkedin', 'facebook', 'twitter', 'tiktok']);
        });
    }
};
