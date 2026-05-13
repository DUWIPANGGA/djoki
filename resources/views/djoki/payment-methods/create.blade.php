@extends('layouts.admin')

@section('title', 'Tambah Metode Pembayaran')
@section('header', 'Tambah Metode')
@section('subheader', 'Tambahkan akun pembayaran baru untuk sistem.')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <a href="{{ route('payment-methods.index') }}" class="inline-flex items-center text-sm text-slate-400 hover:text-white transition">
            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>

    <div class="glass rounded-3xl p-8">
        <form action="{{ route('payment-methods.store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Metode (misal: BCA, Dana, ShopeePay)</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required
                       class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition">
                @error('name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="account_number" class="block text-xs font-bold text-slate-500 uppercase mb-2">Nomor Rekening / ID Akun</label>
                <input type="text" id="account_number" name="account_number" value="{{ old('account_number') }}" required
                       class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition">
                @error('account_number') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="account_name" class="block text-xs font-bold text-slate-500 uppercase mb-2">Nama Pemilik Akun (Opsional)</label>
                <input type="text" id="account_name" name="account_name" value="{{ old('account_name') }}"
                       class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition">
                @error('account_name') <p class="text-red-500 text-[10px] mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center space-x-3 p-4 bg-white/5 rounded-2xl">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" id="is_active" name="is_active" value="1" checked
                       class="h-5 w-5 rounded border-white/10 bg-[#0f172a] text-blue-600 focus:ring-offset-[#0f172a]">
                <label for="is_active" class="text-sm text-slate-300">Aktifkan metode ini agar dapat dipilih klien.</label>
            </div>

            <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl transition shadow-lg shadow-blue-600/30">
                Simpan Metode Pembayaran
            </button>
        </form>
    </div>
</div>
@endsection
