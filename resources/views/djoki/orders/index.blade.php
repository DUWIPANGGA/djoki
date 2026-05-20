@extends('layouts.' . auth()->user()->role)

@section('title', 'Manajemen Pesanan')
@section('header', auth()->user()->role === 'provider' ? 'Project Saya' : 'Daftar Pesanan')
@section('subheader', auth()->user()->role === 'provider'
    ? 'Kelola semua project joki IT yang ditugaskan ke Anda.'
    : 'Kelola semua pesanan joki IT Anda di sini.')

@php
    $accent = match (auth()->user()->role) {
        'provider' => 'green',
        'client' => 'indigo',
        default => 'blue',
    };
@endphp

@section('content')
@if(auth()->user()->role === 'client')
<div class="mb-6 flex justify-end lg:hidden">
    <a href="{{ route('orders.create') }}" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl transition flex items-center shadow-lg shadow-indigo-600/20">
        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Pesan Baru
    </a>
</div>
@endif

@if($orders->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
        @foreach($orders as $order)
            <x-order-card
                :order="$order"
                :accent="$accent"
                :show-delete="auth()->user()->role === 'admin'"
                :counterparty-label="auth()->user()->role === 'client' ? 'Provider' : 'Client'"
                :counterparty-name="auth()->user()->role === 'client' ? ($order->provider->name ?? 'Menunggu Admin') : $order->client->name"
            />
        @endforeach
    </div>
@else
    <div class="glass rounded-3xl py-16 px-6 text-center">
        <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-white/5 text-slate-500 mb-4">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <p class="text-slate-400 font-medium">Belum ada pesanan.</p>
        @if(auth()->user()->role === 'client')
            <a href="{{ route('orders.create') }}" class="mt-4 inline-block text-indigo-400 hover:underline text-sm font-semibold">Buat pesanan pertama</a>
        @endif
    </div>
@endif

<div class="mt-8">
    {{ $orders->links() }}
</div>
@endsection
