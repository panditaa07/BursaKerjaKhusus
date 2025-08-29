<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('alumni_tracing', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumni_id')->constrained('users')->cascadeOnDelete();


            $table->year('graduation_year')->nullable();
            $table->enum('current_status', ['study','work','entrepreneur','unemployed'])->index();
            $table->string('institution_or_company')->nullable();
            $table->string('position')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(true);
            $table->text('notes')->nullable();


            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('alumni_tracing');
    }
};