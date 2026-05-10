@extends('layouts.app')

@section('title', 'Edit Penilaian')

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
        <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Edit Penilaian Siswa</h2>

        <form action="{{ route('penilaian.update', $penilaian) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label class="label-field">Pilih Siswa <span class="text-red-500">*</span></label>
                <select name="student_id" class="input-field @error('student_id') border-red-500 @enderror">
                    <option value="">-- Pilih Siswa --</option>
                    @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ old('student_id', $penilaian->student_id) == $student->id ? 'selected' : '' }}>
                        {{ $student->nama }} - {{ $student->kelas }}
                    </option>
                    @endforeach
                </select>
                @error('student_id')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="label-field">Semester <span class="text-red-500">*</span></label>
                <input type="text" name="semester" value="{{ old('semester', $penilaian->semester) }}"
                       class="input-field @error('semester') border-red-500 @enderror"
                       placeholder="Contoh: Ganjil 2024/2025">
                @error('semester')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label-field">Nilai Akademik <span class="text-red-500">*</span></label>
                    <input type="number" name="nilai" value="{{ old('nilai', $penilaian->nilai) }}"
                           class="input-field @error('nilai') border-red-500 @enderror"
                           placeholder="0 - 100" min="0" max="100" step="0.01">
                    @error('nilai')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label-field">Kehadiran (%) <span class="text-red-500">*</span></label>
                    <input type="number" name="kehadiran" value="{{ old('kehadiran', $penilaian->kehadiran) }}"
                           class="input-field @error('kehadiran') border-red-500 @enderror"
                           placeholder="0 - 100" min="0" max="100" step="0.01">
                    @error('kehadiran')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label-field">Keaktifan <span class="text-red-500">*</span></label>
                    <input type="number" name="keaktifan" value="{{ old('keaktifan', $penilaian->keaktifan) }}"
                           class="input-field @error('keaktifan') border-red-500 @enderror"
                           placeholder="0 - 100" min="0" max="100" step="0.01">
                    @error('keaktifan')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="label-field">Sikap <span class="text-red-500">*</span></label>
                    <input type="number" name="sikap" value="{{ old('sikap', $penilaian->sikap) }}"
                           class="input-field @error('sikap') border-red-500 @enderror"
                           placeholder="0 - 100" min="0" max="100" step="0.01">
                    @error('sikap')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1">Update & Klasifikasi Ulang</button>
                <a href="{{ route('penilaian.index') }}" class="btn-secondary flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection