@extends('layouts.app')

@section('title', 'Tambah Kelas')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('kelas.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Data Kelas
        </a>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Tambah Kelas Baru</h2>
        <form action="{{ route('kelas.store') }}" method="POST" class="space-y-5">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label-field">Tingkat <span class="text-red-500">*</span></label>
                    <select name="tingkat" class="input-field @error('tingkat') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        @for($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" {{ old('tingkat') == $i ? 'selected' : '' }}>Kelas {{ $i }}</option>
                        @endfor
                    </select>
                    @error('tingkat')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label-field">Kelas <span class="text-red-500">*</span></label>
                    <select name="huruf" class="input-field @error('huruf') border-red-500 @enderror">
                        <option value="">-- Pilih --</option>
                        <option value="A" {{ old('huruf') === 'A' ? 'selected' : '' }}>A</option>
                        <option value="B" {{ old('huruf') === 'B' ? 'selected' : '' }}>B</option>
                        <option value="C" {{ old('huruf') === 'C' ? 'selected' : '' }}>C</option>
                    </select>
                    @error('huruf')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="label-field">Wali Kelas</label>
                <select name="wali_kelas_id" class="input-field">
                    <option value="">-- Pilih Wali Kelas --</option>
                    @foreach($gurus as $guru)
                    <option value="{{ $guru->id }}" {{ old('wali_kelas_id') == $guru->id ? 'selected' : '' }}>
                        {{ $guru->name }} {{ $guru->kelas ? '(Kelas ' . $guru->kelas . ')' : '' }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label-field">Tahun Ajaran <span class="text-red-500">*</span></label>
                <input type="number" name="tahun_ajaran" value="{{ old('tahun_ajaran', date('Y')) }}"
                       class="input-field @error('tahun_ajaran') border-red-500 @enderror"
                       placeholder="Contoh: 2024">
                @error('tahun_ajaran')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1">Simpan</button>
                <a href="{{ route('kelas.index') }}" class="btn-secondary flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection