@extends('layouts.admin')

@section('title', 'Finance & Payments')
@section('header', 'Keuangan (Finance)')
@section('subheader', 'Kelola pembayaran masuk dari klien dan payout ke provider.')

@section('content')
<div class="space-y-8">
    <!-- Section 1: Konfirmasi Pembayaran Klien (Incoming) -->
    <div class="glass rounded-3xl p-8 border border-yellow-500/20 bg-yellow-500/5">
        <h3 class="text-lg font-bold text-white mb-6 flex items-center">
            <svg class="h-5 w-5 mr-2 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Verifikasi Pembayaran Klien
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/10 text-[10px] uppercase tracking-widest text-slate-500">
                        <th class="p-4 font-bold">Order / Klien</th>
                        <th class="p-4 font-bold">Layanan</th>
                        <th class="p-4 font-bold">Nominal</th>
                        <th class="p-4 font-bold">Bukti</th>
                        <th class="p-4 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($pendingPayments as $payment)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="p-4">
                            <p class="font-bold text-white">{{ $payment->order->order_number }}</p>
                            <p class="text-xs text-slate-400">{{ $payment->order->client->name }}</p>
                        </td>
                        <td class="p-4 text-slate-300">
                            {{ $payment->order->service->name ?? 'Custom' }}
                        </td>
                        <td class="p-4 font-bold text-green-400">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </td>
                        <td class="p-4">
                            <a href="{{ Storage::url($payment->payment_proof) }}" target="_blank" class="text-[10px] bg-white/10 hover:bg-white/20 text-white px-2 py-1 rounded transition">
                                Lihat Bukti
                            </a>
                        </td>
                        <td class="p-4 text-center">
                            <form action="{{ route('payments.confirm', $payment) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-[10px] font-bold rounded-lg transition">
                                    Konfirmasi & ACC
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-500 italic">Tidak ada pembayaran masuk yang menunggu verifikasi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Section 2: Payout ke Provider (Outgoing) -->
    <div class="glass rounded-3xl p-8 border border-blue-500/20">
        <h3 class="text-lg font-bold text-white mb-6 flex items-center">
            <svg class="h-5 w-5 mr-2 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Payout ke Provider
        </h3>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-white/10 text-[10px] uppercase tracking-widest text-slate-500">
                        <th class="p-4 font-bold">Order / Provider</th>
                        <th class="p-4 font-bold">Layanan</th>
                        <th class="p-4 font-bold">Status Pesanan</th>
                        <th class="p-4 font-bold">Status Payout</th>
                        <th class="p-4 font-bold">Net Payout</th>
                        <th class="p-4 font-bold text-center">Aksi (Upload Bukti)</th>
                    </tr>
                </thead>
                <tbody class="text-sm">
                    @forelse($orders as $order)
                    <tr class="border-b border-white/5 hover:bg-white/5 transition">
                        <td class="p-4">
                            <p class="font-bold text-white">{{ $order->order_number }}</p>
                            <p class="text-xs text-slate-400">{{ $order->provider->name }}</p>
                        </td>
                        <td class="p-4 text-slate-300">
                            {{ $order->service->name ?? 'Custom' }}
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
                                {{ $order->provider_payment_status === 'paid' ? 'Lunas' : 'Menunggu' }}
                            </span>
                        </td>
                        <td class="p-4 font-bold text-green-400 whitespace-nowrap">
                            Rp {{ number_format(($order->total_price ?? 0) * 0.88, 0, ',', '.') }}
                        </td>
                        <td class="p-4 align-middle text-center">
                            @if($order->provider_payment_status !== 'paid')
                                <form action="{{ route('finance.pay', $order) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center space-y-2">
                                    @csrf
                                    <label class="cursor-pointer text-[10px] bg-blue-600 hover:bg-blue-700 text-white py-1.5 px-3 rounded-lg transition inline-block">
                                        Pilih Bukti Transfer
                                        <input type="file" name="payment_proof" class="hidden" required onchange="this.nextElementSibling.classList.remove('hidden')">
                                        <button type="submit" class="hidden mt-2 text-[10px] bg-green-500 hover:bg-green-600 px-2 py-1 rounded">Upload & Bayar</button>
                                    </label>
                                </form>
                            @else
                                <a href="{{ Storage::url($order->provider_payment_proof_path) }}" target="_blank" class="text-[10px] text-blue-400 hover:underline">
                                    Lihat Bukti Payout
                                </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-slate-500 italic">Belum ada project untuk payout.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
