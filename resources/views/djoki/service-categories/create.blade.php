@extends('layouts.admin')

@section('title', 'Tambah Kategori')
@section('header', 'Tambah Kategori Baru')
@section('subheader', 'Buat kategori baru untuk mengelompokkan layanan.')

@section('content')
<div class="max-w-2xl">
    <a href="{{ route('service-categories.index') }}" class="inline-flex items-center text-sm text-slate-400 hover:text-white transition mb-6">
        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="glass rounded-3xl p-8">
        <form action="{{ route('service-categories.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nama Kategori</label>
                <input type="text" id="name" name="name" required 
                       class="w-full bg-white/5 border @error('name') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                       placeholder="Contoh: Web Development" value="{{ old('name') }}">
                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-slate-300 mb-2">Slug (URL)</label>
                <input type="text" id="slug" name="slug" 
                       class="w-full bg-white/5 border @error('slug') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                       placeholder="web-development" value="{{ old('slug') }}">
                <p class="mt-1 text-[10px] text-slate-500">Kosongkan jika ingin dibuat otomatis dari nama.</p>
                @error('slug') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="icon" class="block text-sm font-medium text-slate-300 mb-2">Ikon (Emoji atau SVG)</label>
                <input type="text" id="icon" name="icon" 
                       class="w-full bg-white/5 border @error('icon') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                       placeholder="🚀" value="{{ old('icon') }}">
                @error('icon') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-300 mb-2">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                          class="w-full bg-white/5 border @error('description') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                          placeholder="Jelaskan kategori ini secara singkat...">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl transition shadow-lg shadow-blue-600/20">
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
