@extends('layouts.app')

@section('title', 'Lihat Raport')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <a href="{{ route('raport.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>
    <a href="{{ route('raport.cetak', [$student, 'semester' => $semester]) }}"
       class="inline-flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
        </svg>
        <span>Cetak PDF</span>
    </a>
</div>

{{-- Info Siswa --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xl">
                {{ strtoupper(substr($student->nama, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-gray-800 dark:text-white">{{ $student->nama }}</h2>
                <p class="text-gray-500">Kelas {{ $student->kelas }} • {{ $semester }}</p>
            </div>
        </div>
        @if($penilaian && $penilaian->hasil_prestasi)
        <span class="text-sm px-4 py-2 rounded-full font-semibold
            {{ $penilaian->hasil_prestasi === 'Amat Baik' ? 'bg-green-100 text-green-700' : ($penilaian->hasil_prestasi === 'Baik' ? 'bg-blue-100 text-blue-700' : ($penilaian->hasil_prestasi === 'Cukup' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">
            {{ $penilaian->hasil_prestasi }}
        </span>
        @endif
    </div>
</div>

{{-- Filter Semester --}}
@if($semesters->count() > 0)
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-6">
    <form action="{{ route('raport.show', $student) }}" method="GET" class="flex gap-3">
        <select name="semester" class="input-field sm:w-64">
            @foreach($semesters as $sem)
            <option value="{{ $sem }}" {{ $semester === $sem ? 'selected' : '' }}>{{ $sem }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-primary px-6">Lihat</button>
    </form>
</div>
@endif

{{-- Tabel Raport --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
        <h3 class="font-semibold text-gray-800 dark:text-white">Nilai Raport - {{ $semester }}</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Mata Pelajaran</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">KKM</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Harian</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">UTS</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">UAS</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Nilai Akhir</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($raport as $index => $r)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                    <td class="px-6 py-4 text-gray-500">{{ $index + 1 }}</td>
                    <td class="px-6 py-4">
                        <p class="font-medium text-gray-800 dark:text-white">{{ $r->mataPelajaran->nama }}</p>
                        <span class="text-xs text-gray-400">{{ $r->mataPelajaran->kode }}</span>
                    </td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $r->mataPelajaran->kkm }}</td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $r->nilai_harian }}</td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $r->nilai_uts }}</td>
                    <td class="px-6 py-4 text-center text-gray-600">{{ $r->nilai_uas }}</td>
                    <td class="px-6 py-4 text-center font-bold
                        {{ $r->nilai_akhir >= $r->mataPelajaran->kkm ? 'text-green-600' : 'text-red-600' }}">
                        {{ $r->nilai_akhir }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-xs px-2 py-1 rounded-full font-medium
                            {{ $r->nilai_akhir >= $r->mataPelajaran->kkm ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $r->nilai_akhir >= $r->mataPelajaran->kkm ? 'Tuntas' : 'Belum Tuntas' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="px-6 py-12 text-center text-gray-500">
                        Belum ada nilai raport untuk semester ini
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($raport->count() > 0)
            <tfoot class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <td colspan="6" class="px-6 py-3 text-right font-semibold text-gray-700 dark:text-gray-300">Rata-rata</td>
                    <td class="px-6 py-3 text-center font-bold text-blue-600">
                        {{ number_format($raport->avg('nilai_akhir'), 2) }}
                    </td>
                    <td></td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>
</div>

@endsection