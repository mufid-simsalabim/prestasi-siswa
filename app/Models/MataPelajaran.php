<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $table = 'mata_pelajaran';

    protected $fillable = [
        'nama',
        'kode',
        'kkm',
        'is_active',
    ];

    // Relasi ke raport
    public function raport()
    {
        return $this->hasMany(Raport::class);
    }
}