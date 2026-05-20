@props(['order', 'accent' => 'blue'])

@php
    $statusClass = match ($order->status) {
        'completed' => 'bg-green-500/10 text-green-400',
        'pending' => 'bg-yellow-500/10 text-yellow-400',
        'in_progress' => 'bg-blue-500/10 text-blue-400',
        default => 'bg-slate-500/10 text-slate-400',
    };

    $titleHover = match ($accent) {
        'green' => 'group-hover:text-green-400',
        'indigo' => 'group-hover:text-indigo-400',
        default => 'group-hover:text-blue-400',
    };
@endphp

<a href="{{ route('orders.show', $order) }}"
    {{ $attributes->merge(['class' => 'block glass rounded-2xl p-4 border border-white/5 hover:border-white/15 transition group']) }}>
    <div class="flex items-start justify-between gap-2 mb-3">
        <div class="min-w-0">
            <p class="text-xs font-mono text-slate-400">#{{ substr($order->order_number, 0, 8) }}</p>
            <p class="text-sm font-semibold text-white truncate {{ $titleHover }} transition">
                {{ $order->service->name ?? 'Custom Service' }}
            </p>
        </div>
        <span class="shrink-0 px-2 py-0.5 rounded-lg text-[10px] font-bold uppercase {{ $statusClass }}">
            {{ str_replace('_', ' ', $order->status) }}
        </span>
    </div>
    <div class="flex items-center justify-between text-xs">
        <span class="text-slate-500">{{ $order->created_at->format('d M Y') }}</span>
        @if(auth()->user()->role === 'provider')
            <span class="font-bold text-green-400" title="Net (Est)">Rp {{ number_format($order->total_price * 0.88, 0, ',', '.') }}</span>
        @else
            <span class="font-bold text-white">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        @endif
    </div>
</a>
