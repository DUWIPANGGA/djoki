@extends('layouts.' . auth()->user()->role)

@section('title', 'Verifikasi Akun')
@section('header', 'Verifikasi Provider')
@section('subheader', auth()->user()->role === 'admin' ? 'Tinjau dokumen identitas provider untuk memberikan akses.' : 'Unggah dokumen identitas Anda untuk mendapatkan status Verified.')

@section('content')
@if(auth()->user()->role === 'provider')
<div class="mb-8">
    <div class="glass rounded-3xl p-8 border border-blue-500/20">
        <h3 class="text-lg font-bold text-white mb-4">Unggah Dokumen Baru</h3>
        <form action="{{ route('verification-documents.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col md:flex-row md:items-end gap-6">
            @csrf
            <div class="flex-1">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Jenis Dokumen</label>
                <select name="document_type" required class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition appearance-none">
                    <option value="KTP">KTP (Kartu Tanda Penduduk)</option>
                    <option value="SIM">SIM (Surat Ijin Mengemudi)</option>
                    <option value="Paspor">Paspor</option>
                    <option value="Student_Card">Kartu Mahasiswa</option>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">File Dokumen (PDF/Gambar)</label>
                <input type="file" name="file" required class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition">
            </div>
            <button type="submit" class="px-8 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-lg shadow-blue-600/20">
                Unggah Dokumen
            </button>
        </form>
    </div>
</div>
@endif

<div class="glass rounded-3xl overflow-hidden">
    <table class="w-full text-left">
        <thead>
            <tr class="border-b border-white/5 bg-white/5">
                @if(auth()->user()->role === 'admin')
                    <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Provider</th>
                @endif
                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Jenis Dokumen</th>
                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Status</th>
                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400">Tanggal Kirim</th>
                <th class="px-6 py-4 text-xs font-semibold uppercase tracking-wider text-slate-400 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/5">
            @forelse($docs as $doc)
            <tr class="hover:bg-white/[0.02] transition">
                @if(auth()->user()->role === 'admin')
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <div class="h-8 w-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-400 mr-3 text-xs font-bold">
                            {{ substr($doc->user->name, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-white">{{ $doc->user->name }}</div>
                            <div class="text-[10px] text-slate-500">{{ $doc->user->email }}</div>
                        </div>
                    </div>
                </td>
                @endif
                <td class="px-6 py-4">
                    <div class="text-sm text-slate-300 font-medium">{{ $doc->document_type }}</div>
                    @if($doc->admin_note)
                        <div class="text-[10px] text-red-400 mt-1 italic">Note: {{ $doc->admin_note }}</div>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 rounded-lg text-[10px] font-bold uppercase tracking-wider
                        {{ $doc->status === 'approved' ? 'bg-green-500/10 text-green-400' : 
                           ($doc->status === 'rejected' ? 'bg-red-500/10 text-red-400' : 'bg-yellow-500/10 text-yellow-400') }}">
                        {{ $doc->status }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="text-xs text-slate-500">{{ $doc->created_at->format('d M Y, H:i') }}</div>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex justify-end space-x-2">
                        @if(auth()->user()->role === 'admin' && $doc->status === 'pending')
                            <form action="{{ route('verification-documents.status', $doc) }}" method="POST" class="flex items-center space-x-2">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="px-3 py-1 bg-green-600/20 hover:bg-green-600 text-green-400 hover:text-white text-[10px] font-bold rounded-lg transition border border-green-600/30">
                                    APPROVE
                                </button>
                            </form>
                            <button onclick="document.getElementById('reject-form-{{ $doc->id }}').classList.toggle('hidden')" class="px-3 py-1 bg-red-600/20 hover:bg-red-600 text-red-400 hover:text-white text-[10px] font-bold rounded-lg transition border border-red-600/30">
                                REJECT
                            </button>
                        @endif
                        
                        <a href="#" class="p-2 hover:bg-white/5 rounded-lg text-slate-400 transition" title="Lihat Dokumen">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>
                    </div>

                    @if(auth()->user()->role === 'admin' && $doc->status === 'pending')
                    <div id="reject-form-{{ $doc->id }}" class="hidden mt-4 text-left p-4 bg-[#0f172a] rounded-xl border border-red-500/30">
                        <form action="{{ route('verification-documents.status', $doc) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-2">Alasan Penolakan</label>
                            <textarea name="admin_note" required class="w-full bg-white/5 border border-white/10 rounded-lg px-3 py-2 text-white text-xs mb-3" placeholder="Sebutkan alasan penolakan..."></textarea>
                            <div class="flex justify-end">
                                <button type="submit" class="px-4 py-1.5 bg-red-600 text-white text-[10px] font-bold rounded-lg hover:bg-red-700 transition">
                                    Konfirmasi Reject
                                </button>
                            </div>
                        </form>
                    </div>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-slate-500 italic">
                    Belum ada dokumen verifikasi.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $docs->links() }}
</div>
@endsection
