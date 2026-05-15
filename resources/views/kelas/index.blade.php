@extends('layouts.app')

@section('title', 'Data Kelas')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Data Kelas</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data kelas dan wali kelas</p>
    </div>
    <a href="{{ route('kelas.create') }}" class="btn-primary inline-flex items-center space-x-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        <span>Tambah Kelas</span>
    </a>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tingkat</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Wali Kelas</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tahun Ajaran</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Jumlah Siswa</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($kelas as $index => $k)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                    <td class="px-6 py-4 text-gray-500">{{ $kelas->firstItem() + $index }}</td>
                    <td class="px-6 py-4">
                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-bold">
                            Kelas {{ $k->nama }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">Kelas {{ $k->tingkat }}</td>
                    <td class="px-6 py-4">
                        @if($k->waliKelas)
                        <div class="flex items-center space-x-2">
                            <div class="w-7 h-7 rounded-full bg-purple-600 flex items-center justify-center text-white text-xs font-bold">
                                {{ strtoupper(substr($k->waliKelas->name, 0, 1)) }}
                            </div>
                            <span class="text-gray-700 dark:text-gray-300 text-sm">{{ $k->waliKelas->name }}</span>
                        </div>
                        @else
                        <span class="text-gray-400 text-xs italic">Belum ada wali kelas</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $k->tahun_ajaran }}/{{ $k->tahun_ajaran + 1 }}</td>
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800 dark:text-white">
                            {{ $k->siswa()->count() }}
                        </span>
                        <span class="text-gray-400 text-xs ml-1">siswa</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('kelas.show', $k) }}"
                               class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 transition duration-150" title="Detail">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('kelas.edit', $k) }}"
                               class="p-1.5 rounded-lg text-yellow-600 hover:bg-yellow-50 transition duration-150" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('kelas.destroy', $k) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus kelas ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 rounded-lg text-red-600 hover:bg-red-50 transition duration-150">
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
                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">Belum ada data kelas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($kelas->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">{{ $kelas->links() }}</div>
    @endif
</div>

@endsection