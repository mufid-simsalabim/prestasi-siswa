@extends('layouts.app')

@section('title', 'Detail Kelas')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('kelas.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>
</div>

{{-- Info Kelas --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex items-center space-x-4">
        <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center">
            <span class="text-white font-bold text-2xl">{{ $kela->nama }}</span>
        </div>
        <div>
            <h2 class="text-xl font-bold text-gray-800 dark:text-white">Kelas {{ $kela->nama }}</h2>
            <p class="text-gray-500">Tahun Ajaran {{ $kela->tahun_ajaran }}/{{ $kela->tahun_ajaran + 1 }}</p>
            @if($kela->waliKelas)
            <p class="text-sm text-blue-600">Wali Kelas: {{ $kela->waliKelas->name }}</p>
            @endif
        </div>
    </div>
</div>

{{-- Daftar Siswa --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
        <h3 class="font-semibold text-gray-800 dark:text-white">Daftar Siswa ({{ $siswa->count() }} siswa)</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jenis Kelamin</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Prestasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($siswa as $index => $s)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
                                {{ strtoupper(substr($s->nama, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-800 dark:text-white">{{ $s->nama }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-full text-xs font-medium
                            {{ $s->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                            {{ $s->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($s->penilaianTerbaru && $s->penilaianTerbaru->hasil_prestasi)
                        <span class="text-xs px-2 py-1 rounded-full font-medium
                            {{ $s->penilaianTerbaru->hasil_prestasi === 'Amat Baik' ? 'badge-amat-baik' : ($s->penilaianTerbaru->hasil_prestasi === 'Baik' ? 'badge-baik' : ($s->penilaianTerbaru->hasil_prestasi === 'Cukup' ? 'badge-cukup' : 'badge-kurang')) }}">
                            {{ $s->penilaianTerbaru->hasil_prestasi }}
                        </span>
                        @else
                        <span class="text-xs text-gray-400">Belum dinilai</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">Belum ada siswa di kelas ini</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection