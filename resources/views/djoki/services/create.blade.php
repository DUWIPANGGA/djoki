@extends('layouts.admin')

@section('title', 'Tambah Layanan')
@section('header', 'Tambah Layanan Baru')
@section('subheader', 'Buat layanan baru untuk ditawarkan kepada user.')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('services.index') }}" class="inline-flex items-center text-sm text-slate-400 hover:text-white transition mb-6">
        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="glass rounded-3xl p-8">
        <form action="{{ route('services.store') }}" method="POST" class="space-y-6">
            @csrf
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nama Layanan</label>
                    <input type="text" id="name" name="name" required 
                           class="w-full bg-white/5 border @error('name') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                           placeholder="Contoh: Landing Page React" value="{{ old('name') }}">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-slate-300 mb-2">Slug (URL)</label>
                    <input type="text" id="slug" name="slug" 
                           class="w-full bg-white/5 border @error('slug') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                           placeholder="landing-page-react" value="{{ old('slug') }}">
                    @error('slug') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate-300 mb-2">Kategori</label>
                    <select id="category_id" name="category_id" required
                            class="w-full bg-[#0f172a] border @error('category_id') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition appearance-none">
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="min_price" class="block text-sm font-medium text-slate-300 mb-2">Harga Minimum (Rp)</label>
                    <input type="number" id="min_price" name="min_price" 
                           class="w-full bg-white/5 border @error('min_price') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                           placeholder="500000" value="{{ old('min_price') }}">
                    @error('min_price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="max_price" class="block text-sm font-medium text-slate-300 mb-2">Harga Maksimum (Rp)</label>
                    <input type="number" id="max_price" name="max_price" 
                           class="w-full bg-white/5 border @error('max_price') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                           placeholder="2000000" value="{{ old('max_price') }}">
                    @error('max_price') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="estimated_time" class="block text-sm font-medium text-slate-300 mb-2">Estimasi Waktu</label>
                    <input type="text" id="estimated_time" name="estimated_time" 
                           class="w-full bg-white/5 border @error('estimated_time') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                           placeholder="Contoh: 3-5 Hari" value="{{ old('estimated_time') }}">
                    @error('estimated_time') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="is_active" class="block text-sm font-medium text-slate-300 mb-2">Status</label>
                    <div class="flex items-center space-x-4 h-[50px]">
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="is_active" value="1" class="hidden peer" checked>
                            <div class="px-4 py-2 rounded-xl border border-white/10 peer-checked:bg-blue-600 peer-checked:border-blue-600 text-sm transition">Aktif</div>
                        </label>
                        <label class="flex items-center cursor-pointer">
                            <input type="radio" name="is_active" value="0" class="hidden peer">
                            <div class="px-4 py-2 rounded-xl border border-white/10 peer-checked:bg-red-600 peer-checked:border-red-600 text-sm transition">Nonaktif</div>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-slate-300 mb-2">Deskripsi Layanan</label>
                <textarea id="description" name="description" rows="4" required
                          class="w-full bg-white/5 border @error('description') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                          placeholder="Jelaskan apa yang didapatkan user dari layanan ini...">{{ old('description') }}</textarea>
                @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl transition shadow-lg shadow-blue-600/20">
                    Simpan Layanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
