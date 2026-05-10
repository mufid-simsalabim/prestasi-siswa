@extends('layouts.app')

@section('title', 'Data Penilaian')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Data Penilaian</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data penilaian siswa</p>
    </div>
    <a href="{{ route('penilaian.create') }}" class="btn-primary inline-flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Input Penilaian</span>
    </a>
</div>

{{-- Search & Filter --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-6">
    <form action="{{ route('penilaian.index') }}" method="GET">
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari nama siswa..."
                   class="input-field flex-1">
            <select name="semester" class="input-field sm:w-56">
                <option value="">-- Semua Semester --</option>
                @foreach($semesters as $sem)
                <option value="{{ $sem }}" {{ $semester === $sem ? 'selected' : '' }}>{{ $sem }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary px-6">Filter</button>
            @if($search || $semester)
            <a href="{{ route('penilaian.index') }}" class="btn-secondary px-4">Reset</a>
            @endif
        </div>
    </form>
</div>

{{-- Tabel --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nilai</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kehadiran</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Keaktifan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Sikap</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Semester</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Hasil</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($penilaian as $index => $item)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                        {{ $penilaian->firstItem() + $index }}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                {{ strtoupper(substr($item->student->nama, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-medium text-gray-800 dark:text-white">{{ $item->student->nama }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $item->student->kelas }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800 dark:text-white">{{ $item->nilai }}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $item->kehadiran }}%</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $item->keaktifan }}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $item->sikap }}</td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $item->semester }}</td>
                    <td class="px-6 py-4">
                        @if($item->hasil_prestasi)
                        <span class="text-xs px-2 py-1 rounded-full font-medium
                            {{ $item->hasil_prestasi === 'Amat Baik' ? 'badge-amat-baik' : ($item->hasil_prestasi === 'Baik' ? 'badge-baik' : ($item->hasil_prestasi === 'Cukup' ? 'badge-cukup' : 'badge-kurang')) }}">
                            {{ $item->hasil_prestasi }}
                        </span>
                        @else
                        <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('penilaian.show', $item) }}"
                               class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 transition duration-150"
                               title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('penilaian.edit', $item) }}"
                               class="p-1.5 rounded-lg text-yellow-600 hover:bg-yellow-50 dark:hover:bg-yellow-900 transition duration-150"
                               title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('penilaian.destroy', $item) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus data penilaian ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900 transition duration-150"
                                        title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="font-medium">Belum ada data penilaian</p>
                        <p class="text-sm mt-1">Klik tombol Input Penilaian untuk memulai</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($penilaian->hasPages())
    <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
        {{ $penilaian->appends(['search' => $search, 'semester' => $semester])->links() }}
    </div>
    @endif
</div>

@endsection