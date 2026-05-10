<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
</head>
<body class="bg-gradient-to-br from-blue-900 via-blue-800 to-blue-700 min-h-screen flex items-center justify-center font-sans">
    <div class="text-center px-4">
        <h1 class="text-9xl font-bold text-white/20">404</h1>
        <h2 class="text-2xl font-bold text-white mt-4">Halaman Tidak Ditemukan</h2>
        <p class="text-blue-200 mt-2 mb-8">Halaman yang kamu cari tidak ada atau sudah dipindahkan.</p>
        <a href="{{ url('/dashboard') }}"
           class="inline-flex items-center space-x-2 bg-white text-blue-900 font-semibold py-3 px-6 rounded-xl hover:bg-blue-50 transition duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>
</body>
</html>