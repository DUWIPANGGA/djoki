@extends('layouts.client')

@section('title', 'Cari Layanan Joki IT')
@section('header', 'Layanan Joki IT')
@section('subheader', 'Pilih jenis layanan IT yang Anda butuhkan dan mulai konsultasi sekarang.')

@section('content')
    <div class="space-y-10">
        <!-- Search & Filters -->
        <div class="glass p-6 rounded-3xl flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative flex-1">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input type="text" placeholder="Cari layanan (Web, Mobile, Skripsi, dll)..."
                    class="block w-full pl-10 pr-3 py-3 bg-[#0f172a] border border-white/10 rounded-2xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition">
            </div>
            <div class="flex items-center space-x-2">
                <button
                    class="px-4 py-3 bg-white/5 border border-white/10 rounded-2xl text-xs font-bold text-white hover:bg-white/10 transition">Semua
                    Kategori</button>
                <button
                    class="px-4 py-3 bg-blue-600 text-white rounded-2xl text-xs font-bold hover:bg-blue-700 transition">Filter</button>
            </div>
        </div>

        @foreach ($categories as $category)
            @if ($category->services->count() > 0)
                <div>
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <span class="w-1.5 h-6 bg-blue-500 rounded-full mr-3"></span>
                            {{ $category->name }}
                        </h3>
                        <span
                            class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">{{ $category->services->count() }}
                            Layanan</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($category->services as $service)
                            <div
                                class="glass p-6 rounded-3xl group hover:border-blue-500/50 transition flex flex-col h-full border border-white/5 bg-white/[0.02]">
                                <div class="mb-4">
                                    <div
                                        class="h-12 w-12 rounded-2xl bg-blue-500/10 flex items-center justify-center mb-4 group-hover:scale-110 transition duration-500">
                                        <svg class="h-6 w-6 text-blue-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-white mb-2 group-hover:text-blue-400 transition">
                                        {{ $service->name }}</h4>
                                    <div class="flex items-center space-x-2 mb-3">
                                        <span
                                            class="text-[10px] font-bold px-2 py-1 bg-green-500/10 text-green-400 rounded-lg uppercase tracking-wider">Fast
                                            Response</span>
                                        <span
                                            class="text-[10px] font-bold px-2 py-1 bg-purple-500/10 text-purple-400 rounded-lg uppercase tracking-wider">Top
                                            Rated</span>
                                    </div>
                                    <p class="text-xs text-slate-400 leading-relaxed line-clamp-3">
                                        {{ $service->description ?? 'Solusi joki IT berkualitas tinggi untuk kebutuhan ' . $service->name . ' Anda.' }}
                                    </p>
                                </div>

                                <div class="mt-auto pt-6 border-t border-white/5">
                                    <div class="flex items-end justify-between mb-4">
                                        <div>
                                            <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Mulai Dari
                                            </p>
                                            <p class="text-xl font-bold text-blue-400">Rp
                                                {{ number_format($service->min_price, 0, ',', '.') }}</p>
                                        </div>
                                        <div class="flex items-center text-yellow-400">
                                            <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                            <span class="text-xs font-bold ml-1 text-white">4.9</span>
                                        </div>
                                    </div>
                                    <a href="{{ route('orders.create', ['service_id' => $service->id]) }}"
                                        class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold rounded-2xl transition shadow-lg shadow-blue-600/20 text-center block">
                                        Pesan Joki
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        @endforeach


    </div>
@endsection
