@props([
    'order',
    'counterpartyLabel' => null,
    'counterpartyName' => null,
    'showDelete' => false,
    'accent' => 'blue',
])

@php
    $accentRing = match ($accent) {
        'green' => 'hover:border-green-500/40 hover:shadow-green-500/10',
        'indigo' => 'hover:border-indigo-500/40 hover:shadow-indigo-500/10',
        'red' => 'hover:border-red-500/40 hover:shadow-red-500/10',
        default => 'hover:border-blue-500/40 hover:shadow-blue-500/10',
    };

    $accentBtn = match ($accent) {
        'green' => 'bg-green-600/20 text-green-400 hover:bg-green-600 hover:text-white border-green-500/30',
        'indigo' => 'bg-indigo-600/20 text-indigo-400 hover:bg-indigo-600 hover:text-white border-indigo-500/30',
        'red' => 'bg-red-600/20 text-red-400 hover:bg-red-600 hover:text-white border-red-500/30',
        default => 'bg-blue-600/20 text-blue-400 hover:bg-blue-600 hover:text-white border-blue-500/30',
    };

    $statusClass = match ($order->status) {
        'completed' => 'bg-green-500/10 text-green-400',
        'pending' => 'bg-yellow-500/10 text-yellow-400',
        'in_progress' => 'bg-blue-500/10 text-blue-400',
        default => 'bg-slate-500/10 text-slate-400',
    };
@endphp

<article {{ $attributes->merge(['class' => "glass rounded-2xl p-5 flex flex-col h-full border border-white/5 transition duration-300 hover:shadow-lg {$accentRing}"]) }}>
    <div class="flex items-start justify-between gap-3 mb-4">
        <div class="min-w-0">
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-1">Order ID</p>
            <p class="text-sm font-mono text-white truncate">#{{ substr($order->order_number, 0, 12) }}</p>
            <p class="text-[10px] text-slate-500 mt-0.5">{{ $order->created_at->format('d M Y') }}</p>
        </div>
        <span class="shrink-0 px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider {{ $statusClass }}">
            {{ str_replace('_', ' ', $order->status) }}
        </span>
    </div>

    <div class="space-y-3 flex-1">
        @if($counterpartyLabel && $counterpartyName)
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-0.5">{{ $counterpartyLabel }}</p>
                <p class="text-sm font-semibold text-white truncate">{{ $counterpartyName }}</p>
            </div>
        @endif

        <div>
            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-500 mb-0.5">Layanan</p>
            <p class="text-sm text-slate-300 line-clamp-2">{{ $order->service->name ?? 'Custom Service' }}</p>
        </div>

        <div class="flex items-end justify-between gap-2 pt-2 border-t border-white/5">
            <div>
                @if(auth()->user()->role === 'provider')
                    <p class="text-[10px] text-green-500 uppercase tracking-widest">Net (Est)</p>
                    <p class="text-lg font-bold text-green-400">Rp {{ number_format($order->total_price * 0.88, 0, ',', '.') }}</p>
                @else
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest">Total</p>
                    <p class="text-lg font-bold text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                @endif
            </div>
            <p class="text-[10px] text-slate-500 uppercase">{{ $order->payment_status }}</p>
        </div>
    </div>

    <div class="flex items-center gap-2 mt-5 pt-4 border-t border-white/5">
        <a href="{{ route('orders.show', $order) }}"
            class="flex-1 inline-flex justify-center items-center px-4 py-2.5 text-xs font-bold rounded-xl transition border {{ $accentBtn }}">
            Lihat Detail
        </a>
        @if($showDelete)
            <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="p-2.5 rounded-xl bg-red-500/10 text-red-400 hover:bg-red-500/20 border border-red-500/20 transition"
                    title="Hapus">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                    </svg>
                </button>
            </form>
        @endif
    </div>
</article>
