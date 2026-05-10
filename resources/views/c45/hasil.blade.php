@extends('layouts.app')

@section('title', 'Hasil Proses C4.5')

@section('content')

<div class="mb-6 flex items-center justify-between">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Hasil Proses C4.5</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Hasil perhitungan lengkap algoritma C4.5</p>
    </div>
    <a href="{{ route('c45.index') }}" class="btn-secondary inline-flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        <span>Kembali</span>
    </a>
</div>

{{-- Summary --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center">
        <p class="text-sm text-gray-500 dark:text-gray-400">Total Data Diproses</p>
        <p class="text-4xl font-bold text-blue-600 mt-2">{{ $hasil['total_data'] }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center">
        <p class="text-sm text-gray-500 dark:text-gray-400">Entropy Dataset</p>
        <p class="text-4xl font-bold text-purple-600 mt-2">{{ $hasil['entropy_total'] }}</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 text-center">
        <p class="text-sm text-gray-500 dark:text-gray-400">Atribut Root Node</p>
        <p class="text-3xl font-bold text-green-600 mt-2 capitalize">{{ $hasil['root_atribut'] }}</p>
    </div>
</div>

{{-- Tabel Information Gain --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Tabel Perhitungan Information Gain</h3>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Atribut</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Information Gain</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($hasil['gains'] as $atribut => $gain)
                <tr class="{{ $atribut === $hasil['root_atribut'] ? 'bg-green-50 dark:bg-green-900/20' : '' }}">
                    <td class="px-4 py-3 font-medium text-gray-800 dark:text-white capitalize">{{ $atribut }}</td>
                    <td class="px-4 py-3 text-gray-700 dark:text-gray-300">{{ $gain }}</td>
                    <td class="px-4 py-3">
                        @if($atribut === $hasil['root_atribut'])
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full font-medium">Root Node ⭐</span>
                        @else
                        <span class="text-xs text-gray-400">-</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

{{-- Rules --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
    <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Rules IF-THEN yang Dihasilkan</h3>
    <div class="space-y-3">
        @foreach($hasil['rules'] as $index => $rule)
        <div class="p-4 rounded-xl border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-gray-500">RULE {{ $index + 1 }}</span>
                <span class="text-xs px-2 py-0.5 rounded-full font-medium
                    {{ $rule['hasil'] === 'Amat Baik' ? 'badge-amat-baik' : ($rule['hasil'] === 'Baik' ? 'badge-baik' : ($rule['hasil'] === 'Cukup' ? 'badge-cukup' : 'badge-kurang')) }}">
                    {{ $rule['hasil'] }}
                </span>
            </div>
            <p class="text-sm font-mono text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                {{ $rule['rule'] }}
            </p>
        </div>
        @endforeach
    </div>
</div>

@endsection