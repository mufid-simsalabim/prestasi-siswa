@extends('layouts.app')

@section('title', 'Hasil Klasifikasi')

@section('content')

{{-- Statistik --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 border-l-4 border-green-500">
        <p class="text-sm text-gray-500 dark:text-gray-400">Amat Baik</p>
        <p class="text-3xl font-bold text-green-600 mt-1">{{ $statistik['amat_baik'] }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500 dark:text-gray-400">Baik</p>
        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $statistik['baik'] }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 border-l-4 border-yellow-500">
        <p class="text-sm text-gray-500 dark:text-gray-400">Cukup</p>
        <p class="text-3xl font-bold text-yellow-600 mt-1">{{ $statistik['cukup'] }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 border-l-4 border-red-500">
        <p class="text-sm text-gray-500 dark:text-gray-400">Kurang</p>
        <p class="text-3xl font-bold text-red-600 mt-1">{{ $statistik['kurang'] }}</p>
    </div>
</div>

{{-- Filter Semester --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-6">
    <form action="{{ route('penilaian.hasil') }}" method="GET">
        <div class="flex flex-col sm:flex-row gap-3">
            <select name="semester" class="input-field sm:w-64">
                <option value="">-- Semua Semester --</option>
                @foreach($semesters as $sem)
                <option value="{{ $sem }}" {{ $semester === $sem ? 'selected' : '' }}>{{ $sem }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary px-6">Filter</button>
            @if($semester)
            <a href="{{ route('penilaian.hasil') }}" class="btn-secondary px-4">Reset</a>
            @endif
            <a href="{{ route('penilaian.export-pdf', ['semester' => $semester]) }}"
               class="inline-flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 ml-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Export PDF</span>
            </a>
        </div>
    </form>
</div>

{{-- Tabel Hasil --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white">Hasil Klasifikasi Siswa</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Rank</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nilai</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kehadiran</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Keaktifan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sikap</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Skor</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Prestasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($penilaian as $index => $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                    <td class="px-6 py-4">
                        <span class="w-7 h-7 rounded-full flex items-center justify-center text-xs font-bold
                            {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : ($index === 1 ? 'bg-gray-300 text-gray-700' : ($index === 2 ? 'bg-orange-400 text-orange-900' : 'bg-gray-100 text-gray-600')) }}">
                            {{ $penilaian->firstItem() + $index }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800 dark:text-white">{{ $item->student->nama }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg text-xs font-semibold">
                            Kelas {{ $item->student->kelas }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $item->nilai }}</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $item->kehadiran }}%</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $item->keaktifan }}</td>
                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300">{{ $item->sikap }}</td>
                    <td class="px-6 py-4 font-semibold text-gray-800 dark:text-white">{{ $item->skor }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded-full font-medium
                            {{ $item->hasil_prestasi === 'Amat Baik' ? 'badge-amat-baik' : ($item->hasil_prestasi === 'Baik' ? 'badge-baik' : ($item->hasil_prestasi === 'Cukup' ? 'badge-cukup' : 'badge-kurang')) }}">
                            {{ $item->hasil_prestasi }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                        Belum ada data hasil klasifikasi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($penilaian->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
        {{ $penilaian->appends(['semester' => $semester])->links() }}
    </div>
    @endif
</div>

@endsection