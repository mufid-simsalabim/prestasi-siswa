<?php

namespace App\Services;

use App\Models\Penilaian;

class C45Service
{
    /**
     * Klasifikasi prestasi siswa menggunakan rule C4.5
     * Input  : nilai, kehadiran, keaktifan, sikap (0-100)
     * Output : ['hasil' => 'Amat Baik/Baik/Cukup/Kurang', 'skor' => float, 'rule' => string]
     */
    public function klasifikasi($nilai, $kehadiran, $keaktifan, $sikap): array
    {
        // Hitung skor gabungan dengan bobot
        $skor = ($nilai * 0.4) + ($kehadiran * 0.2) + ($keaktifan * 0.2) + ($sikap * 0.2);

        // Tentukan hasil berdasarkan decision tree C4.5
        if ($nilai >= 85 && $kehadiran >= 90 && $keaktifan >= 85 && $sikap >= 85) {
            $hasil = 'Amat Baik';
            $rule  = 'IF nilai >= 85 AND kehadiran >= 90 AND keaktifan >= 85 AND sikap >= 85 THEN Amat Baik';
        } elseif ($nilai >= 75 && $kehadiran >= 80 && $keaktifan >= 75 && $sikap >= 75) {
            $hasil = 'Baik';
            $rule  = 'IF nilai >= 75 AND kehadiran >= 80 AND keaktifan >= 75 AND sikap >= 75 THEN Baik';
        } elseif ($nilai >= 60 && $kehadiran >= 70 && $keaktifan >= 60 && $sikap >= 60) {
            $hasil = 'Cukup';
            $rule  = 'IF nilai >= 60 AND kehadiran >= 70 AND keaktifan >= 60 AND sikap >= 60 THEN Cukup';
        } else {
            $hasil = 'Kurang';
            $rule  = 'IF nilai < 60 OR kehadiran < 70 OR keaktifan < 60 OR sikap < 60 THEN Kurang';
        }

        return [
            'hasil' => $hasil,
            'skor'  => round($skor, 4),
            'rule'  => $rule,
        ];
    }

    /**
     * Proses C4.5 lengkap: hitung entropy, information gain, dan decision tree
     */
    public function prosesC45($dataPenilaian): array
    {
        $data = $dataPenilaian->toArray();
        $n    = count($data);

        if ($n === 0) {
            return ['error' => 'Tidak ada data'];
        }

        // Hitung entropy total
        $entropyTotal = $this->hitungEntropy($data, 'hasil_prestasi');

        // Hitung information gain tiap atribut
        $atribut = ['nilai', 'kehadiran', 'keaktifan', 'sikap'];
        $gains   = [];

        foreach ($atribut as $attr) {
            $gains[$attr] = $this->hitungInformationGain($data, $attr, 'hasil_prestasi', $entropyTotal);
        }

        // Atribut dengan gain tertinggi = root node
        arsort($gains);
        $rootAtribut = array_key_first($gains);

        // Hitung distribusi kelas
        $distribusi = $this->hitungDistribusi($data, 'hasil_prestasi');

        return [
            'total_data'    => $n,
            'entropy_total' => round($entropyTotal, 6),
            'gains'         => array_map(fn($g) => round($g, 6), $gains),
            'root_atribut'  => $rootAtribut,
            'distribusi'    => $distribusi,
            'rules'         => $this->getRules(),
        ];
    }

    /**
     * Hitung Entropy dari dataset
     * Rumus: E = -Σ (p * log2(p))
     */
    public function hitungEntropy(array $data, string $labelKolom): float
    {
        $n           = count($data);
        $distribusi  = $this->hitungDistribusi($data, $labelKolom);
        $entropy     = 0;

        foreach ($distribusi as $jumlah) {
            if ($jumlah > 0) {
                $p       = $jumlah / $n;
                $entropy -= $p * log($p, 2);
            }
        }

        return $entropy;
    }

    /**
     * Hitung Information Gain untuk satu atribut
     * Rumus: Gain(S,A) = Entropy(S) - Σ (|Sv|/|S|) * Entropy(Sv)
     */
    public function hitungInformationGain(array $data, string $atribut, string $labelKolom, float $entropyTotal): float
    {
        $n      = count($data);
        $nilai  = array_unique(array_column($data, $atribut));

        // Kategorikan nilai numerik ke dalam range
        $kategori = $this->kategorikanNilai($data, $atribut);

        $entropyAtribut = 0;

        foreach ($kategori as $kat => $subset) {
            $nSubset         = count($subset);
            $entropySubset   = $this->hitungEntropy($subset, $labelKolom);
            $entropyAtribut += ($nSubset / $n) * $entropySubset;
        }

        return $entropyTotal - $entropyAtribut;
    }

    /**
     * Kategorikan nilai numerik ke dalam 3 range:
     * Rendah (< 60), Sedang (60-79), Tinggi (>= 80)
     */
    private function kategorikanNilai(array $data, string $atribut): array
    {
        $kategori = ['Rendah' => [], 'Sedang' => [], 'Tinggi' => []];

        foreach ($data as $row) {
            $val = $row[$atribut];
            if ($val < 60) {
                $kategori['Rendah'][] = $row;
            } elseif ($val < 80) {
                $kategori['Sedang'][] = $row;
            } else {
                $kategori['Tinggi'][] = $row;
            }
        }

        // Hapus kategori yang kosong
        return array_filter($kategori, fn($k) => count($k) > 0);
    }

    /**
     * Hitung distribusi kelas dalam dataset
     */
    private function hitungDistribusi(array $data, string $labelKolom): array
    {
        $distribusi = [
            'Amat Baik' => 0,
            'Baik'      => 0,
            'Cukup'     => 0,
            'Kurang'    => 0,
        ];

        foreach ($data as $row) {
            if (isset($row[$labelKolom]) && isset($distribusi[$row[$labelKolom]])) {
                $distribusi[$row[$labelKolom]]++;
            }
        }

        return $distribusi;
    }

    /**
     * Ambil semua rule yang aktif
     */
    private function getRules(): array
    {
        return \App\Models\Rule::where('is_active', true)
            ->orderBy('urutan')
            ->get()
            ->toArray();
    }
}