@extends('layouts.app')

@section('title', 'Tambah Siswa')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('students.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Data Siswa
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Tambah Siswa Baru</h2>

        <form action="{{ route('students.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="label-field">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}"
                       class="input-field @error('nama') border-red-500 @enderror"
                       placeholder="Masukkan nama lengkap siswa">
                @error('nama')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="label-field">Kelas <span class="text-red-500">*</span></label>
                <select name="kelas" class="input-field @error('kelas') border-red-500 @enderror">
                    <option value="">-- Pilih Kelas --</option>
                    @foreach($daftarKelas as $kelas)
                    <option value="{{ $kelas }}" {{ old('kelas') === $kelas ? 'selected' : '' }}>
                        Kelas {{ $kelas }}
                    </option>
                    @endforeach
                </select>
                @error('kelas')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="label-field">Jenis Kelamin <span class="text-red-500">*</span></label>
                <select name="jenis_kelamin" class="input-field @error('jenis_kelamin') border-red-500 @enderror">
                    <option value="">-- Pilih Jenis Kelamin --</option>
                    <option value="L" {{ old('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                </select>
                @error('jenis_kelamin')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="label-field">Alamat</label>
                <textarea name="alamat" rows="3"
                          class="input-field @error('alamat') border-red-500 @enderror"
                          placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                @error('alamat')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1">Simpan Data</button>
                <a href="{{ route('students.index') }}" class="btn-secondary flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection