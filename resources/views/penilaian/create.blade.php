@extends('layouts.app')

@section('title', 'Input Penilaian')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('penilaian.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Data Penilaian
        </a>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Input Penilaian Siswa</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Sistem akan otomatis menklasifikasi prestasi menggunakan algoritma C4.5</p>

        <form action="{{ route('penilaian.store') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="label-field">Pilih Siswa <span class="text-red-500">*</span></label>
                <select name="student_id" class="input-field @error('student_id') border-red-500 @enderror">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>
                        {{ $student->nama }} - {{ $student->kelas }}
                    </option>
                    @endforeach
                </select>
                @error('student_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="label-field">Semester <span class="text-red-500">*</span></label>
                <input type="text" name="semester" value="{{ old('semester') }}"
                       class="input-field @error('semester') border-red-500 @enderror"
                       placeholder="Contoh: Ganjil 2024/2025">
                @error('semester')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            {{-- Nilai --}}
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label-field">Nilai Akademik <span class="text-red-500">*</span></label>
                    <input type="number" name="nilai" value="{{ old('nilai') }}"
                           class="input-field @error('nilai') border-red-500 @enderror"
                           placeholder="0 - 100" min="0" max="100" step="0.01">
                    @error('nilai')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label-field">Kehadiran (%) <span class="text-red-500">*</span></label>
                    <input type="number" name="kehadiran" value="{{ old('kehadiran') }}"
                           class="input-field @error('kehadiran') border-red-500 @enderror"
                           placeholder="0 - 100" min="0" max="100" step="0.01">
                    @error('kehadiran')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label-field">Keaktifan <span class="text-red-500">*</span></label>
                    <input type="number" name="keaktifan" value="{{ old('keaktifan') }}"
                           class="input-field @error('keaktifan') border-red-500 @enderror"
                           placeholder="0 - 100" min="0" max="100" step="0.01">
                    @error('keaktifan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label-field">Sikap <span class="text-red-500">*</span></label>
                    <input type="number" name="sikap" value="{{ old('sikap') }}"
                           class="input-field @error('sikap') border-red-500 @enderror"
                           placeholder="0 - 100" min="0" max="100" step="0.01">
                    @error('sikap')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            {{-- Info C4.5 --}}
            <div class="p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg border border-blue-200 dark:border-blue-700">
                <div class="flex items-start space-x-2">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div class="text-sm text-blue-700 dark:text-blue-300">
                        <p class="font-semibold mb-1">Klasifikasi Otomatis C4.5</p>
                        <p>Setelah disimpan, sistem akan otomatis menghitung dan menentukan prestasi siswa berdasarkan algoritma Decision Tree C4.5.</p>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1">Simpan & Klasifikasi</button>
                <a href="{{ route('penilaian.index') }}" class="btn-secondary flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection