<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'kelas',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi: satu guru bisa input banyak penilaian
    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'user_id');
    }

    // Cek apakah user adalah admin
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    // Cek apakah user adalah guru
    public function isGuru()
    {
        return $this->role === 'guru';
    }

    // Ambil label wali kelas
    public function labelWaliKelas()
    {
        if ($this->role === 'admin') {
            return 'Administrator';
        }
        return $this->kelas ? 'Wali Kelas ' . $this->kelas : 'Guru';
    }
}