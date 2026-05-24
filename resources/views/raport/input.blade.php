@extends('layouts.app')

@section('title', 'Input Nilai Raport')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('raport.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>
</div>

{{-- Info Siswa --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex items-center space-x-4">
        <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl">
            {{ strtoupper(substr($student->nama, 0, 1)) }}
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $student->nama }}</h2>
            <p class="text-gray-500">Kelas {{ $student->kelas }}</p>
        </div>
    </div>
</div>

{{-- Form Input Nilai --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
    <form action="{{ route('raport.store', $student) }}" method="POST">
        @csrf

        {{-- Semester --}}
        <div class="mb-6">
            <label class="label-field">Semester <span class="text-red-500">*</span></label>
            <input type="text" name="semester" value="{{ old('semester', $semester) }}"
                   class="input-field max-w-xs"
                   placeholder="Contoh: Ganjil 2024/2025">
        </div>

        {{-- Tabel Nilai --}}
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">Mata Pelajaran</th>
                        <th class="px-4 py-3 text-center">KKM</th>
                        <th class="px-4 py-3 text-center">Nilai Harian</th>
                        <th class="px-4 py-3 text-center">Nilai UTS</th>
                        <th class="px-4 py-3 text-center">Nilai UAS</th>
                        <th class="px-4 py-3 text-center">Nilai Akhir</th>
                        <th class="px-4 py-3 text-left">Catatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($mapel as $m)
                    @php
                        $existing = $nilaiExisting[$m->id] ?? null;
                    @endphp
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-4 py-3">
                            <p class="font-medium text-gray-800 dark:text-white">{{ $m->nama }}</p>
                            <span class="text-xs text-gray-400">{{ $m->kode }}</span>
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="text-gray-600 dark:text-gray-300">{{ $m->kkm }}</span>
                        </td>
                        <td class="px-4 py-3">
                            <input type="number" name="nilai[{{ $m->id }}][harian]"
                                   value="{{ old('nilai.'.$m->id.'.harian', $existing?->nilai_harian ?? '') }}"
                                   class="w-20 text-center border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   min="0" max="100" step="0.01" placeholder="0">
                        </td>
                        <td class="px-4 py-3">
                            <input type="number" name="nilai[{{ $m->id }}][uts]"
                                   value="{{ old('nilai.'.$m->id.'.uts', $existing?->nilai_uts ?? '') }}"
                                   class="w-20 text-center border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   min="0" max="100" step="0.01" placeholder="0">
                        </td>
                        <td class="px-4 py-3">
                            <input type="number" name="nilai[{{ $m->id }}][uas]"
                                   value="{{ old('nilai.'.$m->id.'.uas', $existing?->nilai_uas ?? '') }}"
                                   class="w-20 text-center border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   min="0" max="100" step="0.01" placeholder="0">
                        </td>
                        <td class="px-4 py-3 text-center">
                            <span class="font-semibold text-blue-600" id="akhir-{{ $m->id }}">
                                {{ $existing ? number_format($existing->nilai_akhir, 2) : '-' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <input type="text" name="nilai[{{ $m->id }}][catatan]"
                                   value="{{ old('nilai.'.$m->id.'.catatan', $existing?->catatan ?? '') }}"
                                   class="w-32 border border-gray-300 dark:border-gray-600 rounded-lg px-2 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                                   placeholder="Opsional">
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/30 rounded-lg">
            <p class="text-xs text-blue-700 dark:text-blue-300">
                <strong>Rumus Nilai Akhir:</strong> (Nilai Harian × 30%) + (Nilai UTS × 30%) + (Nilai UAS × 40%)
            </p>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="btn-primary flex-1">Simpan Raport</button>
            <a href="{{ route('raport.index') }}" class="btn-secondary flex-1 text-center">Batal</a>
        </div>
    </form>
</div>

@endsection