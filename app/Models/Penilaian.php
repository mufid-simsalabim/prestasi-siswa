<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    protected $table = 'penilaian'; // ← tambahkan ini
    protected $fillable = [
        'student_id',
        'user_id',
        'nilai',
        'kehadiran',
        'keaktifan',
        'sikap',
        'hasil_prestasi',
        'skor',
        'semester',
    ];

    // Relasi ke siswa
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    // Relasi ke guru yang input
    public function guru()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}