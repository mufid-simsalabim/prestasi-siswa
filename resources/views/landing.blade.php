<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pakar Prestasi Siswa - Madrasah Ibtidaiyah</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-hero {
            background: linear-gradient(135deg, #1e3a8a 0%, #1d4ed8 50%, #0ea5e9 100%);
        }
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .glass-dark {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="font-sans bg-gray-50">

{{-- NAVBAR --}}
<nav class="fixed top-0 left-0 right-0 z-50 bg-white/90 backdrop-blur-md shadow-sm border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            {{-- Logo --}}
            <div class="flex items-center space-x-3">
                <div class="w-9 h-9 bg-blue-900 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-blue-900 text-sm leading-tight">Sistem Pakar</p>
                    <p class="text-blue-600 text-xs">Prestasi Siswa MI</p>
                </div>
            </div>

            {{-- Menu Desktop --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="#home" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">Home</a>
                <a href="#tentang" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">Tentang</a>
                <a href="#prestasi" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">Prestasi</a>
                <a href="#ranking-kelas" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">Ranking Kelas</a>
                <a href="#ranking-angkatan" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">Ranking Angkatan</a>
            </div>

            {{-- Login Button --}}
            <a href="{{ route('login') }}"
               class="inline-flex items-center space-x-2 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-5 rounded-xl transition duration-200 text-sm shadow-md">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                <span>Login</span>
            </a>
        </div>
    </div>
</nav>

{{-- HERO SECTION --}}
<section id="home" class="gradient-hero min-h-screen flex items-center pt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <div class="inline-flex items-center space-x-2 glass rounded-full px-4 py-2 mb-6">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-white text-xs font-medium">Sistem Aktif & Berjalan</span>
                </div>
                <h1 class="text-4xl sm:text-5xl font-bold text-white leading-tight mb-6">
                    Sistem Pakar
                    <span class="text-yellow-400">Prestasi Akademik</span>
                    Siswa MI
                </h1>
                <p class="text-blue-100 text-lg mb-8 leading-relaxed">
                    Platform cerdas berbasis algoritma Decision Tree C4.5 untuk menentukan dan memantau prestasi akademik siswa Madrasah Ibtidaiyah secara otomatis dan akurat.
                </p>
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center space-x-2 bg-white text-blue-900 font-semibold py-3 px-8 rounded-xl transition duration-200 hover:bg-yellow-400 hover:text-blue-900 shadow-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                        </svg>
                        <span>Masuk ke Sistem</span>
                    </a>
                    <a href="#prestasi"
                       class="inline-flex items-center justify-center space-x-2 glass text-white font-semibold py-3 px-8 rounded-xl transition duration-200 hover:bg-white/20">
                        <span>Lihat Prestasi</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </a>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 gap-4">
                <div class="glass rounded-2xl p-6 card-hover animate-float">
                    <div class="text-4xl font-bold text-white mb-1">{{ $totalSiswa }}</div>
                    <div class="text-blue-200 text-sm">Total Siswa</div>
                    <div class="mt-3 w-8 h-1 bg-yellow-400 rounded"></div>
                </div>
                <div class="glass rounded-2xl p-6 card-hover" style="animation-delay: 0.5s">
                    <div class="text-4xl font-bold text-white mb-1">{{ $totalGuru }}</div>
                    <div class="text-blue-200 text-sm">Total Guru</div>
                    <div class="mt-3 w-8 h-1 bg-green-400 rounded"></div>
                </div>
                <div class="glass rounded-2xl p-6 card-hover" style="animation-delay: 1s">
                    <div class="text-4xl font-bold text-white mb-1">{{ $totalKelas }}</div>
                    <div class="text-blue-200 text-sm">Total Kelas</div>
                    <div class="mt-3 w-8 h-1 bg-pink-400 rounded"></div>
                </div>
                <div class="glass rounded-2xl p-6 card-hover" style="animation-delay: 1.5s">
                    <div class="text-4xl font-bold text-white mb-1">C4.5</div>
                    <div class="text-blue-200 text-sm">Algoritma</div>
                    <div class="mt-3 w-8 h-1 bg-purple-400 rounded"></div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TENTANG SISTEM --}}
<section id="tentang" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Tentang Sistem</h2>
            <p class="text-gray-500 max-w-2xl mx-auto">Sistem pakar berbasis kecerdasan buatan untuk membantu guru dan admin dalam menentukan prestasi akademik siswa secara objektif</p>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center p-8 rounded-2xl bg-blue-50 card-hover">
                <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Algoritma C4.5</h3>
                <p class="text-gray-500 text-sm">Menggunakan metode Decision Tree C4.5 untuk klasifikasi prestasi siswa secara otomatis dan akurat</p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-green-50 card-hover">
                <div class="w-16 h-16 bg-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">E-Raport Digital</h3>
                <p class="text-gray-500 text-sm">Sistem raport digital terintegrasi yang memudahkan guru dalam menginput dan mencetak nilai siswa</p>
            </div>
            <div class="text-center p-8 rounded-2xl bg-purple-50 card-hover">
                <div class="w-16 h-16 bg-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 mb-2">Ranking Otomatis</h3>
                <p class="text-gray-500 text-sm">Peringkat siswa dihitung otomatis per kelas dan per angkatan berdasarkan skor C4.5</p>
            </div>
        </div>
    </div>
</section>

{{-- TOP SISWA --}}
<section id="prestasi" class="py-20 bg-gradient-to-br from-blue-900 to-blue-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-white mb-4">🏆 Siswa Berprestasi</h2>
            <p class="text-blue-200">Top 10 siswa dengan prestasi terbaik di seluruh kelas</p>
        </div>

        @if($topSiswa->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($topSiswa as $index => $item)
            <div class="glass rounded-2xl p-5 card-hover">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold flex-shrink-0
                        {{ $index === 0 ? 'bg-yellow-400 text-yellow-900' : ($index === 1 ? 'bg-gray-300 text-gray-700' : ($index === 2 ? 'bg-orange-400 text-orange-900' : 'bg-blue-600 text-white')) }}">
                        {{ $index < 3 ? ['🥇','🥈','🥉'][$index] : ($index + 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-semibold text-white truncate">{{ $item->student->nama }}</p>
                        <p class="text-blue-200 text-xs">Kelas {{ $item->student->kelas }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-white font-bold text-sm">{{ $item->skor }}</p>
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                            {{ $item->hasil_prestasi === 'Amat Baik' ? 'bg-green-500 text-white' : ($item->hasil_prestasi === 'Baik' ? 'bg-blue-500 text-white' : ($item->hasil_prestasi === 'Cukup' ? 'bg-yellow-500 text-white' : 'bg-red-500 text-white')) }}">
                            {{ $item->hasil_prestasi }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12">
            <p class="text-blue-200">Belum ada data prestasi siswa</p>
        </div>
        @endif
    </div>
</section>

{{-- RANKING PER KELAS --}}
<section id="ranking-kelas" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">🎯 Juara Per Kelas</h2>
            <p class="text-gray-500">Top 3 siswa terbaik di masing-masing kelas</p>
        </div>

        @if(count($juaraKelas) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($juaraKelas as $kelas => $juara)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">Kelas {{ $kelas }}</h3>
                    <p class="text-blue-200 text-xs">{{ $juara->count() }} siswa berprestasi</p>
                </div>
                <div class="p-4 space-y-3">
                    @foreach($juara as $rank => $item)
                    <div class="flex items-center space-x-3 p-2 rounded-lg
                        {{ $rank === 0 ? 'bg-yellow-50' : ($rank === 1 ? 'bg-gray-50' : 'bg-orange-50') }}">
                        <span class="text-xl">{{ ['🥇','🥈','🥉'][$rank] }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-800 text-sm truncate">{{ $item->student->nama }}</p>
                            <p class="text-xs text-gray-500">Skor: {{ $item->skor }}</p>
                        </div>
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                            {{ $item->hasil_prestasi === 'Amat Baik' ? 'bg-green-100 text-green-700' : ($item->hasil_prestasi === 'Baik' ? 'bg-blue-100 text-blue-700' : ($item->hasil_prestasi === 'Cukup' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">
                            {{ $item->hasil_prestasi }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-white rounded-2xl shadow">
            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
            </svg>
            <p class="text-gray-500">Belum ada data ranking kelas</p>
            <p class="text-gray-400 text-sm mt-1">Data akan muncul setelah guru menginput penilaian</p>
        </div>
        @endif
    </div>
</section>

{{-- RANKING PER ANGKATAN --}}
<section id="ranking-angkatan" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">🏅 Juara Per Angkatan</h2>
            <p class="text-gray-500">Top 3 siswa terbaik di masing-masing angkatan (tingkat kelas)</p>
        </div>

        @if(count($juaraAngkatan) > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($juaraAngkatan as $tingkat => $juara)
            <div class="rounded-2xl overflow-hidden shadow-lg card-hover">
                <div class="bg-gradient-to-r from-purple-600 to-purple-700 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">Angkatan Kelas {{ $tingkat }}</h3>
                    <p class="text-purple-200 text-xs">Gabungan Kelas {{ $tingkat }}-A, {{ $tingkat }}-B, {{ $tingkat }}-C</p>
                </div>
                <div class="bg-white p-4 space-y-3">
                    @foreach($juara as $rank => $item)
                    <div class="flex items-center space-x-3 p-3 rounded-xl
                        {{ $rank === 0 ? 'bg-yellow-50 border border-yellow-200' : ($rank === 1 ? 'bg-gray-50 border border-gray-200' : 'bg-orange-50 border border-orange-200') }}">
                        <span class="text-2xl">{{ ['🥇','🥈','🥉'][$rank] }}</span>
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-800 truncate">{{ $item->student->nama }}</p>
                            <p class="text-xs text-gray-500">Kelas {{ $item->student->kelas }} • Skor: {{ $item->skor }}</p>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-full font-medium
                            {{ $item->hasil_prestasi === 'Amat Baik' ? 'bg-green-100 text-green-700' : ($item->hasil_prestasi === 'Baik' ? 'bg-blue-100 text-blue-700' : ($item->hasil_prestasi === 'Cukup' ? 'bg-yellow-100 text-yellow-700' : 'bg-red-100 text-red-700')) }}">
                            {{ $item->hasil_prestasi }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="text-center py-12 bg-gray-50 rounded-2xl">
            <p class="text-gray-500">Belum ada data ranking angkatan</p>
            <p class="text-gray-400 text-sm mt-1">Data akan muncul setelah guru menginput penilaian</p>
        </div>
        @endif
    </div>
</section>

{{-- FOOTER --}}
<footer class="bg-blue-900 py-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-900" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"/>
                    </svg>
                </div>
                <div>
                    <p class="text-white font-bold text-sm">Sistem Pakar Prestasi Siswa</p>
                    <p class="text-blue-300 text-xs">Madrasah Ibtidaiyah</p>
                </div>
            </div>
            <p class="text-blue-300 text-sm">&copy; {{ date('Y') }} Sistem Pakar Prestasi Siswa MI. All rights reserved.</p>
        </div>
    </div>
</footer>

</body>
</html>