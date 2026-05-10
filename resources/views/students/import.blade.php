@extends('layouts.app')

@section('title', 'Import Siswa')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('students.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Data Siswa
        </a>
    </div>

    {{-- Form Import --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-2">Import Data Siswa</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Upload file Excel atau CSV untuk import data siswa secara massal</p>

        <form action="{{ route('students.import.post') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center hover:border-blue-400 transition duration-200">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pilih file Excel atau CSV</p>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Format: .xlsx, .xls, atau .csv (Maks. 2MB)</p>
                <input type="file" name="file" accept=".xlsx,.xls,.csv"
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                @error('file')<p class="mt-2 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-primary w-full">
                Import Data Siswa
            </button>
        </form>
    </div>

    {{-- Panduan Format --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-4">Format File yang Benar</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Pastikan file Excel/CSV kamu memiliki format kolom seperti berikut:</p>

        <div class="overflow-x-auto">
            <table class="w-full text-sm border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Kolom A</th>
                        <th class="px-4 py-2 text-left">Kolom B</th>
                        <th class="px-4 py-2 text-left">Kolom C</th>
                        <th class="px-4 py-2 text-left">Kolom D</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <td class="px-4 py-2 font-medium text-gray-700 dark:text-gray-300">nama</td>
                        <td class="px-4 py-2 font-medium text-gray-700 dark:text-gray-300">kelas</td>
                        <td class="px-4 py-2 font-medium text-gray-700 dark:text-gray-300">jenis_kelamin</td>
                        <td class="px-4 py-2 font-medium text-gray-700 dark:text-gray-300">alamat</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 text-gray-600 dark:text-gray-400">Ahmad Fauzi</td>
                        <td class="px-4 py-2 text-gray-600 dark:text-gray-400">1-A</td>
                        <td class="px-4 py-2 text-gray-600 dark:text-gray-400">L</td>
                        <td class="px-4 py-2 text-gray-600 dark:text-gray-400">Jl. Merdeka No. 1</td>
                    </tr>
                    <tr class="bg-gray-50 dark:bg-gray-700">
                        <td class="px-4 py-2 text-gray-600 dark:text-gray-400">Dewi Putri</td>
                        <td class="px-4 py-2 text-gray-600 dark:text-gray-400">1-B</td>
                        <td class="px-4 py-2 text-gray-600 dark:text-gray-400">P</td>
                        <td class="px-4 py-2 text-gray-600 dark:text-gray-400">Jl. Mawar No. 2</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4 p-4 bg-yellow-50 dark:bg-yellow-900/30 rounded-lg border border-yellow-200 dark:border-yellow-700">
            <p class="text-xs font-semibold text-yellow-700 dark:text-yellow-300 mb-2">⚠️ Perhatian:</p>
            <ul class="text-xs text-yellow-600 dark:text-yellow-400 space-y-1">
                <li>• Baris pertama adalah <strong>header</strong> (nama, kelas, jenis_kelamin, alamat)</li>
                <li>• Kolom <strong>jenis_kelamin</strong> diisi dengan <strong>L</strong> (Laki-laki) atau <strong>P</strong> (Perempuan)</li>
                <li>• Kolom <strong>kelas</strong> diisi dengan format <strong>1-A</strong>, <strong>2-B</strong>, dst</li>
                <li>• Kolom <strong>alamat</strong> boleh dikosongkan</li>
            </ul>
        </div>
    </div>

    {{-- Download Template --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white mb-2">Download Template</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Download template Excel untuk memudahkan pengisian data siswa</p>
        <a href="{{ route('students.template') }}"
           class="inline-flex items-center space-x-2 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
            </svg>
            <span>Download Template Excel</span>
        </a>
    </div>
</div>

@endsection