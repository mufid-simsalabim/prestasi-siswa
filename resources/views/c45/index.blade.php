@extends('layouts.app')

@section('title', 'Proses C4.5')

@section('content')

<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-800 dark:text-white">Proses Algoritma C4.5</h2>
    <p class="text-sm text-gray-500 dark:text-gray-400">Perhitungan Entropy, Information Gain, dan Decision Tree</p>
</div>

@if(isset($hasil['error']))
<div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 rounded-xl p-6 mb-6">
    <p class="text-red-700 dark:text-red-300">{{ $hasil['error'] }}</p>
</div>
@else

{{-- Statistik C4.5 --}}
<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-blue-500">
        <p class="text-sm text-gray-500 dark:text-gray-400">Total Data</p>
        <p class="text-3xl font-bold text-blue-600 mt-1">{{ $hasil['total_data'] }}</p>
        <p class="text-xs text-gray-400 mt-1">Data penilaian</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-purple-500">
        <p class="text-sm text-gray-500 dark:text-gray-400">Entropy Total</p>
        <p class="text-3xl font-bold text-purple-600 mt-1">{{ $hasil['entropy_total'] }}</p>
        <p class="text-xs text-gray-400 mt-1">Nilai entropy dataset</p>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-l-4 border-green-500">
        <p class="text-sm text-gray-500 dark:text-gray-400">Root Node</p>
        <p class="text-2xl font-bold text-green-600 mt-1 capitalize">{{ $hasil['root_atribut'] }}</p>
        <p class="text-xs text-gray-400 mt-1">Atribut dengan gain tertinggi</p>
    </div>
</div>

{{-- Information Gain --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Information Gain Tiap Atribut</h3>
        <div class="space-y-4">
            @foreach($hasil['gains'] as $atribut => $gain)
            <div>
                <div class="flex justify-between items-center mb-1">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300 capitalize">{{ $atribut }}</span>
                    <span class="text-sm font-bold text-gray-800 dark:text-white">{{ $gain }}</span>
                </div>
                <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2">
                    <div class="h-2 rounded-full
                        {{ $atribut === $hasil['root_atribut'] ? 'bg-green-500' : 'bg-blue-400' }}"
                        style="width: {{ $hasil['entropy_total'] > 0 ? min(100, ($gain / $hasil['entropy_total']) * 100) : 0 }}%">
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Distribusi Kelas --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Distribusi Kelas Prestasi</h3>
        <div class="space-y-3">
            @foreach($hasil['distribusi'] as $kelas => $jumlah)
            <div class="flex items-center justify-between p-3 rounded-lg
                {{ $kelas === 'Amat Baik' ? 'bg-green-50 dark:bg-green-900/30' : ($kelas === 'Baik' ? 'bg-blue-50 dark:bg-blue-900/30' : ($kelas === 'Cukup' ? 'bg-yellow-50 dark:bg-yellow-900/30' : 'bg-red-50 dark:bg-red-900/30')) }}">
                <span class="text-sm font-medium
                    {{ $kelas === 'Amat Baik' ? 'text-green-700 dark:text-green-300' : ($kelas === 'Baik' ? 'text-blue-700 dark:text-blue-300' : ($kelas === 'Cukup' ? 'text-yellow-700 dark:text-yellow-300' : 'text-red-700 dark:text-red-300')) }}">
                    {{ $kelas }}
                </span>
                <span class="text-lg font-bold
                    {{ $kelas === 'Amat Baik' ? 'text-green-700 dark:text-green-300' : ($kelas === 'Baik' ? 'text-blue-700 dark:text-blue-300' : ($kelas === 'Cukup' ? 'text-yellow-700 dark:text-yellow-300' : 'text-red-700 dark:text-red-300')) }}">
                    {{ $jumlah }}
                </span>
            </div>
            @endforeach
        </div>

        {{-- Grafik Distribusi --}}
        <div class="mt-4 relative h-40">
            <canvas id="grafikDistribusi"></canvas>
        </div>
    </div>
</div>

{{-- Rules IF-THEN --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
    <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Rules IF-THEN Decision Tree C4.5</h3>
    <div class="space-y-3">
        @foreach($hasil['rules'] as $index => $rule)
        <div class="p-4 rounded-xl border-l-4
            {{ $rule['hasil'] === 'Amat Baik' ? 'border-green-500 bg-green-50 dark:bg-green-900/20' : ($rule['hasil'] === 'Baik' ? 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' : ($rule['hasil'] === 'Cukup' ? 'border-yellow-500 bg-yellow-50 dark:bg-yellow-900/20' : 'border-red-500 bg-red-50 dark:bg-red-900/20')) }}">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">RULE {{ $index + 1 }}</span>
                <span class="text-xs px-2 py-0.5 rounded-full font-medium
                    {{ $rule['hasil'] === 'Amat Baik' ? 'badge-amat-baik' : ($rule['hasil'] === 'Baik' ? 'badge-baik' : ($rule['hasil'] === 'Cukup' ? 'badge-cukup' : 'badge-kurang')) }}">
                    {{ $rule['hasil'] }}
                </span>
            </div>
            <p class="text-sm font-mono text-gray-700 dark:text-gray-300">{{ $rule['rule'] }}</p>
        </div>
        @endforeach
    </div>
</div>

{{-- Tombol Proses --}}
<div class="text-center">
    <a href="{{ route('c45.proses') }}"
       class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-xl transition duration-200 shadow-lg">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>Jalankan Proses C4.5</span>
    </a>
</div>

@endif

@endsection

@push('scripts')
<script>
@if(!isset($hasil['error']))
const distribusiData = @json($hasil['distribusi']);
const ctx = document.getElementById('grafikDistribusi');
if (ctx) {
    new Chart(ctx.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: Object.keys(distribusiData),
            datasets: [{
                data: Object.values(distribusiData),
                backgroundColor: ['#10b981', '#3b82f6', '#f59e0b', '#ef4444'],
                borderWidth: 0,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: { padding: 10, font: { size: 11 } }
                }
            }
        }
    });
}
@endif
</script>
@endpush