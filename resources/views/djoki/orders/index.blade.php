@extends('layouts.' . auth()->user()->role)

@section('title', 'Manajemen Pesanan')
@section('header', 'Daftar Pesanan')
@section('subheader', 'Kelola semua pesanan joki IT Anda di sini.')

@section('content')
@if(auth()->user()->role === 'client')
<div class="mb-6 flex justify-end">
    <a href="{{ route('orders.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition flex items-center shadow-lg shadow-blue-600/20">
        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Pesan Baru
    </a>
</div>
@endif

<div class="glass rounded-3xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[800px] text-left">
            <thead>
                <tr class="border-b border-white/5 bg-white/5">
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Order ID</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
                        @if(auth()->user()->role === 'client') Provider @else Client @endif
                    </th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Layanan</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Total</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($orders as $order)
                <tr class="hover:bg-white/[0.02] transition">
                    <td class="px-6 py-4">
                        <div class="text-xs font-mono text-slate-400">#{{ substr($order->order_number, 0, 12) }}</div>
                        <div class="text-[10px] text-slate-600">{{ $order->created_at->format('d M Y') }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if(auth()->user()->role === 'client')
                            <div class="text-sm font-semibold text-white">{{ $order->provider->name ?? 'Menunggu Admin' }}</div>
                        @else
                            <div class="text-sm font-semibold text-white">{{ $order->client->name }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-300">{{ $order->service->name ?? 'Custom Service' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-bold text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</div>
                        <div class="text-[10px] text-slate-500 uppercase">{{ $order->payment_status }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                            {{ $order->status === 'completed' ? 'bg-green-500/10 text-green-400' : 
                               ($order->status === 'pending' ? 'bg-yellow-500/10 text-yellow-400' : 
                               ($order->status === 'in_progress' ? 'bg-blue-500/10 text-blue-400' : 'bg-slate-500/10 text-slate-400')) }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('orders.show', $order) }}" class="p-2 hover:bg-blue-500/10 rounded-lg text-blue-400 transition" title="Detail">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </a>
                            @if(auth()->user()->role === 'admin')
                            <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 hover:bg-red-500/10 rounded-lg text-red-400 transition" title="Hapus">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                                    </svg>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">
                        Belum ada pesanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $orders->links() }}
</div>
@endsection
