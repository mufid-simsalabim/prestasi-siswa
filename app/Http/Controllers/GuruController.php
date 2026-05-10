<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    // Daftar pilihan kelas untuk wali kelas
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

    // Tampilkan daftar semua guru
    public function index(Request $request)
    {
        $search = $request->get('search');

        $gurus = User::where('role', 'guru')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('kelas', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('guru.index', compact('gurus', 'search'));
    }

    // Tampilkan form tambah guru
    public function create()
    {
        $daftarKelas = $this->daftarKelas();
        return view('guru.create', compact('daftarKelas'));
    }

    // Simpan guru baru
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'kelas'    => 'required|string',
        ], [
            'name.required'      => 'Nama guru wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.required'  => 'Password wajib diisi.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'kelas.required'     => 'Wali kelas wajib dipilih.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'guru',
            'kelas'    => $request->kelas,
        ]);

        return redirect()->route('guru.index')
            ->with('success', 'Akun guru berhasil ditambahkan.');
    }

    // Tampilkan form edit guru
    public function edit(User $guru)
    {
        $daftarKelas = $this->daftarKelas();
        return view('guru.edit', compact('guru', 'daftarKelas'));
    }

    // Update data guru
    public function update(Request $request, User $guru)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $guru->id,
            'password' => 'nullable|min:6|confirmed',
            'kelas'    => 'required|string',
        ], [
            'name.required'      => 'Nama guru wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email sudah digunakan.',
            'password.min'       => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'kelas.required'     => 'Wali kelas wajib dipilih.',
        ]);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'kelas' => $request->kelas,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $guru->update($data);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    // Hapus guru
    public function destroy(User $guru)
    {
        if ($guru->id === auth()->id()) {
            return redirect()->route('guru.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $guru->delete();

        return redirect()->route('guru.index')
            ->with('success', 'Akun guru berhasil dihapus.');
    }
}