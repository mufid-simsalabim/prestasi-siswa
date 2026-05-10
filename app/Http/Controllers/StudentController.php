<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    // Daftar pilihan kelas MI (Madrasah Ibtidaiyah)
    private function daftarKelas()
    {
        $kelas = [];
        for ($tingkat = 1; $tingkat <= 6; $tingkat++) {
            foreach (['A', 'B', 'C'] as $huruf) {
                $kelas[] = $tingkat . '-' . $huruf;
            }
        }
        return $kelas;
    }

    // Tampilkan daftar semua siswa
    public function index(Request $request)
    {
        $search    = $request->get('search');
        $kelasFilter = $request->get('kelas');

        $students = Student::query()
            ->when($search, function ($query) use ($search) {
                $query->where('nama', 'like', '%' . $search . '%');
            })
            ->when($kelasFilter, function ($query) use ($kelasFilter) {
                $query->where('kelas', $kelasFilter);
            })
            ->latest()
            ->paginate(10);

        $daftarKelas = $this->daftarKelas();

        return view('students.index', compact('students', 'search', 'kelasFilter', 'daftarKelas'));
    }

    // Tampilkan form tambah siswa
    public function create()
    {
        $daftarKelas = $this->daftarKelas();
        return view('students.create', compact('daftarKelas'));
    }

    // Simpan siswa baru
    public function store(Request $request)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'kelas'         => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'nullable|string',
        ], [
            'nama.required'          => 'Nama siswa wajib diisi.',
            'kelas.required'         => 'Kelas wajib dipilih.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    // Tampilkan detail siswa
    public function show(Student $student)
    {
        $penilaian = $student->penilaian()->with('guru')->latest()->get();
        return view('students.show', compact('student', 'penilaian'));
    }

    // Tampilkan form edit siswa
    public function edit(Student $student)
    {
        $daftarKelas = $this->daftarKelas();
        return view('students.edit', compact('student', 'daftarKelas'));
    }

    // Update data siswa
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'nama'          => 'required|string|max:255',
            'kelas'         => 'required|string',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'nullable|string',
        ], [
            'nama.required'          => 'Nama siswa wajib diisi.',
            'kelas.required'         => 'Kelas wajib dipilih.',
            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
        ]);

        $student->update($request->all());

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    // Hapus siswa
    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('students.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    // Import siswa dari Excel/CSV
    public function importForm()
    {
        return view('students.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ], [
            'file.required' => 'File wajib dipilih.',
            'file.mimes'    => 'File harus berformat Excel (xlsx, xls) atau CSV.',
            'file.max'      => 'Ukuran file maksimal 2MB.',
        ]);

        try {
            $file      = $request->file('file');
            $extension = $file->getClientOriginalExtension();

            // Baca file CSV
            if ($extension === 'csv') {
                $data = array_map('str_getcsv', file($file->getRealPath()));
            } else {
                // Baca file Excel pakai PhpSpreadsheet
                $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file->getRealPath());
                $sheet       = $spreadsheet->getActiveSheet();
                $data        = $sheet->toArray();
            }

            // Skip baris pertama (header)
            $imported = 0;
            foreach (array_slice($data, 1) as $row) {
                if (empty($row[0])) continue;

                Student::create([
                    'nama'          => $row[0] ?? '',
                    'kelas'         => $row[1] ?? '',
                    'jenis_kelamin' => $row[2] ?? 'L',
                    'alamat'        => $row[3] ?? '',
                ]);
                $imported++;
            }

            return redirect()->route('students.index')
                ->with('success', $imported . ' data siswa berhasil diimport.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
    // Download template Excel untuk import
public function downloadTemplate()
{
    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $sheet->setCellValue('A1', 'nama');
    $sheet->setCellValue('B1', 'kelas');
    $sheet->setCellValue('C1', 'jenis_kelamin');
    $sheet->setCellValue('D1', 'alamat');

    // Contoh data
    $sheet->setCellValue('A2', 'Ahmad Fauzi');
    $sheet->setCellValue('B2', '1-A');
    $sheet->setCellValue('C2', 'L');
    $sheet->setCellValue('D2', 'Jl. Merdeka No. 1');

    $sheet->setCellValue('A3', 'Dewi Putri');
    $sheet->setCellValue('B3', '1-B');
    $sheet->setCellValue('C3', 'P');
    $sheet->setCellValue('D3', 'Jl. Mawar No. 2');

    // Style header
    $sheet->getStyle('A1:D1')->getFont()->setBold(true);
    $sheet->getColumnDimension('A')->setWidth(25);
    $sheet->getColumnDimension('B')->setWidth(10);
    $sheet->getColumnDimension('C')->setWidth(15);
    $sheet->getColumnDimension('D')->setWidth(30);

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

    $filename = 'template-import-siswa.xlsx';
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}
// Hapus semua siswa
public function destroyAll()
{
    Student::truncate();
    return redirect()->route('students.index')
        ->with('success', 'Semua data siswa berhasil dihapus.');
}

// Hapus siswa terpilih
public function destroySelected(Request $request)
{
    $request->validate([
        'selected' => 'required|array',
        'selected.*' => 'exists:students,id',
    ]);

    Student::whereIn('id', $request->selected)->delete();

    return redirect()->route('students.index')
        ->with('success', count($request->selected) . ' data siswa berhasil dihapus.');
}
}