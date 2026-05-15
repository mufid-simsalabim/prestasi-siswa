<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $tahun = date('Y');

        for ($tingkat = 1; $tingkat <= 6; $tingkat++) {
            foreach (['A', 'B', 'C'] as $huruf) {
                Kelas::create([
                    'nama'         => $tingkat . '-' . $huruf,
                    'tingkat'      => $tingkat,
                    'huruf'        => $huruf,
                    'tahun_ajaran' => $tahun,
                    'is_active'    => true,
                ]);
            }
        }
    }
}