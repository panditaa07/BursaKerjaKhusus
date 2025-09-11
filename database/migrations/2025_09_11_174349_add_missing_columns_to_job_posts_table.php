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
        Schema::table('job_posts', function (Blueprint $table) {
            $table->text('requirements')->nullable();
            $table->string('salary')->nullable();
            $table->string('company_logo')->nullable();
            $table->dropColumn('status');
            $table->enum('status', ['Submitted', 'Test 1', 'Test 2', 'Interview', 'Accepted', 'Rejected'])->default('Submitted');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_posts', function (Blueprint $table) {
            $table->dropColumn(['requirements', 'salary', 'company_logo']);
            $table->dropColumn('status');
            $table->enum('status', ['active', 'inactive'])->default('active');
        });
    }
};
