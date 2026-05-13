@extends('layouts.provider')

@section('title', 'Tambah Portfolio')
@section('header', 'Tambah Portfolio Baru')
@section('subheader', 'Pamerkan hasil kerja terbaik Anda untuk menarik klien.')

@section('content')
<div class="max-w-4xl">
    <a href="{{ route('portfolios.index') }}" class="inline-flex items-center text-sm text-slate-400 hover:text-white transition mb-6">
        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="glass rounded-3xl p-8">
        <form action="{{ route('portfolios.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-slate-300 mb-2">Judul Project</label>
                        <input type="text" id="title" name="title" required 
                               class="w-full bg-white/5 border @error('title') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                               placeholder="Contoh: E-Commerce dengan Laravel" value="{{ old('title') }}">
                        @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="external_link" class="block text-sm font-medium text-slate-300 mb-2">Link Project (Optional)</label>
                        <input type="url" id="external_link" name="external_link" 
                               class="w-full bg-white/5 border @error('external_link') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                               placeholder="https://github.com/username/project" value="{{ old('external_link') }}">
                        @error('external_link') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-slate-300 mb-2">Deskripsi Project</label>
                        <textarea id="description" name="description" rows="6"
                                  class="w-full bg-white/5 border @error('description') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                                  placeholder="Jelaskan fitur, teknologi yang digunakan, dan hasil dari project ini...">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Preview Project (Media)</label>
                        <div class="border-2 border-dashed border-white/10 rounded-3xl p-8 text-center hover:border-blue-500/50 transition cursor-pointer group relative">
                            <input type="file" name="images[]" multiple class="absolute inset-0 opacity-0 cursor-pointer">
                            <div class="space-y-2">
                                <svg class="mx-auto h-12 w-12 text-slate-500 group-hover:text-blue-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-sm text-slate-400">Klik atau drop file gambar di sini</p>
                                <p class="text-[10px] text-slate-600 uppercase">PNG, JPG, up to 5MB</p>
                            </div>
                        </div>
                        @error('images') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <div class="p-6 glass rounded-2xl">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Pengaturan Visibilitas</h4>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-white font-medium">Tampilkan ke Publik</p>
                                <p class="text-[10px] text-slate-500">Project akan terlihat di halaman profile Anda.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="is_public" value="1" class="sr-only peer" checked>
                                <div class="w-11 h-6 bg-white/10 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-slate-400 after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600 peer-checked:after:bg-white"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="pt-6 border-t border-white/5 flex justify-end">
                <button type="submit" class="px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl transition shadow-lg shadow-blue-600/20">
                    Simpan Portfolio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
