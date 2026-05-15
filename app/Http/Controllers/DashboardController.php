<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Penilaian;
use App\Models\User;
use App\Models\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            // Dashboard Admin
            $totalSiswa     = Student::count();
            $totalPenilaian = Penilaian::count();
            $totalGuru      = User::where('role', 'guru')->count();
            $totalRules     = Rule::count();

            // Grafik prestasi semua kelas
            $grafikPrestasi = Penilaian::selectRaw('hasil_prestasi, COUNT(*) as total')
                ->whereNotNull('hasil_prestasi')
                ->groupBy('hasil_prestasi')
                ->pluck('total', 'hasil_prestasi')
                ->toArray();

            // Grafik siswa per kelas
            $grafikKelas = Student::selectRaw('kelas, COUNT(*) as total')
                ->groupBy('kelas')
                ->orderBy('kelas')
                ->pluck('total', 'kelas')
                ->toArray();

            // Ranking top 5
            $rankingSiswa = Penilaian::with('student')
                ->whereNotNull('skor')
                ->orderBy('skor', 'desc')
                ->take(5)
                ->get();

            // Penilaian terbaru
            $penilaianTerbaru = Penilaian::with('student', 'guru')
                ->latest()
                ->take(5)
                ->get();

        } else {
            // Dashboard Guru - filter berdasarkan kelas yang dipegang
            $kelasGuru = $user->kelas;

            $totalSiswa     = Student::where('kelas', $kelasGuru)->count();
            $totalPenilaian = Penilaian::whereHas('student', function ($q) use ($kelasGuru) {
                $q->where('kelas', $kelasGuru);
            })->count();
            $totalGuru      = 1; // dirinya sendiri
            $totalRules     = Rule::count();

            // Grafik prestasi kelas guru
            $grafikPrestasi = Penilaian::selectRaw('hasil_prestasi, COUNT(*) as total')
                ->whereNotNull('hasil_prestasi')
                ->whereHas('student', function ($q) use ($kelasGuru) {
                    $q->where('kelas', $kelasGuru);
                })
                ->groupBy('hasil_prestasi')
                ->pluck('total', 'hasil_prestasi')
                ->toArray();

            // Grafik siswa kelas guru (hanya 1 kelas)
            $grafikKelas = Student::selectRaw('kelas, COUNT(*) as total')
                ->where('kelas', $kelasGuru)
                ->groupBy('kelas')
                ->pluck('total', 'kelas')
                ->toArray();

            // Ranking top 5 kelas guru
            $rankingSiswa = Penilaian::with('student')
                ->whereNotNull('skor')
                ->whereHas('student', function ($q) use ($kelasGuru) {
                    $q->where('kelas', $kelasGuru);
                })
                ->orderBy('skor', 'desc')
                ->take(5)
                ->get();

            // Penilaian terbaru kelas guru
            $penilaianTerbaru = Penilaian::with('student', 'guru')
                ->whereHas('student', function ($q) use ($kelasGuru) {
                    $q->where('kelas', $kelasGuru);
                })
                ->latest()
                ->take(5)
                ->get();
        }

        return view('dashboard', compact(
            'totalSiswa',
            'totalPenilaian',
            'totalGuru',
            'totalRules',
            'grafikPrestasi',
            'grafikKelas',
            'rankingSiswa',
            'penilaianTerbaru',
            'user'
        ));
    }
}