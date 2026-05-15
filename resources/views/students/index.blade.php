@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')

{{-- Header --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Data Siswa</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola data seluruh siswa Madrasah Ibtidaiyah</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('students.import') }}" class="inline-flex items-center space-x-2 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
            </svg>
            <span>Import Excel</span>
        </a>
        <a href="{{ route('students.create') }}" class="btn-primary inline-flex items-center space-x-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Siswa</span>
        </a>
    </div>
</div>

{{-- Search & Filter --}}
<div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-6">
    <form action="{{ route('students.index') }}" method="GET">
        <div class="flex flex-col sm:flex-row gap-3">
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari nama siswa..."
                   class="input-field flex-1">
            <select name="kelas" class="input-field sm:w-48">
                <option value="">-- Semua Kelas --</option>
                @foreach($daftarKelas as $kelas)
                <option value="{{ $kelas }}" {{ $kelasFilter === $kelas ? 'selected' : '' }}>
                    Kelas {{ $kelas }}
                </option>
                @endforeach
            </select>
            <button type="submit" class="btn-primary px-6">Filter</button>
            @if($search || $kelasFilter)
            <a href="{{ route('students.index') }}" class="btn-secondary px-4">Reset</a>
            @endif
        </div>
    </form>
</div>

{{-- SATU FORM untuk semua aksi hapus --}}
<form id="formHapus" action="{{ route('students.destroy-selected') }}" method="POST">
    @csrf
    @method('DELETE')
    <input type="hidden" name="aksi" id="inputAksi" value="terpilih">

    {{-- Toolbar --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-4 mb-4 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span id="selectedCount" class="text-sm text-gray-500 dark:text-gray-400">
            Centang siswa untuk menandai
        </span>
        <div class="flex gap-2">
            {{-- Hapus Terpilih --}}
            <button type="button" id="btnHapusTerpilih"
                    onclick="hapusTerpilih()"
                    class="hidden inline-flex items-center space-x-2 bg-orange-500 hover:bg-orange-600 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <span>Hapus Terpilih</span>
            </button>
            {{-- Hapus Semua --}}
            <button type="button"
                    onclick="hapusSemua()"
                    class="inline-flex items-center space-x-2 bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 text-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
                <span>Hapus Semua</span>
            </button>
        </div>
    </div>

    {{-- Tabel --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 w-10"></th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Nama Siswa</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Kelamin</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Alamat</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($students as $index => $student)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150">
                        <td class="px-4 py-4">
                            <input type="checkbox" name="selected[]"
                                   value="{{ $student->id }}"
                                   class="checkbox-item w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                        </td>
                        <td class="px-6 py-4 text-gray-500 dark:text-gray-400">
                            {{ $students->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                                    {{ strtoupper(substr($student->nama, 0, 1)) }}
                                </div>
                                <span class="font-medium text-gray-800 dark:text-white">{{ $student->nama }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg text-xs font-semibold">
                                Kelas {{ $student->kelas }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                {{ $student->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300' : 'bg-pink-100 text-pink-700 dark:bg-pink-900 dark:text-pink-300' }}">
                                {{ $student->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300 max-w-xs truncate">
                            {{ $student->alamat ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-2">
                                <a href="{{ route('students.show', $student) }}"
                                   class="p-1.5 rounded-lg text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900 transition duration-150" title="Detail">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a href="{{ route('students.edit', $student) }}"
                                   class="p-1.5 rounded-lg text-yellow-600 hover:bg-yellow-50 dark:hover:bg-yellow-900 transition duration-150" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <button type="button"
                                        onclick="hapusSatu({{ $student->id }}, '{{ $student->nama }}')"
                                        class="p-1.5 rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900 transition duration-150" title="Hapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="font-medium">Tidak ada data siswa</p>
                            <p class="text-sm mt-1">Tambahkan siswa baru atau import dari Excel</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
            {{ $students->appends(['search' => $search, 'kelas' => $kelasFilter])->links() }}
        </div>
        @endif
    </div>

</form>

@endsection

@push('scripts')
<script>
const checkboxes = document.querySelectorAll('.checkbox-item');
const btnHapusTerpilih = document.getElementById('btnHapusTerpilih');
const selectedCount = document.getElementById('selectedCount');
const formHapus = document.getElementById('formHapus');
const inputAksi = document.getElementById('inputAksi');

// Update jumlah yang dipilih
function updateSelected() {
    const checked = document.querySelectorAll('.checkbox-item:checked').length;
    if (checked > 0) {
        selectedCount.textContent = checked + ' siswa dipilih';
        btnHapusTerpilih.classList.remove('hidden');
    } else {
        selectedCount.textContent = 'Centang siswa untuk menandai';
        btnHapusTerpilih.classList.add('hidden');
    }
}

checkboxes.forEach(cb => cb.addEventListener('change', updateSelected));

// Hapus satu siswa
function hapusSatu(id, nama) {
    if (!confirm('⚠️ Yakin hapus siswa "' + nama + '"?\n\nData tidak dapat dikembalikan!')) return;

    // Uncheck semua dulu
    checkboxes.forEach(cb => cb.checked = false);

    // Check hanya yang dipilih
    const cb = document.querySelector('.checkbox-item[value="' + id + '"]');
    if (cb) cb.checked = true;

    inputAksi.value = 'terpilih';
    formHapus.submit();
}

// Hapus terpilih
function hapusTerpilih() {
    const checked = document.querySelectorAll('.checkbox-item:checked').length;
    if (checked === 0) {
        alert('Pilih minimal 1 siswa terlebih dahulu!');
        return;
    }
    if (!confirm('⚠️ PERINGATAN!\n\nAnda akan menghapus ' + checked + ' data siswa.\n\nData tidak dapat dikembalikan!\n\nYakin lanjutkan?')) return;

    inputAksi.value = 'terpilih';
    formHapus.submit();
}

// Hapus semua
function hapusSemua() {
    const total = {{ $students->total() }};
    if (total === 0) {
        alert('Tidak ada data siswa!');
        return;
    }
    if (!confirm('⚠️ PERINGATAN KERAS!\n\nAnda akan menghapus SEMUA ' + total + ' data siswa!\n\nTindakan ini TIDAK DAPAT DIBATALKAN!\n\nKlik OK untuk melanjutkan.')) return;

    inputAksi.value = 'semua';
    formHapus.action = '{{ route('students.destroy-all') }}';
    formHapus.submit();
}
</script>
@endpush