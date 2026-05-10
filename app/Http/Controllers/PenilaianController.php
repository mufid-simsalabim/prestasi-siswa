<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penilaian;
use App\Models\Student;
use App\Services\C45Service;
use Barryvdh\DomPDF\Facade\Pdf;

class PenilaianController extends Controller
{
    protected $c45;

    public function __construct(C45Service $c45)
    {
        $this->c45 = $c45;
    }

    public function index(Request $request)
    {
        $search   = $request->get('search');
        $semester = $request->get('semester');
        $user     = auth()->user();

        $penilaian = Penilaian::with('student', 'guru')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->where('nama', 'like', '%' . $search . '%');
                });
            })
            ->when($semester, function ($query) use ($semester) {
                $query->where('semester', $semester);
            })
            // Guru hanya lihat siswa di kelasnya
            ->when($user->isGuru(), function ($query) use ($user) {
                $query->whereHas('student', function ($q) use ($user) {
                    $q->where('kelas', $user->kelas);
                });
            })
            ->latest()
            ->paginate(10);

        $semesters = Penilaian::distinct()->pluck('semester');

        return view('penilaian.index', compact('penilaian', 'search', 'semester', 'semesters'));
    }

    public function create()
    {
        $user = auth()->user();

        // Guru hanya lihat siswa di kelasnya sendiri
        $students = Student::when($user->isGuru(), function ($query) use ($user) {
                $query->where('kelas', $user->kelas);
            })
            ->orderBy('nama')
            ->get();

        return view('penilaian.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'nilai'      => 'required|numeric|min:0|max:100',
            'kehadiran'  => 'required|numeric|min:0|max:100',
            'keaktifan'  => 'required|numeric|min:0|max:100',
            'sikap'      => 'required|numeric|min:0|max:100',
            'semester'   => 'required|string',
        ], [
            'student_id.required' => 'Siswa wajib dipilih.',
            'student_id.exists'   => 'Siswa tidak ditemukan.',
            'nilai.required'      => 'Nilai akademik wajib diisi.',
            'nilai.numeric'       => 'Nilai harus berupa angka.',
            'nilai.min'           => 'Nilai minimal 0.',
            'nilai.max'           => 'Nilai maksimal 100.',
            'kehadiran.required'  => 'Kehadiran wajib diisi.',
            'keaktifan.required'  => 'Keaktifan wajib diisi.',
            'sikap.required'      => 'Sikap wajib diisi.',
            'semester.required'   => 'Semester wajib diisi.',
        ]);

        // Hitung klasifikasi C4.5
        $hasil = $this->c45->klasifikasi(
            $request->nilai,
            $request->kehadiran,
            $request->keaktifan,
            $request->sikap
        );

        Penilaian::create([
            'student_id'     => $request->student_id,
            'user_id'        => auth()->id(),
            'nilai'          => $request->nilai,
            'kehadiran'      => $request->kehadiran,
            'keaktifan'      => $request->keaktifan,
            'sikap'          => $request->sikap,
            'semester'       => $request->semester,
            'hasil_prestasi' => $hasil['hasil'],
            'skor'           => $hasil['skor'],
        ]);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan. Hasil: ' . $hasil['hasil']);
    }

    public function show(Penilaian $penilaian)
    {
        $penilaian->load('student', 'guru');
        $detail = $this->c45->klasifikasi(
            $penilaian->nilai,
            $penilaian->kehadiran,
            $penilaian->keaktifan,
            $penilaian->sikap
        );
        return view('penilaian.show', compact('penilaian', 'detail'));
    }

    public function edit(Penilaian $penilaian)
    {
        $user = auth()->user();

        $students = Student::when($user->isGuru(), function ($query) use ($user) {
                $query->where('kelas', $user->kelas);
            })
            ->orderBy('nama')
            ->get();

        return view('penilaian.edit', compact('penilaian', 'students'));
    }

    public function update(Request $request, Penilaian $penilaian)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'nilai'      => 'required|numeric|min:0|max:100',
            'kehadiran'  => 'required|numeric|min:0|max:100',
            'keaktifan'  => 'required|numeric|min:0|max:100',
            'sikap'      => 'required|numeric|min:0|max:100',
            'semester'   => 'required|string',
        ]);

        $hasil = $this->c45->klasifikasi(
            $request->nilai,
            $request->kehadiran,
            $request->keaktifan,
            $request->sikap
        );

        $penilaian->update([
            'student_id'     => $request->student_id,
            'nilai'          => $request->nilai,
            'kehadiran'      => $request->kehadiran,
            'keaktifan'      => $request->keaktifan,
            'sikap'          => $request->sikap,
            'semester'       => $request->semester,
            'hasil_prestasi' => $hasil['hasil'],
            'skor'           => $hasil['skor'],
        ]);

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function destroy(Penilaian $penilaian)
    {
        $penilaian->delete();
        return redirect()->route('penilaian.index')
            ->with('success', 'Data penilaian berhasil dihapus.');
    }

    public function hasil(Request $request)
    {
        $user     = auth()->user();
        $semester = $request->get('semester');

        $penilaian = Penilaian::with('student')
            ->whereNotNull('hasil_prestasi')
            ->when($semester, function ($query) use ($semester) {
                $query->where('semester', $semester);
            })
            // Guru hanya lihat kelasnya
            ->when($user->isGuru(), function ($query) use ($user) {
                $query->whereHas('student', function ($q) use ($user) {
                    $q->where('kelas', $user->kelas);
                });
            })
            ->orderBy('skor', 'desc')
            ->paginate(10);

        $statistik = [
            'amat_baik' => Penilaian::where('hasil_prestasi', 'Amat Baik')->count(),
            'baik'      => Penilaian::where('hasil_prestasi', 'Baik')->count(),
            'cukup'     => Penilaian::where('hasil_prestasi', 'Cukup')->count(),
            'kurang'    => Penilaian::where('hasil_prestasi', 'Kurang')->count(),
        ];

        $semesters = Penilaian::distinct()->pluck('semester');

        return view('penilaian.hasil', compact('penilaian', 'statistik', 'semesters', 'semester'));
    }

    public function ranking(Request $request)
    {
        $user     = auth()->user();
        $semester = $request->get('semester');

        $ranking = Penilaian::with('student')
            ->whereNotNull('skor')
            ->when($semester, function ($query) use ($semester) {
                $query->where('semester', $semester);
            })
            // Guru hanya lihat kelasnya
            ->when($user->isGuru(), function ($query) use ($user) {
                $query->whereHas('student', function ($q) use ($user) {
                    $q->where('kelas', $user->kelas);
                });
            })
            ->orderBy('skor', 'desc')
            ->paginate(10);

        $semesters = Penilaian::distinct()->pluck('semester');

        return view('penilaian.ranking', compact('ranking', 'semesters', 'semester'));
    }

    public function exportPdf(Request $request)
    {
        $semester = $request->get('semester');
        $user     = auth()->user();

        $penilaian = Penilaian::with('student', 'guru')
            ->whereNotNull('hasil_prestasi')
            ->when($semester, function ($query) use ($semester) {
                $query->where('semester', $semester);
            })
            ->when($user->isGuru(), function ($query) use ($user) {
                $query->whereHas('student', function ($q) use ($user) {
                    $q->where('kelas', $user->kelas);
                });
            })
            ->orderBy('skor', 'desc')
            ->get();

        $statistik = [
            'amat_baik' => $penilaian->where('hasil_prestasi', 'Amat Baik')->count(),
            'baik'      => $penilaian->where('hasil_prestasi', 'Baik')->count(),
            'cukup'     => $penilaian->where('hasil_prestasi', 'Cukup')->count(),
            'kurang'    => $penilaian->where('hasil_prestasi', 'Kurang')->count(),
        ];

        $pdf = Pdf::loadView('penilaian.export-pdf', compact('penilaian', 'statistik', 'semester'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-prestasi-siswa.pdf');
    }
}