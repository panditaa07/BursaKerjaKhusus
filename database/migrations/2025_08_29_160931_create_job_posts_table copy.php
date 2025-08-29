<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industries_id')->constrained('industries')->cascadeOnDelete();

            // Detail lowongan
            $table->string('title');
            $table->text('description');
            $table->string('location')->nullable();
            $table->string('employment_type')->nullable(); // fulltime/parttime/intern
            $table->integer('vacancies')->nullable();
            $table->date('deadline')->nullable();

            // Status
            $table->enum('status', ['active', 'closed'])->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};