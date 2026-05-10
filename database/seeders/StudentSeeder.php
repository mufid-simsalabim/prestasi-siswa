<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['nama' => 'Ahmad Fauzi',       'kelas' => 'X IPA 1', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Merdeka No. 1'],
            ['nama' => 'Dewi Putri',        'kelas' => 'X IPA 1', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Mawar No. 2'],
            ['nama' => 'Rizki Ramadan',     'kelas' => 'X IPA 2', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Melati No. 3'],
            ['nama' => 'Nur Hidayah',       'kelas' => 'X IPA 2', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Kenanga No. 4'],
            ['nama' => 'Eko Prasetyo',      'kelas' => 'X IPS 1', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Anggrek No. 5'],
            ['nama' => 'Fitri Handayani',   'kelas' => 'X IPS 1', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Dahlia No. 6'],
            ['nama' => 'Galang Pratama',    'kelas' => 'X IPS 2', 'jenis_kelamin' => 'L', 'alamat' => 'Jl. Tulip No. 7'],
            ['nama' => 'Hani Safitri',      'kelas' => 'X IPS 2', 'jenis_kelamin' => 'P', 'alamat' => 'Jl. Cempaka No. 8'],
            ['nama' => 'Irfan Maulana',     'kelas' => 'XI IPA 1','jenis_kelamin' => 'L', 'alamat' => 'Jl. Flamboyan No. 9'],
            ['nama' => 'Julia Anggraini',   'kelas' => 'XI IPA 1','jenis_kelamin' => 'P', 'alamat' => 'Jl. Seruni No. 10'],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }
    }
}