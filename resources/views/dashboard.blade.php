@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Statistik Card --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

    {{-- Total Siswa --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ $user->isGuru() ? 'Siswa Kelas ' . $user->kelas : 'Total Siswa' }}
                </p>
                <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalSiswa }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
            {{ $user->isGuru() ? 'Di kelas Anda' : 'Terdaftar dalam sistem' }}
        </p>
    </div>

    {{-- Total Penilaian --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Penilaian</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalPenilaian }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Data telah diinput</p>
    </div>

    {{-- Total Guru / Kelas --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">
                    {{ $user->isGuru() ? 'Kelas Saya' : 'Total Guru' }}
                </p>
                <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1">
                    {{ $user->isGuru() ? $user->kelas : $totalGuru }}
                </p>
            </div>
            <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
            {{ $user->isGuru() ? 'Wali kelas Anda' : 'Aktif mengajar' }}
        </p>
    </div>

    {{-- Total Rules --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Rules</p>
                <p class="text-3xl font-bold text-gray-800 dark:text-white mt-1">{{ $totalRules }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                </svg>
            </div>
        </div>
        <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Rule IF-THEN C4.5</p>
    </div>

</div>

{{-- Grafik --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    {{-- Grafik Prestasi --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">
            Grafik Kategori Prestasi
            @if($user->isGuru())
            <span class="text-xs font-normal text-gray-500 ml-1">(Kelas {{ $user->kelas }})</span>
            @endif
        </h3>
        <div class="relative h-64">
            <canvas id="grafikPrestasi"></canvas>
        </div>
    </div>

    {{-- Grafik Kelas --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">
            {{ $user->isGuru() ? 'Jumlah Siswa Kelas ' . $user->kelas : 'Grafik Siswa per Kelas' }}
        </h3>
        <div class="relative h-64">
            <canvas id="grafikKelas"></canvas>
        </div>
    </div>

</div>

{{-- Ranking & Aktivitas Terbaru --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Ranking Siswa --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white">
                Top 5 Ranking
                @if($user->isGuru())
                <span class="text-xs font-normal text-gray-500">(Kelas {{ $user->kelas }})</span>
                @endif
            </h3>
            <a href="{{ route('ranking.kelas') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium">Lihat semua</a>
        </div>
        <div class="space-y-3">
            @forelse($rankingSiswa as $index => $item)
            <div class="flex items-center space-x-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold
                    {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : ($index === 1 ? 'bg-gray-300 text-gray-700' : ($index === 2 ? 'bg-orange-400 text-orange-900' : 'bg-blue-100 text-blue-700')) }}">
                    {{ $index + 1 }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $item->student->nama }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Kelas {{ $item->student->kelas }}</p>
                </div>
                <span class="text-xs font-semibold
                    {{ $item->hasil_prestasi === 'Amat Baik' ? 'text-green-600' : ($item->hasil_prestasi === 'Baik' ? 'text-blue-600' : ($item->hasil_prestasi === 'Cukup' ? 'text-yellow-600' : 'text-red-600')) }}">
                    {{ $item->hasil_prestasi }}
                </span>
            </div>
            @empty
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Belum ada data penilaian</p>
            @endforelse
        </div>
    </div>

    {{-- Penilaian Terbaru --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-semibold text-gray-800 dark:text-white">Penilaian Terbaru</h3>
            @if($user->isGuru())
            <a href="{{ route('penilaian.index') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium">Input penilaian</a>
            @else
            @if(auth()->user()->isAdmin())
<a href="{{ route('penilaian.hasil') }}"
@else
<a href="{{ route('guru.hasil') }}"
@endif class="text-xs text-blue-600 hover:text-blue-700 font-medium">Lihat semua</a>
            @endif
        </div>
        <div class="space-y-3">
            @forelse($penilaianTerbaru as $item)
            <div class="flex items-center space-x-3 p-3 rounded-lg bg-gray-50 dark:bg-gray-700">
                <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr($item->student->nama, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-white truncate">{{ $item->student->nama }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->semester }} • Kelas {{ $item->student->kelas }}</p>
                </div>
                @if($item->hasil_prestasi)
                <span class="text-xs px-2 py-1 rounded-full font-medium
                    {{ $item->hasil_prestasi === 'Amat Baik' ? 'bg-green-100 text-green-700' : ($item->hasil_prestasi === 'Baik' ? 'bg-blue-100 text-blue-700' : ($item->hasil_prestasi === 'Cukup' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">
                    {{ $item->hasil_prestasi }}
                </span>
                @endif
            </div>
            @empty
            <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">Belum ada aktivitas</p>
            @endforelse
        </div>
    </div>

</div>

@endsection

@push('scripts')
<script>
const grafikPrestasiData = @json($grafikPrestasi);
const grafikKelasData    = @json($grafikKelas);

// Grafik Prestasi
const ctxPrestasi = document.getElementById('grafikPrestasi').getContext('2d');
new Chart(ctxPrestasi, {
    type: 'doughnut',
    data: {
        labels: Object.keys(grafikPrestasiData).length > 0 ? Object.keys(grafikPrestasiData) : ['Belum ada data'],
        datasets: [{
            data: Object.values(grafikPrestasiData).length > 0 ? Object.values(grafikPrestasiData) : [1],
            backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
            borderWidth: 0,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { position: 'bottom', labels: { padding: 15, font: { size: 12 } } }
        }
    }
});

// Grafik Kelas
const ctxKelas = document.getElementById('grafikKelas').getContext('2d');
new Chart(ctxKelas, {
    type: 'bar',
    data: {
        labels: Object.keys(grafikKelasData),
        datasets: [{
            label: 'Jumlah Siswa',
            data: Object.values(grafikKelasData),
            backgroundColor: '#3b82f6',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { stepSize: 1 } },
            x: { grid: { display: false } }
        }
    }
});
</script>
@endpush