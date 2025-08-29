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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade')
                ->index(); // biar query lebih cepat

            $table->string('title');
            $table->text('message');

            // kalau nanti jenis notifikasi dibatasi
            $table->enum('type', ['job_update', 'application_status', 'general'])
                ->nullable();

            $table->boolean('is_read')->default(false);
            $table->timestamps();
            $table->softDeletes(); // biar bisa hapus tanpa benar-benar hilang
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};