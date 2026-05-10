@extends('layouts.app')

@section('title', 'Tambah Guru')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('guru.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Kelola Guru
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Tambah Akun Guru</h2>

        <form action="{{ route('guru.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="label-field">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="input-field @error('name') border-red-500 @enderror"
                       placeholder="Masukkan nama lengkap guru">
                @error('name')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="label-field">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="input-field @error('email') border-red-500 @enderror"
                       placeholder="contoh@email.com">
                @error('email')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Pilihan Wali Kelas --}}
            <div>
                <label class="label-field">Wali Kelas <span class="text-red-500">*</span></label>
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
                <label class="label-field">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password"
                       class="input-field @error('password') border-red-500 @enderror"
                       placeholder="Minimal 6 karakter">
                @error('password')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="label-field">Konfirmasi Password <span class="text-red-500">*</span></label>
                <input type="password" name="password_confirmation"
                       class="input-field"
                       placeholder="Ulangi password">
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1">Simpan Akun</button>
                <a href="{{ route('guru.index') }}" class="btn-secondary flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection