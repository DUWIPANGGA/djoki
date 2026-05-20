@extends('layouts.admin')

@section('title', 'Kategori Layanan')
@section('header', 'Kategori Layanan')
@section('subheader', 'Kelola kategori besar layanan IT yang tersedia.')

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('service-categories.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition flex items-center shadow-lg shadow-blue-600/20">
        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Kategori
    </a>
</div>

<div class="glass rounded-3xl overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full min-w-[560px] text-left">
            <thead>
                <tr class="border-b border-white/5 bg-white/5">
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Ikon</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Nama Kategori</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Slug</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Deskripsi</th>
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($categories as $category)
                <tr class="hover:bg-white/[0.02] transition">
                    <td class="px-6 py-4">
                        <div class="h-10 w-10 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400">
                            <span class="text-xl">{{ $category->icon ?: '📁' }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-white">{{ $category->name }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="text-xs font-mono text-slate-500 bg-white/5 px-2 py-1 rounded">{{ $category->slug }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-slate-400 max-w-xs truncate">{{ $category->description }}</div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="flex justify-end space-x-2">
                            <a href="{{ route('service-categories.edit', $category) }}" class="p-2 hover:bg-blue-500/10 rounded-lg text-blue-400 transition" title="Edit">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                            </a>
                            <form action="{{ route('service-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
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
                        Belum ada kategori layanan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
