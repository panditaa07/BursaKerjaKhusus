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
        Schema::table('users', function (Blueprint $table) {
            $table->string('portfolio_link')->nullable()->after('short_profile')->comment('Portfolio website URL');
            $table->string('facebook')->nullable()->after('portfolio_link')->comment('Facebook profile URL');
            $table->string('instagram')->nullable()->after('facebook')->comment('Instagram profile URL');
            $table->string('linkedin')->nullable()->after('instagram')->comment('LinkedIn profile URL');
            $table->string('twitter')->nullable()->after('linkedin')->comment('Twitter profile URL');
            $table->string('tiktok')->nullable()->after('twitter')->comment('TikTok profile URL');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['portfolio_link', 'facebook', 'instagram', 'linkedin', 'twitter', 'tiktok']);
        });
    }
};
