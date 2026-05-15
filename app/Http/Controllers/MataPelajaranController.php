<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::latest()->paginate(10);
        return view('mapel.index', compact('mapel'));
    }

    public function create()
    {
        return view('mapel.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:10|unique:mata_pelajaran,kode',
            'kkm'  => 'required|integer|min:0|max:100',
        ], [
            'nama.required' => 'Nama mata pelajaran wajib diisi.',
            'kode.required' => 'Kode mata pelajaran wajib diisi.',
            'kode.unique'   => 'Kode sudah digunakan.',
            'kkm.required'  => 'KKM wajib diisi.',
        ]);

        MataPelajaran::create($request->all());

        return redirect()->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit(MataPelajaran $mapel)
    {
        return view('mapel.edit', compact('mapel'));
    }

    public function update(Request $request, MataPelajaran $mapel)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:10|unique:mata_pelajaran,kode,' . $mapel->id,
            'kkm'  => 'required|integer|min:0|max:100',
        ]);

        $mapel->update($request->all());

        return redirect()->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy(MataPelajaran $mapel)
    {
        $mapel->delete();
        return redirect()->route('mapel.index')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}