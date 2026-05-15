<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('raport', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')
                  ->constrained('students')
                  ->onDelete('cascade');
            $table->foreignId('mata_pelajaran_id')
                  ->constrained('mata_pelajaran')
                  ->onDelete('cascade');
            $table->foreignId('user_id')      // Guru yang input
                  ->constrained('users')
                  ->onDelete('cascade');
            $table->decimal('nilai_harian', 5, 2)->default(0);    // Nilai tugas/harian
            $table->decimal('nilai_uts', 5, 2)->default(0);       // Nilai UTS
            $table->decimal('nilai_uas', 5, 2)->default(0);       // Nilai UAS
            $table->decimal('nilai_akhir', 5, 2)->default(0);     // Rata-rata akhir
            $table->string('semester');       // Ganjil/Genap + tahun
            $table->text('catatan')->nullable();
            $table->timestamps();

            // Satu siswa, satu mapel, satu semester
            $table->unique(['student_id', 'mata_pelajaran_id', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('raport');
    }
};