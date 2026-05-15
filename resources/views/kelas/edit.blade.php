@extends('layouts.app')

@section('title', 'Edit Kelas')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('kelas.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali ke Data Kelas
        </a>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Edit Kelas {{ $kela->nama }}</h2>
        <form action="{{ route('kelas.update', $kela) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="label-field">Tingkat <span class="text-red-500">*</span></label>
                    <select name="tingkat" class="input-field">
                        @for($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" {{ old('tingkat', $kela->tingkat) == $i ? 'selected' : '' }}>Kelas {{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="label-field">Kelas <span class="text-red-500">*</span></label>
                    <select name="huruf" class="input-field">
                        @foreach(['A','B','C'] as $h)
                        <option value="{{ $h }}" {{ old('huruf', $kela->huruf) === $h ? 'selected' : '' }}>{{ $h }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div>
                <label class="label-field">Wali Kelas</label>
                <select name="wali_kelas_id" class="input-field">
                    <option value="">-- Pilih Wali Kelas --</option>
                    @foreach($gurus as $guru)
                    <option value="{{ $guru->id }}" {{ old('wali_kelas_id', $kela->wali_kelas_id) == $guru->id ? 'selected' : '' }}>
                        {{ $guru->name }} {{ $guru->kelas ? '(Kelas ' . $guru->kelas . ')' : '' }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label-field">Tahun Ajaran <span class="text-red-500">*</span></label>
                <input type="number" name="tahun_ajaran" value="{{ old('tahun_ajaran', $kela->tahun_ajaran) }}" class="input-field">
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1">Update</button>
                <a href="{{ route('kelas.index') }}" class="btn-secondary flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection