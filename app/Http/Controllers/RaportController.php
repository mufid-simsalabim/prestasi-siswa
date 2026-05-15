<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Raport;
use App\Models\Student;
use App\Models\MataPelajaran;
use App\Models\Penilaian;
use App\Services\C45Service;
use Barryvdh\DomPDF\Facade\Pdf;

class RaportController extends Controller
{
    protected $c45;

    public function __construct(C45Service $c45)
    {
        $this->c45 = $c45;
    }

    public function index(Request $request)
    {
        $user     = auth()->user();
        $search   = $request->get('search');
        $semester = $request->get('semester');

        $students = Student::query()
            ->when($user->isGuru(), function ($q) use ($user) {
                $q->where('kelas', $user->kelas);
            })
            ->when($search, function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            })
            ->orderBy('nama')
            ->paginate(10);

        $semesters = Raport::distinct()->pluck('semester');

        return view('raport.index', compact('students', 'search', 'semester', 'semesters'));
    }

    public function input(Request $request, Student $student)
    {
        $mapel    = MataPelajaran::where('is_active', true)->get();
        $semester = $request->get('semester', 'Ganjil ' . date('Y') . '/' . (date('Y') + 1));

        // Ambil nilai yang sudah ada
        $nilaiExisting = Raport::where('student_id', $student->id)
            ->where('semester', $semester)
            ->with('mataPelajaran')
            ->get()
            ->keyBy('mata_pelajaran_id');

        return view('raport.input', compact('student', 'mapel', 'semester', 'nilaiExisting'));
    }

    public function store(Request $request, Student $student)
    {
        $request->validate([
            'semester'    => 'required|string',
            'nilai'       => 'required|array',
            'nilai.*.harian' => 'required|numeric|min:0|max:100',
            'nilai.*.uts'    => 'required|numeric|min:0|max:100',
            'nilai.*.uas'    => 'required|numeric|min:0|max:100',
        ]);

        foreach ($request->nilai as $mapelId => $nilai) {
            // Hitung nilai akhir: 30% harian + 30% UTS + 40% UAS
            $nilaiAkhir = ($nilai['harian'] * 0.3) + ($nilai['uts'] * 0.3) + ($nilai['uas'] * 0.4);

            Raport::updateOrCreate(
                [
                    'student_id'       => $student->id,
                    'mata_pelajaran_id' => $mapelId,
                    'semester'         => $request->semester,
                ],
                [
                    'user_id'      => auth()->id(),
                    'nilai_harian' => $nilai['harian'],
                    'nilai_uts'    => $nilai['uts'],
                    'nilai_uas'    => $nilai['uas'],
                    'nilai_akhir'  => round($nilaiAkhir, 2),
                    'catatan'      => $nilai['catatan'] ?? null,
                ]
            );
        }

        // Hitung rata-rata semua mapel untuk C4.5
        $avgNilai = Raport::where('student_id', $student->id)
            ->where('semester', $request->semester)
            ->avg('nilai_akhir');

        // Ambil data kehadiran, keaktifan, sikap dari penilaian
        $penilaian = Penilaian::where('student_id', $student->id)
            ->where('semester', $request->semester)
            ->first();

        if ($penilaian && $avgNilai) {
            $hasil = $this->c45->klasifikasi(
                $avgNilai,
                $penilaian->kehadiran,
                $penilaian->keaktifan,
                $penilaian->sikap
            );

            $penilaian->update([
                'nilai'          => $avgNilai,
                'hasil_prestasi' => $hasil['hasil'],
                'skor'           => $hasil['skor'],
            ]);
        }

        return redirect()->route('raport.index')
            ->with('success', 'Raport berhasil disimpan.');
    }

    public function show(Student $student, Request $request)
    {
        $semester = $request->get('semester', 'Ganjil ' . date('Y') . '/' . (date('Y') + 1));

        $raport = Raport::where('student_id', $student->id)
            ->where('semester', $semester)
            ->with('mataPelajaran')
            ->get();

        $penilaian = Penilaian::where('student_id', $student->id)
            ->where('semester', $semester)
            ->first();

        $semesters = Raport::where('student_id', $student->id)
            ->distinct()
            ->pluck('semester');

        return view('raport.show', compact('student', 'raport', 'penilaian', 'semester', 'semesters'));
    }

    public function cetak(Student $student, Request $request)
    {
        $semester = $request->get('semester', 'Ganjil ' . date('Y') . '/' . (date('Y') + 1));

        $raport = Raport::where('student_id', $student->id)
            ->where('semester', $semester)
            ->with('mataPelajaran')
            ->get();

        $penilaian = Penilaian::where('student_id', $student->id)
            ->where('semester', $semester)
            ->first();

        $pdf = Pdf::loadView('raport.cetak', compact('student', 'raport', 'penilaian', 'semester'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('raport-' . $student->nama . '-' . $semester . '.pdf');
    }
}