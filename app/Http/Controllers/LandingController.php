<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Penilaian;
use App\Models\User;

class LandingController extends Controller
{
    public function index()
    {
        // Statistik untuk landing page
        $totalSiswa = Student::count();
        $totalGuru  = User::where('role', 'guru')->count();
        $totalKelas = 18; // 6 tingkat x 3 kelas

        // Juara per kelas (top 3 per kelas)
        $juaraKelas = [];
        for ($tingkat = 1; $tingkat <= 6; $tingkat++) {
            foreach (['A', 'B', 'C'] as $huruf) {
                $kelas = $tingkat . '-' . $huruf;
                $juara = Penilaian::with('student')
                    ->whereHas('student', function ($q) use ($kelas) {
                        $q->where('kelas', $kelas);
                    })
                    ->whereNotNull('skor')
                    ->orderBy('skor', 'desc')
                    ->take(3)
                    ->get();

                if ($juara->count() > 0) {
                    $juaraKelas[$kelas] = $juara;
                }
            }
        }

        // Juara per angkatan (top 3 per tingkat)
        $juaraAngkatan = [];
        for ($tingkat = 1; $tingkat <= 6; $tingkat++) {
            $juara = Penilaian::with('student')
                ->whereHas('student', function ($q) use ($tingkat) {
                    $q->where('kelas', 'like', $tingkat . '-%');
                })
                ->whereNotNull('skor')
                ->orderBy('skor', 'desc')
                ->take(3)
                ->get();

            if ($juara->count() > 0) {
                $juaraAngkatan[$tingkat] = $juara;
            }
        }

        // Top 10 siswa terbaik overall
        $topSiswa = Penilaian::with('student')
            ->whereNotNull('skor')
            ->orderBy('skor', 'desc')
            ->take(10)
            ->get();

        return view('landing', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'juaraKelas',
            'juaraAngkatan',
            'topSiswa'
        ));
    }
}