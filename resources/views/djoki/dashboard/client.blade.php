@extends('layouts.client')

@section('header', 'Client Dashboard')
@section('subheader', 'Pantau status pesanan joki IT Anda.')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <div class="glass p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="h-16 w-16 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1">Total Pengeluaran</p>
            <h3 class="text-2xl font-bold text-white">Rp {{ number_format($data['total_spent'] ?? 0, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-slate-500 mt-2">Investasi untuk solusi IT</p>
        </div>

        <div class="glass p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1">Pesanan Selesai</p>
            <h3 class="text-2xl font-bold text-white">{{ number_format($data['completed_orders'] ?? 0) }}</h3>
            <p class="text-[10px] text-slate-500 mt-2">Kebutuhan IT yang terpenuhi</p>
        </div>

        <div class="glass p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="h-16 w-16 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1">Pesanan Aktif</p>
            <h3 class="text-2xl font-bold text-white">{{ number_format($data['active_orders'] ?? 0) }}</h3>
            <p class="text-[10px] text-orange-400 mt-2 italic">Sedang dikerjakan provider</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 glass rounded-3xl p-6">
            <div class="flex justify-between items-center mb-5">
                <h3 class="font-bold text-white">Pesanan Saya</h3>
                <a href="{{ route('orders.index') }}" class="text-xs text-indigo-400 hover:underline font-semibold">Lihat Semua</a>
            </div>
            @if(count($data['recent_orders'] ?? []) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($data['recent_orders'] as $order)
                        <x-order-card-compact :order="$order" accent="indigo" />
                    @endforeach
                </div>
            @else
                <p class="text-center text-slate-500 italic py-8">Anda belum memiliki pesanan.</p>
            @endif
        </div>

        <div class="glass rounded-3xl p-6 flex flex-col h-full max-h-[500px]">
            <h3 class="font-bold text-white mb-6">Cari Layanan Joki IT</h3>

            <div class="space-y-4 overflow-y-auto pr-2 flex-1 mb-4">
                @forelse($data['services'] ?? [] as $service)
                    <div class="p-4 rounded-2xl bg-white/5 border border-white/10 hover:border-indigo-500/50 transition group">
                        <h4 class="text-sm font-bold text-white group-hover:text-indigo-400 transition mb-2">{{ $service->name }}</h4>
                        <span class="text-[10px] font-semibold text-green-400 bg-green-500/10 px-2 py-1 rounded-lg mb-2 inline-block">Mulai Rp {{ number_format($service->min_price, 0, ',', '.') }}</span>
                        <p class="text-xs text-slate-400 mb-4 line-clamp-2">{{ $service->description }}</p>
                        <a href="{{ route('orders.create', ['service_id' => $service->id]) }}"
                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-indigo-600/20 hover:bg-indigo-600 text-indigo-400 hover:text-white text-xs font-bold rounded-xl transition border border-indigo-500/30 hover:border-transparent">
                            Pesan Sekarang
                        </a>
                    </div>
                @empty
                    <p class="text-xs text-slate-500 text-center py-4">Belum ada layanan tersedia.</p>
                @endforelse
            </div>

            <div class="pt-4 border-t border-white/10 mt-auto">
                <a href="{{ route('orders.create') }}"
                    class="w-full inline-flex justify-center items-center px-4 py-3 bg-white/5 hover:bg-white/10 text-white text-xs font-bold rounded-2xl transition border border-white/10">
                    Custom Order / Lainnya
                </a>
            </div>
        </div>
    </div>
@endsection
