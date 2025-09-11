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
        Schema::create('job_posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('industry_id')->constrained('industries')->onDelete('cascade');
            $table->unsignedBigInteger('company_id');
            $table->string('title');
            $table->text('description');
            $table->string('location');
            $table->string('employment_type');
            $table->integer('vacancies');
            $table->date('deadline');
            $table->enum('status', ['active', 'inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_posts');
    }
};
