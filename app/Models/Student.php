<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'nama',
        'nisn',
        'kelas',
        'angkatan',
        'jenis_kelamin',
        'alamat',
    ];

    // Relasi ke penilaian
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    // Relasi ke raport
    public function raport()
    {
        return $this->hasMany(Raport::class);
    }

    // Ambil penilaian terbaru
    public function penilaianTerbaru()
    {
        return $this->hasOne(Penilaian::class)->latest();
    }

    // Ambil tingkat kelas (angka depan dari kelas)
    public function getTingkatAttribute()
    {
        return explode('-', $this->kelas)[0] ?? null;
    }
}