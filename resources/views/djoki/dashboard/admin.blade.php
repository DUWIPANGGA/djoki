@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('header', 'Admin Dashboard')
@section('subheader', 'Pantau performa platform D\'JOKI secara keseluruhan.')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="glass p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="h-16 w-16 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1">Total Pendapatan</p>
            <h3 class="text-2xl font-bold text-white">Rp {{ number_format($data['revenue'] ?? 0, 0, ',', '.') }}</h3>
            <p class="text-[10px] text-green-400 mt-2 flex items-center">
                <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                </svg>
                +12.5% dari bulan lalu
            </p>
        </div>

        <div class="glass p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="h-16 w-16 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1">Total Pesanan</p>
            <h3 class="text-2xl font-bold text-white">{{ number_format($data['total_orders'] ?? 0) }}</h3>
            <p class="text-[10px] text-slate-500 mt-2">{{ number_format($data['completed_orders'] ?? 0) }} Selesai</p>
        </div>

        <div class="glass p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="h-16 w-16 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1">Total Pengguna</p>
            <h3 class="text-2xl font-bold text-white">{{ number_format($data['total_users'] ?? 0) }}</h3>
            <p class="text-[10px] text-slate-500 mt-2">{{ number_format($data['total_providers'] ?? 0) }} Provider</p>
        </div>

        <div class="glass p-6 rounded-3xl relative overflow-hidden group">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="h-16 w-16 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <p class="text-xs font-semibold text-slate-500 uppercase tracking-widest mb-1">Pesanan Aktif</p>
            <h3 class="text-2xl font-bold text-white">{{ number_format($data['active_orders'] ?? 0) }}</h3>
            <p class="text-[10px] text-orange-400 mt-2 italic">Perlu perhatian segera</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 glass rounded-3xl overflow-hidden">
            <div class="p-6 border-b border-white/5 flex justify-between items-center">
                <h3 class="font-bold text-white">Pesanan Terbaru (Platform)</h3>
                <a href="{{ route('orders.index') }}" class="text-xs text-blue-400 hover:underline">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-slate-500 bg-white/5">
                            <th class="px-6 py-4 font-semibold">ID</th>
                            <th class="px-6 py-4 font-semibold">Client</th>
                            <th class="px-6 py-4 font-semibold">Layanan</th>
                            <th class="px-6 py-4 font-semibold">Total</th>
                            <th class="px-6 py-4 font-semibold">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        @forelse($data['recent_orders'] ?? [] as $order)
                            <tr class="hover:bg-white/[0.02] transition">
                                <td class="px-6 py-4 font-mono text-xs text-slate-400">
                                    #{{ substr($order->order_number, 0, 8) }}</td>
                                <td class="px-6 py-4 text-white font-medium">{{ $order->client->name }}</td>
                                <td class="px-6 py-4 text-slate-400">{{ $order->service->name ?? 'Custom Service' }}</td>
                                <td class="px-6 py-4 text-white font-semibold">Rp
                                    {{ number_format($order->total_price, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    <span
                                        class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                                {{ $order->status === 'completed'
                                    ? 'bg-green-500/10 text-green-400'
                                    : ($order->status === 'pending'
                                        ? 'bg-yellow-500/10 text-yellow-400'
                                        : 'bg-blue-500/10 text-blue-400') }}">
                                        {{ $order->status }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-slate-500 italic">Belum ada pesanan
                                    terbaru.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="glass rounded-3xl p-6">
            <h3 class="font-bold text-white mb-6">Aktivitas Sistem</h3>
            <div class="space-y-6 text-sm">
                <div class="flex items-start">
                    <div
                        class="h-8 w-8 rounded-full bg-blue-500/10 flex items-center justify-center text-blue-400 mr-3 mt-1">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-white font-medium">Master data diperbarui</p>
                        <p class="text-[10px] text-slate-500">Sistem siap menerima pesanan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
