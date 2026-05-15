<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Student;

class RankingController extends Controller
{
    // Ranking per kelas (untuk guru)
    public function rankingKelas(Request $request)
    {
        $user     = auth()->user();
        $semester = $request->get('semester');
        $kelas    = $user->isGuru() ? $user->kelas : $request->get('kelas');

        $ranking = Penilaian::with('student')
            ->whereNotNull('skor')
            ->whereHas('student', function ($q) use ($kelas) {
                if ($kelas) $q->where('kelas', $kelas);
            })
            ->when($semester, function ($q) use ($semester) {
                $q->where('semester', $semester);
            })
            ->orderBy('skor', 'desc')
            ->get()
            ->map(function ($item, $index) {
                $item->rank = $index + 1;
                return $item;
            });

        $semesters = Penilaian::distinct()->pluck('semester');

        // Daftar kelas untuk admin
        $daftarKelas = [];
        for ($t = 1; $t <= 6; $t++) {
            foreach (['A', 'B', 'C'] as $h) {
                $daftarKelas[] = $t . '-' . $h;
            }
        }

        return view('ranking.kelas', compact('ranking', 'semesters', 'semester', 'kelas', 'daftarKelas'));
    }

    // Ranking per angkatan (untuk admin)
    public function rankingAngkatan(Request $request)
    {
        $semester = $request->get('semester');
        $tingkat  = $request->get('tingkat');

        $rankingAngkatan = [];

        for ($t = 1; $t <= 6; $t++) {
            $query = Penilaian::with('student')
                ->whereNotNull('skor')
                ->whereHas('student', function ($q) use ($t) {
                    $q->where('kelas', 'like', $t . '-%');
                })
                ->when($semester, function ($q) use ($semester) {
                    $q->where('semester', $semester);
                })
                ->orderBy('skor', 'desc')
                ->take(3)
                ->get();

            if ($query->count() > 0) {
                $rankingAngkatan[$t] = $query;
            }
        }

        // Ranking lengkap untuk tingkat tertentu
        $rankingDetail = null;
        if ($tingkat) {
            $rankingDetail = Penilaian::with('student')
                ->whereNotNull('skor')
                ->whereHas('student', function ($q) use ($tingkat) {
                    $q->where('kelas', 'like', $tingkat . '-%');
                })
                ->when($semester, function ($q) use ($semester) {
                    $q->where('semester', $semester);
                })
                ->orderBy('skor', 'desc')
                ->get()
                ->map(function ($item, $index) {
                    $item->rank = $index + 1;
                    return $item;
                });
        }

        $semesters = Penilaian::distinct()->pluck('semester');

        return view('ranking.angkatan', compact(
            'rankingAngkatan',
            'rankingDetail',
            'semesters',
            'semester',
            'tingkat'
        ));
    }
}