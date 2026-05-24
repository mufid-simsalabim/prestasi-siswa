@extends('layouts.app')

@section('title', 'Ranking Per Angkatan')

@section('content')

<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Ranking Per Angkatan</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400">Top 3 siswa terbaik per angkatan dan detail ranking</p>
</div>

{{-- Filter --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-6">
    <form action="{{ route('ranking.angkatan') }}" method="GET">
        <div class="flex flex-col sm:flex-row gap-3">
            <select name="tingkat" class="input-field sm:w-48">
                <option value="">-- Semua Angkatan --</option>
                @for($i = 1; $i <= 6; $i++)
                <option value="{{ $i }}" {{ $tingkat == $i ? 'selected' : '' }}>Angkatan Kelas {{ $i }}</option>
                @endfor
            </select>
            <select name="semester" class="input-field sm:w-64">
                <option value="">-- Semua Semester --</option>
                @foreach($semesters as $sem)
                <option value="{{ $sem }}" {{ $semester === $sem ? 'selected' : '' }}>{{ $sem }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary px-6">Filter</button>
            @if($semester || $tingkat)
            <a href="{{ route('ranking.angkatan') }}" class="btn-secondary px-4">Reset</a>
            @endif
        </div>
    </form>
</div>

{{-- Top 3 Per Angkatan --}}
@if(!$tingkat)
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    @forelse($rankingAngkatan as $t => $juara)
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
            <h3 class="text-white font-bold">Angkatan Kelas {{ $t }}</h3>
            <p class="text-purple-200 text-xs">Kelas {{ $t }}-A, {{ $t }}-B, {{ $t }}-C</p>
        </div>
        <div class="p-4 space-y-3">
            @foreach($juara as $rank => $item)
            <div class="flex items-center space-x-3 p-2 rounded-lg
                {{ $rank === 0 ? 'bg-yellow-50 dark:bg-yellow-900/20' : ($rank === 1 ? 'bg-gray-50 dark:bg-gray-700' : 'bg-orange-50 dark:bg-orange-900/20') }}">
                <span class="text-xl">{{ ['🥇','🥈','🥉'][$rank] }}</span>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-800 dark:text-white text-sm truncate">{{ $item->student->nama }}</p>
                    <p class="text-xs text-gray-500">Kelas {{ $item->student->kelas }} • {{ $item->skor }}</p>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full font-medium
                    {{ $item->hasil_prestasi === 'Amat Baik' ? 'badge-amat-baik' : ($item->hasil_prestasi === 'Baik' ? 'badge-baik' : ($item->hasil_prestasi === 'Cukup' ? 'badge-cukup' : 'badge-kurang')) }}">
                    {{ $item->hasil_prestasi }}
                </span>
            </div>
            @endforeach
            <a href="{{ route('ranking.angkatan', ['tingkat' => $t, 'semester' => $semester]) }}"
               class="block text-center text-xs text-blue-600 hover:text-blue-700 font-medium mt-2">
                Lihat semua →
            </a>
        </div>
    </div>
    @empty
    <div class="col-span-3 text-center py-12 bg-white dark:bg-gray-800 rounded-xl shadow">
        <p class="text-gray-500">Belum ada data ranking angkatan</p>
    </div>
    @endforelse
</div>
@endif

{{-- Detail Ranking Angkatan Tertentu --}}
@if($tingkat && $rankingDetail)
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
        <h3 class="font-semibold text-gray-800 dark:text-white">
            Detail Ranking Angkatan Kelas {{ $tingkat }}
            ({{ $rankingDetail->count() }} siswa)
        </h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Peringkat</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Skor</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Prestasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($rankingDetail as $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150
                    {{ $item->rank <= 3 ? 'bg-yellow-50 dark:bg-yellow-900/10' : '' }}">
                    <td class="px-6 py-4">
                        @if($item->rank === 1)
                        <span class="text-2xl">🥇</span>
                        @elseif($item->rank === 2)
                        <span class="text-2xl">🥈</span>
                        @elseif($item->rank === 3)
                        <span class="text-2xl">🥉</span>
                        @else
                        <span class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-sm font-bold text-gray-600">
                            {{ $item->rank }}
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold text-xs">
                                {{ strtoupper(substr($item->student->nama, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-800 dark:text-white">{{ $item->student->nama }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900 text-purple-700 dark:text-purple-300 rounded-lg text-xs font-semibold">
                            Kelas {{ $item->student->kelas }}
                        </span>
                    </td>
                    <td class="px-6 py-4 font-bold text-gray-800 dark:text-white">{{ $item->skor }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded-full font-medium
                            {{ $item->hasil_prestasi === 'Amat Baik' ? 'badge-amat-baik' : ($item->hasil_prestasi === 'Baik' ? 'badge-baik' : ($item->hasil_prestasi === 'Cukup' ? 'badge-cukup' : 'badge-kurang')) }}">
                            {{ $item->hasil_prestasi }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection