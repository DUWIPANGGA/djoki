@extends('layouts.admin')

@section('title', 'Daftar Layanan')
@section('header', 'Daftar Layanan')
@section('subheader', 'Daftar spesifik layanan IT yang ditawarkan.')

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('services.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition flex items-center shadow-lg shadow-blue-600/20">
        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Layanan
    </a>
</div>

<div class="glass rounded-3xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[640px] text-left">
            <thead>
                <tr class="border-b border-white/5 bg-white/5">
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Layanan</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Kategori</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Estimasi Harga</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Status</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($services as $service)
                <tr class="hover:bg-white/[0.02] transition">
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-white">{{ $service->name }}</div>
                        <div class="text-[10px] font-mono text-slate-500">{{ $service->slug }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-blue-500/10 text-blue-400 text-[10px] font-bold rounded-full uppercase tracking-tighter">
                            {{ $service->category->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-slate-300">
                            @if($service->min_price || $service->max_price)
                                Rp {{ number_format($service->min_price, 0, ',', '.') }} - {{ number_format($service->max_price, 0, ',', '.') }}
                            @else
                                <span class="text-slate-500 italic">Nego</span>
                            @endif
                        </div>
                        <div class="text-[10px] text-slate-500 mt-1 flex items-center">
                            <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $service->estimated_time ?: 'N/A' }}
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @if($service->is_active)
                            <span class="flex items-center text-xs text-green-400">
                                <span class="h-1.5 w-1.5 rounded-full bg-green-400 mr-2"></span>
                                Aktif
                            </span>
                        @else
                            <span class="flex items-center text-xs text-slate-500">
                                <span class="h-1.5 w-1.5 rounded-full bg-slate-500 mr-2"></span>
                                Nonaktif
                            </span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('services.edit', $service) }}" class="p-2 hover:bg-blue-500/10 rounded-lg text-blue-400 transition" title="Edit">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('services.destroy', $service) }}" method="POST" onsubmit="return confirm('Hapus layanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 hover:bg-red-500/10 rounded-lg text-red-400 transition" title="Hapus">
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">
                        Belum ada daftar layanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $services->links() }}
</div>
@endsection
