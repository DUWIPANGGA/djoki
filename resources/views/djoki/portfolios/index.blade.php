@extends('layouts.provider')

@section('title', 'Portfolio Karya')
@section('header', 'Portfolio Karya')
@section('subheader', 'Kelola hasil kerja terbaik Anda untuk dipamerkan.')

@section('content')
<div class="mb-6 flex justify-end">
    <a href="{{ route('portfolios.create') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-xl transition flex items-center shadow-lg shadow-blue-600/20">
        <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Tambah Portfolio
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
    @forelse($portfolios as $portfolio)
    <div class="glass rounded-3xl overflow-hidden group hover:border-blue-500/50 transition duration-500">
        <div class="h-48 bg-white/5 relative overflow-hidden">
            @if($portfolio->media_files && count($portfolio->media_files) > 0)
                <img src="{{ Storage::url($portfolio->media_files[0]) }}" alt="{{ $portfolio->title }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
            @else
                <div class="w-full h-full flex items-center justify-center text-slate-600">
                    <svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
            @endif
            <div class="absolute top-4 right-4">
                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $portfolio->is_public ? 'bg-green-500/10 text-green-400' : 'bg-slate-500/10 text-slate-400' }}">
                    {{ $portfolio->is_public ? 'Publik' : 'Privat' }}
                </span>
            </div>
        </div>
        
        <div class="p-6">
            <h3 class="text-lg font-bold text-white mb-2 line-clamp-1">{{ $portfolio->title }}</h3>
            <p class="text-sm text-slate-400 mb-6 line-clamp-2">{{ $portfolio->description }}</p>
            
            <div class="flex items-center justify-between pt-6 border-t border-white/5">
                <div class="flex items-center">
                    <div class="h-6 w-6 rounded-full bg-blue-500/20 flex items-center justify-center text-[10px] font-bold text-blue-400">
                        {{ substr($portfolio->provider->name, 0, 1) }}
                    </div>
                    <span class="ml-2 text-xs text-slate-500">{{ $portfolio->provider->name }}</span>
                </div>
                
                <div class="flex space-x-2">
                    <a href="{{ route('portfolios.edit', $portfolio) }}" class="p-2 hover:bg-blue-500/10 rounded-lg text-blue-400 transition" title="Edit">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </a>
                    <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" onsubmit="return confirm('Hapus portfolio ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 hover:bg-red-500/10 rounded-lg text-red-400 transition" title="Hapus">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-20 text-center glass rounded-3xl">
        <div class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-white/5 text-slate-600 mb-4">
            <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <p class="text-slate-500">Belum ada portfolio yang ditambahkan.</p>
        <a href="{{ route('portfolios.create') }}" class="mt-4 inline-block text-blue-400 hover:underline text-sm">Mulai buat portfolio pertama Anda</a>
    </div>
    @endforelse
</div>

<div class="mt-8">
    {{ $portfolios->links() }}
</div>
@endsection
