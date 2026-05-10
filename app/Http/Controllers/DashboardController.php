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
        // Total data untuk statistik card
        $totalSiswa      = Student::count();
        $totalPenilaian  = Penilaian::count();
        $totalGuru       = User::where('role', 'guru')->count();
        $totalRules      = Rule::count();

        // Data grafik: jumlah siswa per kategori prestasi
        $grafikPrestasi = Penilaian::selectRaw('hasil_prestasi, COUNT(*) as total')
            ->whereNotNull('hasil_prestasi')
            ->groupBy('hasil_prestasi')
            ->pluck('total', 'hasil_prestasi')
            ->toArray();

        // Data grafik: jumlah siswa per kelas
        $grafikKelas = Student::selectRaw('kelas, COUNT(*) as total')
            ->groupBy('kelas')
            ->pluck('total', 'kelas')
            ->toArray();

        // Ranking siswa: ambil 5 teratas berdasarkan skor
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

        return view('dashboard', compact(
            'totalSiswa',
            'totalPenilaian',
            'totalGuru',
            'totalRules',
            'grafikPrestasi',
            'grafikKelas',
            'rankingSiswa',
            'penilaianTerbaru'
        ));
    }
}