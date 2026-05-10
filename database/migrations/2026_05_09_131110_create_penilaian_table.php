<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                  ->constrained('students')
                  ->onDelete('cascade');
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->decimal('nilai', 5, 2);
            $table->decimal('kehadiran', 5, 2);
            $table->decimal('keaktifan', 5, 2);
            $table->decimal('sikap', 5, 2);
            $table->enum('hasil_prestasi', ['Amat Baik', 'Baik', 'Cukup', 'Kurang'])->nullable();
            $table->decimal('skor', 8, 4)->nullable();
            $table->string('semester');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilaian');
    }
};