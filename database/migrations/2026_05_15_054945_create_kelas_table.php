<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');           // Contoh: 1-A, 2-B
            $table->integer('tingkat');       // 1 sampai 6
            $table->string('huruf');          // A, B, C
            $table->foreignId('wali_kelas_id')
                  ->nullable()
                  ->constrained('users')
                  ->onDelete('set null');
            $table->integer('tahun_ajaran'); // Contoh: 2024
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};