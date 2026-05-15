<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;

class MataPelajaranSeeder extends Seeder
{
    public function run(): void
    {
        $mapel = [
            ['nama' => 'Pendidikan Agama Islam',      'kode' => 'PAI',  'kkm' => 75],
            ['nama' => 'Pendidikan Pancasila',         'kode' => 'PP',   'kkm' => 70],
            ['nama' => 'Bahasa Indonesia',             'kode' => 'BIND', 'kkm' => 70],
            ['nama' => 'Matematika',                   'kode' => 'MTK',  'kkm' => 70],
            ['nama' => 'Ilmu Pengetahuan Alam',        'kode' => 'IPA',  'kkm' => 70],
            ['nama' => 'Ilmu Pengetahuan Sosial',      'kode' => 'IPS',  'kkm' => 70],
            ['nama' => 'Seni Budaya dan Prakarya',     'kode' => 'SBDP', 'kkm' => 75],
            ['nama' => 'Pendidikan Jasmani',           'kode' => 'PJOK', 'kkm' => 75],
            ['nama' => 'Bahasa Arab',                  'kode' => 'BARB', 'kkm' => 70],
            ['nama' => 'Bahasa Inggris',               'kode' => 'BING', 'kkm' => 70],
        ];

        foreach ($mapel as $m) {
            MataPelajaran::create($m);
        }
    }
}