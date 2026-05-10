<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'nama',
        'kelas',
        'jenis_kelamin',
        'alamat',
    ];

    // Relasi: satu siswa bisa punya banyak penilaian
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class);
    }

    // Ambil penilaian terbaru siswa
    public function penilaianTerbaru()
    {
        return $this->hasOne(Penilaian::class)->latest();
    }
}