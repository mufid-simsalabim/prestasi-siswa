<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\User;
use App\Models\Student;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::with('waliKelas')
            ->orderBy('tingkat')
            ->orderBy('huruf')
            ->paginate(18);

        return view('kelas.index', compact('kelas'));
    }

    public function create()
    {
        $gurus = User::where('role', 'guru')->orderBy('name')->get();
        return view('kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tingkat'      => 'required|integer|min:1|max:6',
            'huruf'        => 'required|in:A,B,C',
            'tahun_ajaran' => 'required|integer',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        $nama = $request->tingkat . '-' . $request->huruf;

        Kelas::create([
            'nama'          => $nama,
            'tingkat'       => $request->tingkat,
            'huruf'         => $request->huruf,
            'wali_kelas_id' => $request->wali_kelas_id,
            'tahun_ajaran'  => $request->tahun_ajaran,
            'is_active'     => true,
        ]);

        // Update kolom kelas di tabel users jika ada wali kelas
        if ($request->wali_kelas_id) {
            User::where('id', $request->wali_kelas_id)
                ->update(['kelas' => $nama]);
        }

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    public function edit(Kelas $kela)
    {
        $gurus = User::where('role', 'guru')->orderBy('name')->get();
        return view('kelas.edit', compact('kela', 'gurus'));
    }

    public function update(Request $request, Kelas $kela)
    {
        $request->validate([
            'tingkat'       => 'required|integer|min:1|max:6',
            'huruf'         => 'required|in:A,B,C',
            'tahun_ajaran'  => 'required|integer',
            'wali_kelas_id' => 'nullable|exists:users,id',
        ]);

        $nama = $request->tingkat . '-' . $request->huruf;

        $kela->update([
            'nama'          => $nama,
            'tingkat'       => $request->tingkat,
            'huruf'         => $request->huruf,
            'wali_kelas_id' => $request->wali_kelas_id,
            'tahun_ajaran'  => $request->tahun_ajaran,
        ]);

        if ($request->wali_kelas_id) {
            User::where('id', $request->wali_kelas_id)
                ->update(['kelas' => $nama]);
        }

        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy(Kelas $kela)
    {
        $kela->delete();
        return redirect()->route('kelas.index')
            ->with('success', 'Kelas berhasil dihapus.');
    }

    public function show(Kelas $kela)
    {
        $siswa = Student::where('kelas', $kela->nama)
            ->with('penilaianTerbaru')
            ->orderBy('nama')
            ->get();

        return view('kelas.show', compact('kela', 'siswa'));
    }
}