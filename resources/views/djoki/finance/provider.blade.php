@extends('layouts.provider')

@section('title', 'Riwayat Payout')
@section('header', 'Riwayat Pembayaran')
@section('subheader', 'Lihat status pembayaran untuk semua project Anda.')

@section('content')
<!-- Earnings Card -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="glass rounded-3xl p-6 border border-green-500/20 bg-green-500/5">
        <div class="flex items-center justify-between mb-4">
            <div class="h-10 w-10 rounded-xl bg-green-500/20 flex items-center justify-center text-green-400">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <span class="text-[10px] font-bold text-green-400 uppercase tracking-widest">Total Earnings</span>
        </div>
        <h3 class="text-2xl font-bold text-white">Rp {{ number_format(auth()->user()->total_earnings, 0, ',', '.') }}</h3>
        <p class="text-xs text-slate-500 mt-1">Total penghasilan yang telah dibayarkan oleh Admin.</p>
    </div>
</div>

<div class="glass rounded-3xl p-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-white/10 text-xs uppercase tracking-widest text-slate-500">
                    <th class="p-4 font-bold">Order ID / Layanan</th>
                    <th class="p-4 font-bold">Klien (Client)</th>
                    <th class="p-4 font-bold">Status Pesanan</th>
                    <th class="p-4 font-bold">Status Payout</th>
                    <th class="p-4 font-bold text-center">Bukti Transfer</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($orders as $order)
                <tr class="border-b border-white/5 hover:bg-white/5 transition">
                    <td class="p-4">
                        <p class="font-bold text-white">{{ $order->order_number }}</p>
                        <p class="text-xs text-slate-400">{{ $order->service->name ?? 'Custom' }}</p>
                    </td>
                    <td class="p-4 text-white font-medium">
                        {{ $order->client->name }}
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest 
                            {{ $order->status === 'completed' ? 'bg-green-500/10 text-green-400' : 'bg-blue-500/10 text-blue-400' }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="p-4">
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest 
                            {{ $order->provider_payment_status === 'paid' ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">
                            {{ $order->provider_payment_status === 'paid' ? 'Lunas / Sudah Dibayar' : 'Belum Dibayar' }}
                        </span>
                    </td>
                    <td class="p-4 align-middle text-center">
                        @if($order->provider_payment_status === 'paid' && $order->provider_payment_proof_path)
                            <a href="{{ Storage::url($order->provider_payment_proof_path) }}" target="_blank" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold rounded-lg transition inline-flex items-center">
                                <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat Bukti
                            </a>
                        @else
                            <span class="text-[10px] text-slate-500 italic">Belum ada bukti</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-500">
                        Anda belum memiliki project.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection
