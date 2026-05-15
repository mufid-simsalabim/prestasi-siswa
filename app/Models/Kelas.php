<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama',
        'tingkat',
        'huruf',
        'wali_kelas_id',
        'tahun_ajaran',
        'is_active',
    ];

    // Relasi ke wali kelas (user)
    public function waliKelas()
    {
        return $this->belongsTo(User::class, 'wali_kelas_id');
    }

    // Relasi ke siswa
    public function siswa()
    {
        return $this->hasMany(Student::class, 'kelas', 'nama');
    }
}