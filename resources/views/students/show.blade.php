@extends('layouts.app')

@section('title', 'Detail Siswa')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('students.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Data Siswa
        </a>
    </div>

    {{-- Info Siswa --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
        <div class="flex items-center space-x-4 mb-6">
            <div class="w-16 h-16 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-2xl">
                {{ strtoupper(substr($student->nama, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $student->nama }}</h2>
                <p class="text-gray-500 dark:text-gray-400">{{ $student->kelas }}</p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Kelamin</p>
                <p class="font-medium text-gray-800 dark:text-white mt-1">
                    {{ $student->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                </p>
            </div>
            <div>
                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alamat</p>
                <p class="font-medium text-gray-800 dark:text-white mt-1">{{ $student->alamat ?? '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Riwayat Penilaian --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Riwayat Penilaian</h3>

        @forelse($penilaian as $item)
        <div class="border border-gray-100 dark:border-gray-700 rounded-lg p-4 mb-3">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ $item->semester }}</span>
                @if($item->hasil_prestasi)
                <span class="text-xs px-2 py-1 rounded-full font-medium
                    {{ $item->hasil_prestasi === 'Amat Baik' ? 'badge-amat-baik' : ($item->hasil_prestasi === 'Baik' ? 'badge-baik' : ($item->hasil_prestasi === 'Cukup' ? 'badge-cukup' : 'badge-kurang')) }}">
                    {{ $item->hasil_prestasi }}
                </span>
                @endif
            </div>
            <div class="grid grid-cols-4 gap-3">
                <div class="text-center p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Nilai</p>
                    <p class="font-bold text-gray-800 dark:text-white">{{ $item->nilai }}</p>
                </div>
                <div class="text-center p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Kehadiran</p>
                    <p class="font-bold text-gray-800 dark:text-white">{{ $item->kehadiran }}%</p>
                </div>
                <div class="text-center p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Keaktifan</p>
                    <p class="font-bold text-gray-800 dark:text-white">{{ $item->keaktifan }}</p>
                </div>
                <div class="text-center p-2 bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <p class="text-xs text-gray-500 dark:text-gray-400">Sikap</p>
                    <p class="font-bold text-gray-800 dark:text-white">{{ $item->sikap }}</p>
                </div>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-6">Belum ada data penilaian</p>
        @endforelse
    </div>
</div>

@endsection