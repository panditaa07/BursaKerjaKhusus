<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_post_id')->constrained('job_posts')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();


            $table->string('cv_path')->nullable(); // CV opsional saat apply
            $table->text('cover_letter')->nullable();


            // Status proses rekrutmen
            $table->enum('status', ['submitted','reviewed','accepted','rejected'])
                ->default('submitted')->index();


            $table->timestamp('applied_at')->useCurrent();
            $table->timestamp('status_changed_at')->nullable();


            $table->timestamps();
            $table->softDeletes();


            // Satu user hanya 1 lamaran per job_post
            $table->unique(['job_post_id','user_id']);
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
