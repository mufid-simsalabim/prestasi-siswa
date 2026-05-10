@extends('layouts.app')

@section('title', 'Detail Penilaian')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('penilaian.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Data Penilaian
        </a>
    </div>

    {{-- Hasil Klasifikasi --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-4">
                <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl">
                    {{ strtoupper(substr($penilaian->student->nama, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $penilaian->student->nama }}</h2>
                    <p class="text-gray-500 dark:text-gray-400">{{ $penilaian->student->kelas }} • {{ $penilaian->semester }}</p>
                </div>
            </div>
            @if($penilaian->hasil_prestasi)
            <span class="text-sm px-4 py-2 rounded-full font-semibold
                {{ $penilaian->hasil_prestasi === 'Amat Baik' ? 'bg-green-100 text-green-700' : ($penilaian->hasil_prestasi === 'Baik' ? 'bg-blue-100 text-blue-700' : ($penilaian->hasil_prestasi === 'Cukup' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">
                {{ $penilaian->hasil_prestasi }}
            </span>
            @endif
        </div>

        {{-- Nilai --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
            <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/30 rounded-xl">
                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Nilai</p>
                <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $penilaian->nilai }}</p>
            </div>
            <div class="text-center p-4 bg-green-50 dark:bg-green-900/30 rounded-xl">
                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Kehadiran</p>
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $penilaian->kehadiran }}%</p>
            </div>
            <div class="text-center p-4 bg-purple-50 dark:bg-purple-900/30 rounded-xl">
                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Keaktifan</p>
                <p class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $penilaian->keaktifan }}</p>
            </div>
            <div class="text-center p-4 bg-yellow-50 dark:bg-yellow-900/30 rounded-xl">
                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1">Sikap</p>
                <p class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $penilaian->sikap }}</p>
            </div>
        </div>

        {{-- Rule yang digunakan --}}
        <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-xl">
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Rule C4.5 yang Digunakan</p>
            <p class="text-sm font-mono text-gray-700 dark:text-gray-300">{{ $detail['rule'] }}</p>
        </div>

        {{-- Skor --}}
        <div class="mt-4 flex items-center justify-between">
            <span class="text-sm text-gray-500 dark:text-gray-400">Skor Total</span>
            <span class="text-lg font-bold text-gray-800 dark:text-white">{{ $penilaian->skor }}</span>
        </div>
    </div>
</div>

@endsection