@extends('layouts.app')

@section('title', 'Edit Mata Pelajaran')

@section('content')

<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('mapel.index') }}" class="inline-flex items-center text-sm text-gray-500 hover:text-gray-700">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Kembali
        </a>
    </div>
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
        <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-6">Edit Mata Pelajaran</h2>
        <form action="{{ route('mapel.update', $mapel) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')
            <div>
                <label class="label-field">Nama Mata Pelajaran <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama', $mapel->nama) }}" class="input-field @error('nama') border-red-500 @enderror">
                @error('nama')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="label-field">Kode <span class="text-red-500">*</span></label>
                <input type="text" name="kode" value="{{ old('kode', $mapel->kode) }}" class="input-field @error('kode') border-red-500 @enderror">
                @error('kode')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="label-field">KKM <span class="text-red-500">*</span></label>
                <input type="number" name="kkm" value="{{ old('kkm', $mapel->kkm) }}" class="input-field @error('kkm') border-red-500 @enderror" min="0" max="100">
                @error('kkm')<p class="mt-1 text-xs text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="label-field">Status</label>
                <select name="is_active" class="input-field">
                    <option value="1" {{ $mapel->is_active ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ !$mapel->is_active ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="submit" class="btn-primary flex-1">Update</button>
                <a href="{{ route('mapel.index') }}" class="btn-secondary flex-1 text-center">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection