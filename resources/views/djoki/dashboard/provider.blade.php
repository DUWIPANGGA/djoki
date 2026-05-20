@extends('layouts.provider')

@section('title', 'Provider Dashboard')
@section('header', 'Provider Dashboard')
@section('subheader', 'Kelola pesanan dan pantau penghasilan Anda.')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="h-16 w-16 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1">Penghasilan</p>
            <h3 class="text-2xl font-bold text-white">Rp {{ number_format($data['total_earned'] ?? 0, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-slate-500 mt-2">Saldo siap ditarik</p>
        </div>

        <div class="glass p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="h-16 w-16 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.71-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1">Rating Rata-rata</p>
            <h3 class="text-2xl font-bold text-white">{{ number_format($data['avg_rating'] ?? 0, 1) }} / 5.0</h3>
            <p class="text-[10px] text-slate-500 mt-2">Dilihat oleh klien</p>
        </div>

        <div class="glass p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="h-16 w-16 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1">Tingkat Penyelesaian</p>
            <h3 class="text-2xl font-bold text-white">{{ $data['completion_rate'] ?? 0 }}%</h3>
            <p class="text-[10px] text-slate-500 mt-2">Performa pengerjaan</p>
        </div>

        <div class="glass p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="h-16 w-16 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1">Pesanan Aktif</p>
            <h3 class="text-2xl font-bold text-white">{{ number_format($data['active_orders'] ?? 0) }}</h3>
            <p class="text-[10px] text-orange-400 mt-2 italic">Dalam proses pengerjaan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 glass rounded-3xl p-6">
            <div class="flex justify-between items-center mb-5">
                <h3 class="font-bold text-white">Project Saya</h3>
                <a href="{{ route('orders.index') }}" class="text-xs text-green-400 hover:underline font-semibold">Lihat Semua</a>
            </div>
            @if(count($data['recent_orders'] ?? []) > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach($data['recent_orders'] as $order)
                        <x-order-card-compact :order="$order" accent="green" />
                    @endforeach
                </div>
            @else
                <p class="text-center text-slate-500 italic py-8">Belum ada project yang ditugaskan.</p>
            @endif
        </div>

        <div class="glass rounded-3xl p-6">
            <h3 class="font-bold text-white mb-6">Status Provider</h3>
            <div class="space-y-6">
                <div class="flex items-start">
                    <div class="h-8 w-8 rounded-full bg-green-500/10 flex items-center justify-center text-green-400 mr-3 mt-1">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-white font-medium">Profile Terverifikasi</p>
                        <p class="text-[10px] text-slate-500">Anda dapat menerima project baru.</p>
                    </div>
                </div>
                <div class="pt-4">
                    <a href="{{ route('portfolios.index') }}"
                        class="w-full inline-flex justify-center items-center px-4 py-3 bg-white/5 hover:bg-white/10 text-white text-xs font-bold rounded-2xl transition border border-white/10">
                        Update Portfolio
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
