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
            $table->text('short_profile')->nullable()->after('birth_date')->comment('User short profile');
            $table->string('social_media_link')->nullable()->after('short_profile')->comment('User social media link');
            $table->string('profile_photo_path')->nullable()->after('social_media_link')->comment('User profile photo path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['short_profile', 'social_media_link', 'profile_photo_path']);
        });
    }
};
