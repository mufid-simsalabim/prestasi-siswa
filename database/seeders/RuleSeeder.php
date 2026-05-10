<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rule;

class RuleSeeder extends Seeder
{
    public function run(): void
    {
        $rules = [
            // Rule Amat Baik
            [
                'rule'    => 'IF nilai >= 85 AND kehadiran >= 90 AND keaktifan >= 85 AND sikap >= 85 THEN Amat Baik',
                'hasil'   => 'Amat Baik',
                'urutan'  => 1,
                'is_active' => true,
            ],
            // Rule Baik
            [
                'rule'    => 'IF nilai >= 75 AND kehadiran >= 80 AND keaktifan >= 75 AND sikap >= 75 THEN Baik',
                'hasil'   => 'Baik',
                'urutan'  => 2,
                'is_active' => true,
            ],
            // Rule Cukup
            [
                'rule'    => 'IF nilai >= 60 AND kehadiran >= 70 AND keaktifan >= 60 AND sikap >= 60 THEN Cukup',
                'hasil'   => 'Cukup',
                'urutan'  => 3,
                'is_active' => true,
            ],
            // Rule Kurang
            [
                'rule'    => 'IF nilai < 60 OR kehadiran < 70 OR keaktifan < 60 OR sikap < 60 THEN Kurang',
                'hasil'   => 'Kurang',
                'urutan'  => 4,
                'is_active' => true,
            ],
        ];

        foreach ($rules as $rule) {
            Rule::create($rule);
        }
    }
}