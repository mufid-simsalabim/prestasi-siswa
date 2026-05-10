@extends('layouts.app')

@section('title', 'Ranking Siswa')

@section('content')

<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Ranking Siswa</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Peringkat siswa berdasarkan skor total C4.5</p>
    </div>
</div>

{{-- Filter Semester --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-6">
    <form action="{{ route('penilaian.ranking') }}" method="GET">
        <div class="flex flex-col sm:flex-row gap-3">
            <select name="semester" class="input-field sm:w-64">
                <option value="">-- Semua Semester --</option>
                @foreach($semesters as $sem)
                <option value="{{ $sem }}" {{ $semester === $sem ? 'selected' : '' }}>{{ $sem }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary px-6">Filter</button>
            @if($semester)
            <a href="{{ route('penilaian.ranking') }}" class="btn-secondary px-4">Reset</a>
            @endif
        </div>
    </form>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Peringkat</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Semester</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Skor</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Prestasi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($ranking as $index => $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150
                    {{ $index === 0 ? 'bg-yellow-50 dark:bg-yellow-900/20' : '' }}">
                    <td class="px-6 py-4">
                        @if($ranking->firstItem() + $index === 1)
                        <span class="text-2xl">🥇</span>
                        @elseif($ranking->firstItem() + $index === 2)
                        <span class="text-2xl">🥈</span>
                        @elseif($ranking->firstItem() + $index === 3)
                        <span class="text-2xl">🥉</span>
                        @else
                        <span class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-sm font-bold text-gray-600 dark:text-gray-300">
                            {{ $ranking->firstItem() + $index }}
                        </span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
                                {{ strtoupper(substr($item->student->nama, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-800 dark:text-white">{{ $item->student->nama }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg text-xs font-semibold">
                            Kelas {{ $item->student->kelas }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $item->semester }}</td>
                    <td class="px-6 py-4 font-bold text-gray-800 dark:text-white">{{ $item->skor }}</td>
                    <td class="px-6 py-4">
                        <span class="text-xs px-2 py-1 rounded-full font-medium
                            {{ $item->hasil_prestasi === 'Amat Baik' ? 'badge-amat-baik' : ($item->hasil_prestasi === 'Baik' ? 'badge-baik' : ($item->hasil_prestasi === 'Cukup' ? 'badge-cukup' : 'badge-kurang')) }}">
                            {{ $item->hasil_prestasi }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                        Belum ada data ranking
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($ranking->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
        {{ $ranking->appends(['semester' => $semester])->links() }}
    </div>
    @endif
</div>

@endsection