@extends('layouts.app')

@section('title', 'E-Raport')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">E-Raport Siswa</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            @if(auth()->user()->isGuru())
            Kelas {{ auth()->user()->kelas }}
            @else
            Seluruh Siswa
            @endif
        </p>
    </div>
</div>

{{-- Search --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-6">
    <form action="{{ route('raport.index') }}" method="GET">
        <div class="flex gap-3">
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari nama siswa..."
                   class="input-field flex-1">
            <button type="submit" class="btn-primary px-6">Cari</button>
            @if($search)
            <a href="{{ route('raport.index') }}" class="btn-secondary px-4">Reset</a>
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
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Nama Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Prestasi</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($students as $index => $student)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                    <td class="px-6 py-4 text-gray-500">{{ $students->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
                                {{ strtoupper(substr($student->nama, 0, 1)) }}
                            </div>
                            <span class="font-medium text-gray-800 dark:text-white">{{ $student->nama }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-semibold">
                            Kelas {{ $student->kelas }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        @if($student->penilaianTerbaru && $student->penilaianTerbaru->hasil_prestasi)
                        <span class="text-xs px-2 py-1 rounded-full font-medium
                            {{ $student->penilaianTerbaru->hasil_prestasi === 'Amat Baik' ? 'badge-amat-baik' : ($student->penilaianTerbaru->hasil_prestasi === 'Baik' ? 'badge-baik' : ($student->penilaianTerbaru->hasil_prestasi === 'Cukup' ? 'badge-cukup' : 'badge-kurang')) }}">
                            {{ $student->penilaianTerbaru->hasil_prestasi }}
                        </span>
                        @else
                        <span class="text-xs text-gray-400">Belum dinilai</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('raport.input', $student) }}"
                               class="inline-flex items-center space-x-1 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-xs font-medium transition duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                <span>Input Nilai</span>
                            </a>
                            <a href="{{ route('raport.show', $student) }}"
                               class="inline-flex items-center space-x-1 px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-xs font-medium transition duration-150">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                                <span>Lihat Raport</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                        <p class="font-medium">Belum ada data siswa</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($students->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">{{ $students->links() }}</div>
    @endif
</div>

@endsection