@extends('layouts.admin')

@section('title', 'Metode Pembayaran')
@section('header', 'Metode Pembayaran')
@section('subheader', 'Kelola daftar metode pembayaran yang tersedia untuk klien.')

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('payment-methods.create') }}" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl transition shadow-lg shadow-blue-600/30 flex items-center">
        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Metode
    </a>
</div>

<div class="glass rounded-3xl p-8">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b border-white/10 text-xs uppercase tracking-widest text-slate-500">
                    <th class="p-4 font-bold">Nama Metode</th>
                    <th class="p-4 font-bold">Nomor Rekening/ID</th>
                    <th class="p-4 font-bold">Nama Pemilik</th>
                    <th class="p-4 font-bold text-center">Status</th>
                    <th class="p-4 font-bold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm">
                @forelse($paymentMethods as $method)
                <tr class="border-b border-white/5 hover:bg-white/5 transition">
                    <td class="p-4 text-white font-bold">{{ $method->name }}</td>
                    <td class="p-4 text-slate-300 font-mono">{{ $method->account_number }}</td>
                    <td class="p-4 text-slate-400">{{ $method->account_name ?: '-' }}</td>
                    <td class="p-4 text-center">
                        <span class="px-2 py-1 rounded text-[10px] font-bold uppercase tracking-widest 
                            {{ $method->is_active ? 'bg-green-500/10 text-green-400' : 'bg-red-500/10 text-red-400' }}">
                            {{ $method->is_active ? 'Aktif' : 'Non-aktif' }}
                        </span>
                    </td>
                    <td class="p-4">
                        <div class="flex items-center justify-center space-x-3">
                            <a href="{{ route('payment-methods.edit', $method) }}" class="text-blue-400 hover:text-blue-300 transition">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('payment-methods.destroy', $method) }}" method="POST" onsubmit="return confirm('Hapus metode ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-400 transition">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-8 text-center text-slate-500 italic">Belum ada metode pembayaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $paymentMethods->links() }}
    </div>
</div>
@endsection
