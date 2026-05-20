@extends('layouts.' . auth()->user()->role)

@section('title', 'Detail Pesanan')
@section('header', 'Detail Pesanan')
@section('subheader', 'Pantau perkembangan dan kelola pesanan ini.')

@section('content')
    <div class="mb-6 flex justify-between items-center">
        <a href="{{ route('orders.index') }}"
            class="inline-flex items-center text-sm text-slate-400 hover:text-white transition">
            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Daftar
        </a>

        <div class="flex items-center space-x-3">
            @if ($order->status === 'pending')
                <span
                    class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest bg-yellow-500/20 text-yellow-500 border border-yellow-500/30 animate-pulse">
                    Menunggu ACC Admin
                </span>
            @endif
            <span
                class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider 
            {{ $order->status === 'completed'
                ? 'bg-green-500/10 text-green-400'
                : ($order->status === 'cancelled'
                    ? 'bg-red-500/10 text-red-400'
                    : 'bg-blue-500/10 text-blue-400') }}">
                {{ $order->status }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            <!-- Main Info -->
            <div class="glass rounded-3xl p-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 pb-8 border-b border-white/5">
                    <div>
                        <h2 class="text-2xl font-bold text-white mb-1">{{ $order->service->name ?? 'Custom Service' }}</h2>
                        <p class="text-xs text-slate-500 font-mono">Order ID: {{ $order->order_number }}</p>
                    </div>
                    <div class="mt-4 md:mt-0 text-right">
                        @if(auth()->user()->role === 'provider')
                            <p class="text-xs text-slate-500 uppercase tracking-widest mb-1">Estimasi Pendapatan Net</p>
                            <h3 class="text-3xl font-bold text-green-400">Rp
                                {{ number_format(($order->total_price ?? 0) * 0.88, 0, ',', '.') }}</h3>
                            <p class="text-[10px] text-slate-500 mt-1">Setelah potongan platform 12%</p>
                        @else
                            <p class="text-xs text-slate-500 uppercase tracking-widest mb-1">Total Biaya</p>
                            <h3 class="text-3xl font-bold text-blue-400">Rp
                                {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</h3>
                        @endif
                    </div>

                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Client</p>
                        <p class="text-sm font-semibold text-white">{{ $order->client->name }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Provider</p>
                        <p class="text-sm font-semibold text-white">{{ $order->provider->name ?? 'Belum Ditentukan' }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Dibuat Pada</p>
                        <p class="text-sm font-semibold text-white">{{ $order->created_at->format('d M Y, H:i') }}</p>
                    </div>
                </div>

                <div class="mt-8">
                    <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-2">Catatan Pesanan & Brief</p>
                    <div class="p-4 bg-white/5 rounded-2xl text-sm text-slate-300 leading-relaxed whitespace-pre-wrap">
                        {{ $order->private_notes ?: 'Tidak ada catatan.' }}
                    </div>
                </div>
            </div>

            <!-- Admin ACC & Control Panel -->
            @if (auth()->user()->role === 'admin')
                <div class="glass border border-blue-500/30 rounded-3xl p-8 bg-blue-500/5">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-bold text-white flex items-center">
                            <svg class="h-5 w-5 mr-2 text-blue-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            ACC Order & Penugasan
                        </h3>
                        @if ($order->status === 'pending')
                            <span class="px-2 py-1 bg-blue-500 text-white text-[10px] font-bold rounded uppercase">Perlu
                                Tindakan</span>
                        @endif
                    </div>

                    <form action="{{ route('orders.update', $order) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <label for="provider_id" class="block text-xs font-bold text-slate-500 uppercase mb-2">Pilih
                                    Provider</label>
                                <select id="provider_id" name="provider_id"
                                    class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition">
                                    <option value="">-- Cari Provider Terbaik --</option>
                                    @foreach ($providers as $p)
                                        <option value="{{ $p->id }}"
                                            {{ $order->provider_id == $p->id ? 'selected' : '' }}>
                                            {{ $p->name }} ({{ $p->username }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="status" class="block text-xs font-bold text-slate-500 uppercase mb-2">Status
                                    Pesanan (ACC)</label>
                                <select id="status" name="status"
                                    class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition">
                                    <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending
                                        (Menunggu)</option>
                                    <option value="accepted" {{ $order->status == 'accepted' ? 'selected' : '' }}>Accepted
                                        (ACC & Siap Bayar)</option>
                                    <option value="in_progress" {{ $order->status == 'in_progress' ? 'selected' : '' }}>In
                                        Progress (Pengerjaan)</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>
                                        Completed (Selesai)</option>
                                    <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled (Dibatalkan)</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="total_price" class="block text-xs font-bold text-slate-500 uppercase mb-2">Harga
                                Final untuk Client (Rp)</label>
                            <input type="number" id="total_price" name="total_price"
                                class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white text-sm focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                                value="{{ $order->total_price }}" placeholder="Contoh: 500000">
                        </div>

                        <button type="submit"
                            class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl transition shadow-lg shadow-blue-600/30 flex items-center justify-center">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            ACC & Simpan Perubahan
                        </button>
                    </form>
                </div>
            @endif

            <!-- Provider Actions -->
            @if (auth()->user()->role === 'provider' && $order->provider_id === auth()->id())
                <div class="glass border border-green-500/30 rounded-3xl p-8">
                    <h3 class="text-lg font-bold text-white mb-6 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Provider Work Control
                    </h3>
                    <form action="{{ route('orders.update', $order) }}" method="POST" class="flex flex-col space-y-4">
                        @csrf
                        @method('PUT')
                        <div class="flex items-center space-x-4">
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Update Status</label>
                                <select name="status"
                                    class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-2 text-white text-sm focus:outline-none focus:ring-2 focus:ring-green-500/50 transition">
                                    <option value="in_progress" {{ $order->status == 'in_progress' ? 'selected' : '' }}>
                                        Sedang Dikerjakan</option>
                                    <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai
                                    </option>
                                </select>
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Progres (%)</label>
                                <input type="number" name="progress" min="0" max="100"
                                    value="{{ $order->progress ?? 0 }}"
                                    class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-2 text-white text-sm focus:outline-none focus:ring-2 focus:ring-green-500/50 transition">
                            </div>
                        </div>
                        <button type="submit"
                            class="w-full py-3 mt-2 bg-green-600 hover:bg-green-700 text-white text-sm font-bold rounded-xl transition">
                            Update Progres & Status
                        </button>
                    </form>

                    {{-- Upload file hasil kerja / deliverable --}}
                    <div class="mt-6 pt-6 border-t border-white/5">
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center">
                            <svg class="h-4 w-4 mr-1.5 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            Upload File Hasil Kerja
                        </p>
                        <form action="{{ route('orders.files.upload', $order) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-emerald-500/30 rounded-2xl cursor-pointer hover:border-emerald-400/60 hover:bg-emerald-500/5 transition group">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-8 h-8 mb-2 text-emerald-500/50 group-hover:text-emerald-400 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="text-xs text-slate-400 group-hover:text-slate-200 transition">Klik untuk upload file jawaban / deliverable</p>
                                    <p class="text-[10px] text-slate-600 mt-1 uppercase tracking-widest">PDF, DOC, ZIP, IMG (Max 50MB)</p>
                                </div>
                                <input type="file" name="file" class="hidden" onchange="this.form.submit()">
                            </label>
                        </form>

                        {{-- Daftar file yang sudah diupload provider --}}
                        @if ($providerFiles->count() > 0)
                            <div class="mt-4 space-y-2">
                                @foreach ($providerFiles as $file)
                                    <div class="p-3 bg-emerald-500/5 border border-emerald-500/20 rounded-xl flex items-center justify-between">
                                        <div class="flex items-center overflow-hidden">
                                            <svg class="h-4 w-4 text-emerald-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <span class="text-[11px] text-slate-300 truncate">{{ $file->file_name }}</span>
                                        </div>
                                        <a href="{{ route('orders.download', [$order, $file]) }}?token={{ $file->access_token }}"
                                            class="text-[10px] text-emerald-400 font-bold uppercase hover:underline flex-shrink-0 ml-2">Download</a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payout Status for Provider -->
                <div
                    class="glass border {{ $order->provider_payment_status === 'paid' ? 'border-green-500/30' : 'border-red-500/30' }} rounded-3xl p-8 mt-6">
                    <h3 class="text-lg font-bold text-white mb-4">Status Payout (Pembayaran Provider)</h3>
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-xs text-slate-400 mb-1">Status Pembayaran dari Admin</p>
                            @if ($order->provider_payment_status === 'paid')
                                <span
                                    class="px-3 py-1 bg-green-500/10 text-green-400 font-bold uppercase tracking-widest rounded text-xs">Sudah
                                    Dibayar</span>
                            @else
                                <span
                                    class="px-3 py-1 bg-red-500/10 text-red-400 font-bold uppercase tracking-widest rounded text-xs">Belum
                                    Dibayar</span>
                            @endif
                        </div>
                        @if ($order->provider_payment_status === 'paid' && $order->provider_payment_proof_path)
                            <div>
                                <a href="{{ Storage::url($order->provider_payment_proof_path) }}" target="_blank"
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition inline-flex items-center">
                                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    Lihat Bukti Transfer
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Client Payment Section -->
            @if (auth()->user()->role === 'client' &&
                    $order->client_id === auth()->id() &&
                    $order->status === 'accepted' &&
                    $order->payment_status === 'unpaid')
                <div class="glass border border-yellow-500/30 rounded-3xl p-8 bg-yellow-500/5">
                    <h3 class="text-lg font-bold text-white mb-6 flex items-center">
                        <svg class="h-5 w-5 mr-2 text-yellow-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Pembayaran Pesanan
                    </h3>

                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase mb-4">Pilih Metode Pembayaran</p>
                            <div class="space-y-3">
                                @foreach ($paymentMethods as $method)
                                    <div class="p-4 bg-white/5 border border-white/10 rounded-2xl">
                                        <p class="text-xs font-bold text-blue-400 uppercase tracking-widest">
                                            {{ $method->name }}</p>
                                        <p class="text-lg font-bold text-white mt-1">{{ $method->account_number }}</p>
                                        @if ($method->account_name)
                                            <p class="text-[10px] text-slate-500 uppercase mt-1">a/n
                                                {{ $method->account_name }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <p class="text-xs font-bold text-slate-500 uppercase mb-4">Upload Bukti Transfer</p>
                            <form action="{{ route('payments.store', $order) }}" method="POST"
                                enctype="multipart/form-data" class="space-y-4">
                                @csrf
                                <input type="hidden" name="payment_method" value="manual_transfer">

                                <div class="relative group">
                                    <label
                                        class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-white/10 rounded-2xl cursor-pointer hover:border-blue-500/50 hover:bg-blue-500/5 transition">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <svg class="w-10 h-10 mb-3 text-slate-500 group-hover:text-blue-400 transition"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                            </svg>
                                            <p class="text-sm text-slate-400 group-hover:text-slate-300 transition">Klik
                                                untuk upload bukti</p>
                                            <p class="text-[10px] text-slate-500 mt-1 uppercase tracking-widest">JPG, PNG,
                                                PDF (Max 2MB)</p>
                                        </div>
                                        <input type="file" name="payment_proof" class="hidden" required
                                            onchange="this.parentElement.nextElementSibling.innerText = this.files[0].name" />
                                    </label>
                                    <p class="mt-2 text-[10px] text-blue-400 text-center font-mono italic"></p>
                                </div>

                                <button type="submit"
                                    class="w-full py-4 bg-yellow-600 hover:bg-yellow-700 text-white font-bold rounded-2xl transition shadow-lg shadow-yellow-600/30">
                                    Konfirmasi Pembayaran
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            @if (
                $order->payment_status === 'pending' ||
                    ($order->payment_status === 'unpaid' && $order->payments()->where('status', 'pending')->exists()))
                <div class="glass border border-blue-500/30 rounded-3xl p-8 bg-blue-500/5">
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center text-blue-400">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-sm font-bold uppercase tracking-widest">Pembayaran Sedang Diverifikasi</span>
                        </div>
                        @php $lastPayment = $order->payments()->latest()->first(); @endphp
                        @if ($lastPayment && $lastPayment->payment_proof)
                            <a href="{{ Storage::url($lastPayment->payment_proof) }}" target="_blank"
                                class="text-[10px] text-blue-400 hover:underline flex items-center">
                                <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat Bukti Terkirim
                            </a>
                        @endif
                    </div>
                    <p class="text-xs text-slate-400">Bukti pembayaran Anda telah diterima dan sedang diperiksa oleh tim
                        finance kami. Mohon tunggu proses validasi selesai.</p>
                </div>
            @endif

            {{-- ===== SECTION REVISI (Client Only, status completed, window 2 hari) ===== --}}
            @if (auth()->user()->role === 'client' && $order->client_id === auth()->id())
                @php
                    $canRevise      = $order->canRequestRevision();
                    $windowEnd      = $order->revisionWindowEndsAt();
                    $revisionUsed   = $order->revision_count ?? 0;
                    $revisionMax    = 5;
                    $revisionLeft   = max(0, $revisionMax - $revisionUsed);
                    $orderCompleted = $order->status === 'completed';
                    // Tampilkan section jika: pernah completed (ada completed_at), sedang in_progress setelah revisi, atau ada riwayat revisi
                    $showRevisionSection = $orderCompleted || $revisionUsed > 0 || ($order->completed_at !== null);
                @endphp

                @if ($showRevisionSection)
                    <div id="revision-section"
                        class="glass rounded-3xl p-8 border {{ $canRevise ? 'border-orange-500/30 bg-orange-500/3' : 'border-white/5' }}">

                        {{-- Header --}}
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex items-center">
                                <div class="h-10 w-10 rounded-2xl bg-orange-500/10 flex items-center justify-center mr-4">
                                    <svg class="h-5 w-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-white">Pengajuan Revisi</h3>
                                    <p class="text-[11px] text-slate-500">Setelah status menjadi <span class="text-orange-400 font-semibold">COMPLETED</span>, Anda memiliki waktu <span class="text-white font-semibold">2 hari</span> untuk mengajukan revisi.</p>
                                </div>
                            </div>
                            {{-- Sisa Revisi Badge --}}
                            <div class="text-right">
                                <p class="text-[10px] text-slate-500 uppercase tracking-widest">Sisa Revisi</p>
                                <p class="text-2xl font-black {{ $revisionLeft > 0 ? 'text-orange-400' : 'text-red-500' }}">
                                    {{ $revisionLeft }}<span class="text-sm font-normal text-slate-500">/{{ $revisionMax }}</span>
                                </p>
                            </div>
                        </div>

                        {{-- Progress bar revisi --}}
                        <div class="mb-6">
                            <div class="flex justify-between text-[10px] text-slate-500 uppercase tracking-widest mb-1.5">
                                <span>Revisi Terpakai</span>
                                <span>{{ $revisionUsed }}/{{ $revisionMax }}</span>
                            </div>
                            <div class="w-full h-1.5 bg-white/5 rounded-full overflow-hidden">
                                <div class="h-full rounded-full transition-all duration-700
                                    {{ $revisionUsed >= $revisionMax ? 'bg-red-500' : ($revisionUsed >= 3 ? 'bg-orange-400' : 'bg-orange-500') }}"
                                    style="width: {{ ($revisionUsed / $revisionMax) * 100 }}%">
                                </div>
                            </div>
                        </div>

                        @if ($canRevise)
                            {{-- Countdown window --}}
                            @if ($windowEnd)
                                <div class="mb-6 p-3 bg-orange-500/10 border border-orange-500/20 rounded-2xl flex items-center">
                                    <svg class="h-4 w-4 text-orange-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <div>
                                        <p class="text-[11px] text-orange-300 font-semibold">Batas waktu revisi (2 hari sejak status COMPLETED):</p>
                                        <p class="text-xs text-white font-bold">{{ $windowEnd->format('d M Y, H:i') }}
                                            <span class="text-orange-400 font-normal">({{ $windowEnd->diffForHumans() }})</span>
                                        </p>
                                        @if ($order->completed_at)
                                            <p class="text-[10px] text-slate-500 mt-0.5">Status COMPLETED sejak: {{ $order->completed_at->format('d M Y, H:i') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            {{-- Tombol Tidak Sesuai & Form Revisi --}}
                            <div x-data="{ showForm: false }">
                                <button @click="showForm = !showForm"
                                    class="w-full py-4 rounded-2xl font-bold text-sm transition flex items-center justify-center
                                        bg-orange-500/10 hover:bg-orange-500/20 text-orange-400 border border-orange-500/30 hover:border-orange-400/60"
                                    :class="showForm ? 'ring-2 ring-orange-500/40' : ''">
                                    <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <span x-text="showForm ? 'Tutup Form Revisi' : '⚠ Hasil Tidak Sesuai — Ajukan Revisi'"></span>
                                </button>

                                <div x-show="showForm" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    class="mt-4">
                                    <form action="{{ route('orders.revisions.store', $order) }}" method="POST"
                                        class="space-y-4 p-6 bg-white/3 border border-orange-500/20 rounded-2xl">
                                        @csrf
                                        <div>
                                            <label for="request_details" class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
                                                Jelaskan keluhan / bagian yang tidak sesuai
                                            </label>
                                            <textarea
                                                id="request_details"
                                                name="request_details"
                                                rows="5"
                                                maxlength="2000"
                                                placeholder="Contoh: Pada soal nomor 3, jawaban yang diberikan kurang lengkap. Mohon ditambahkan penjelasan mengenai..."
                                                class="w-full bg-[#0f172a] border border-white/10 focus:border-orange-500/50 rounded-xl px-4 py-3 text-white text-sm placeholder-slate-600 resize-none focus:outline-none focus:ring-2 focus:ring-orange-500/30 transition"
                                                required>{{ old('request_details') }}</textarea>
                                            <p class="text-[10px] text-slate-500 mt-1 text-right">Maksimal 2000 karakter</p>
                                        </div>

                                        <div class="flex items-center justify-between pt-2">
                                            <div class="text-[11px] text-slate-500">
                                                <span class="text-orange-400 font-bold">{{ $revisionLeft }}</span> revisi tersisa
                                                dari {{ $revisionMax }} total
                                            </div>
                                            <button type="submit"
                                                class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold rounded-xl transition shadow-lg shadow-orange-500/20 flex items-center">
                                                <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                                </svg>
                                                Kirim Permintaan Revisi
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        @elseif ($orderCompleted && $revisionUsed < $revisionMax)
                            {{-- Window sudah habis --}}
                            <div class="p-4 bg-slate-500/5 border border-slate-500/20 rounded-2xl text-center">
                                <svg class="h-8 w-8 mx-auto mb-2 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-sm font-semibold text-slate-400">Batas Waktu Revisi Habis</p>
                                <p class="text-[11px] text-slate-600 mt-1">
                                    Window 2 hari sejak status diubah menjadi COMPLETED
                                    @if ($order->completed_at)
                                        ({{ $order->completed_at->format('d M Y, H:i') }})
                                    @endif
                                    telah berakhir.
                                </p>
                            </div>

                        @elseif ($revisionUsed >= $revisionMax)
                            {{-- Kuota habis --}}
                            <div class="p-4 bg-red-500/5 border border-red-500/20 rounded-2xl text-center">
                                <svg class="h-8 w-8 mx-auto mb-2 text-red-500/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                                </svg>
                                <p class="text-sm font-semibold text-red-400">Kuota Revisi Habis</p>
                                <p class="text-[11px] text-slate-500 mt-1">Anda telah menggunakan {{ $revisionMax }} revisi. Hubungi customer service jika diperlukan.</p>
                            </div>
                        @endif
                    </div>
                @endif
            @endif
            {{-- ===== END SECTION REVISI ===== --}}

            {{-- ===== NOTIF REVISI PENDING (Admin & Provider) ===== --}}
            @if (in_array(auth()->user()->role, ['admin', 'provider']) && $order->revisions->where('status', 'pending')->count() > 0)
                @php $pendingRevisions = $order->revisions->where('status', 'pending'); @endphp
                <div class="glass rounded-3xl p-8 border border-orange-500/40 bg-orange-500/5">
                    <div class="flex items-center mb-5">
                        <div class="relative mr-4">
                            <div class="h-10 w-10 rounded-2xl bg-orange-500/15 flex items-center justify-center">
                                <svg class="h-5 w-5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                            </div>
                            <span class="absolute -top-1 -right-1 h-4 w-4 bg-orange-500 rounded-full text-[9px] text-white font-bold flex items-center justify-center animate-pulse">
                                {{ $pendingRevisions->count() }}
                            </span>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white">Permintaan Revisi dari Client</h3>
                            <p class="text-[11px] text-slate-500">{{ $pendingRevisions->count() }} revisi menunggu ditindaklanjuti</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach ($pendingRevisions->sortByDesc('created_at') as $revision)
                            <div class="p-5 bg-white/3 border border-orange-500/20 rounded-2xl">
                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center">
                                        <span class="h-2 w-2 rounded-full bg-orange-400 animate-pulse mr-2"></span>
                                        <span class="text-[10px] font-bold uppercase tracking-widest text-orange-400">Menunggu Tindakan</span>
                                    </div>
                                    <span class="text-[10px] text-slate-500">{{ $revision->created_at->format('d M Y, H:i') }}</span>
                                </div>

                                <p class="text-sm text-slate-200 leading-relaxed mb-4 whitespace-pre-wrap">{{ $revision->request_details }}</p>

                                @if (auth()->user()->role === 'provider' || auth()->user()->role === 'admin')
                                    <form action="{{ route('revisions.update', $revision) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex space-x-3">
                                            <button type="submit" name="status" value="in_progress"
                                                class="flex-1 py-2.5 text-xs font-bold uppercase bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 rounded-xl border border-blue-500/20 hover:border-blue-400/40 transition flex items-center justify-center">
                                                <svg class="h-3.5 w-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Mulai Proses
                                            </button>
                                            <button type="submit" name="status" value="completed"
                                                class="flex-1 py-2.5 text-xs font-bold uppercase bg-green-500/10 hover:bg-green-500/20 text-green-400 rounded-xl border border-green-500/20 hover:border-green-400/40 transition flex items-center justify-center">
                                                <svg class="h-3.5 w-3.5 mr-1.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                Tandai Selesai
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            {{-- ===== END NOTIF REVISI ===== --}}
        </div>

        <div class="space-y-8">
            <!-- Progress Summary -->
            <div class="glass rounded-3xl p-6">
                <h3 class="font-bold text-white mb-4">Milestone Progress</h3>
                <div class="relative pt-1">
                    <div class="flex mb-2 items-center justify-between">
                        <div>
                            <span
                                class="text-[10px] font-bold inline-block py-1 px-2 uppercase rounded-full text-blue-400 bg-blue-200/10 tracking-widest">
                                Task Progress
                            </span>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold text-blue-400">
                                {{ $order->progress ?? 0 }}%
                            </span>
                        </div>
                    </div>
                    <div class="overflow-hidden h-2 mb-4 text-xs flex rounded-full bg-white/5">
                        <div style="width:{{ $order->progress ?? 0 }}%"
                            class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500 transition-all duration-1000">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Files & Lampiran Client --}}
            <div class="glass rounded-3xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-white flex items-center">
                        <svg class="h-4 w-4 mr-2 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.414 6.586a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        Files & Lampiran
                    </h3>
                    @if (auth()->user()->role === 'client')
                        <form action="{{ route('orders.files.upload', $order) }}" method="POST"
                            enctype="multipart/form-data" class="relative">
                            @csrf
                            <label class="cursor-pointer text-xs text-blue-400 hover:underline">
                                Upload File
                                <input type="file" name="file" class="hidden" onchange="this.form.submit()">
                            </label>
                        </form>
                    @endif
                </div>
                <div class="space-y-3">
                    @forelse($clientFiles as $file)
                        <div
                            class="p-3 bg-white/5 rounded-xl flex items-center justify-between group hover:bg-white/10 transition">
                            <div class="flex items-center overflow-hidden">
                                <svg class="h-4 w-4 text-slate-500 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="text-[11px] text-slate-300 truncate">{{ $file->file_name }}</span>
                            </div>
                            <a href="{{ route('orders.download', [$order, $file]) }}?token={{ $file->access_token }}"
                                class="text-[10px] text-blue-400 font-bold uppercase hover:underline flex-shrink-0 ml-2">Download</a>
                        </div>
                    @empty
                        <p class="text-[10px] text-slate-500 italic">Belum ada file lampiran dari client.</p>
                    @endforelse
                </div>
            </div>

            {{-- File Hasil Kerja Provider — hanya tampil jika ada file dari provider --}}
            @if ($providerFiles->count() > 0)
                <div class="glass rounded-3xl p-6 border border-emerald-500/20 bg-emerald-500/3">
                    <div class="flex items-center mb-4">
                        <div class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse mr-3"></div>
                        <h3 class="font-bold text-white flex items-center">
                            <svg class="h-4 w-4 mr-2 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                            </svg>
                            File Hasil Kerja Provider
                        </h3>
                        <span class="ml-auto text-[10px] font-bold uppercase tracking-widest px-2 py-1 bg-emerald-500/15 text-emerald-400 rounded-full">
                            {{ $providerFiles->count() }} File
                        </span>
                    </div>
                    <p class="text-[11px] text-slate-500 mb-4 italic">Berikut adalah file jawaban / deliverable yang telah dikirim oleh provider.</p>
                    <div class="space-y-3">
                        @foreach ($providerFiles as $file)
                            <div class="p-3 bg-emerald-500/5 border border-emerald-500/20 rounded-xl flex items-center justify-between group hover:bg-emerald-500/10 transition">
                                <div class="flex items-center overflow-hidden">
                                    <svg class="h-4 w-4 text-emerald-400 mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <div>
                                        <span class="text-[11px] text-slate-200 font-medium truncate block">{{ $file->file_name }}</span>
                                        <span class="text-[9px] text-slate-500 uppercase tracking-widest">{{ $file->created_at->format('d M Y, H:i') }}</span>
                                    </div>
                                </div>
                                <a href="{{ route('orders.download', [$order, $file]) }}?token={{ $file->access_token }}"
                                    class="flex items-center text-[10px] text-emerald-400 font-bold uppercase hover:underline flex-shrink-0 ml-2">
                                    <svg class="h-3 w-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Riwayat Revisi --}}
            @if ($order->revisions->count() > 0)
                <div class="glass rounded-3xl p-6 border border-orange-500/10">
                    <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4 flex items-center">
                        <svg class="h-3.5 w-3.5 mr-1.5 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Riwayat Revisi ({{ $order->revision_count }}/5)
                    </h3>
                    <div class="space-y-3">
                        @foreach ($order->revisions->sortByDesc('created_at') as $revision)
                            <div class="p-3 bg-white/3 rounded-xl border border-white/5">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="inline-flex items-center text-[10px] font-bold uppercase tracking-widest
                                        {{ $revision->status === 'completed' ? 'text-green-400' : ($revision->status === 'in_progress' ? 'text-blue-400' : 'text-orange-400') }}">
                                        @if ($revision->status === 'completed')
                                            <svg class="h-3 w-3 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                            Selesai
                                        @elseif ($revision->status === 'in_progress')
                                            <svg class="h-3 w-3 mr-1 flex-shrink-0 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                            Diproses
                                        @else
                                            <svg class="h-3 w-3 mr-1 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            Menunggu
                                        @endif
                                    </span>
                                    <span class="text-[9px] text-slate-600">{{ $revision->created_at->format('d M Y') }}</span>
                                </div>
                                <p class="text-[11px] text-slate-300 leading-relaxed line-clamp-3">{{ $revision->request_details }}</p>
                                @if (auth()->user()->role === 'provider' && $revision->status !== 'completed')
                                    <form action="{{ route('revisions.update', $revision) }}" method="POST" class="mt-3">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex space-x-2">
                                            <button type="submit" name="status" value="in_progress"
                                                class="flex-1 py-1.5 text-[10px] font-bold uppercase bg-blue-500/10 hover:bg-blue-500/20 text-blue-400 rounded-lg border border-blue-500/20 transition">
                                                Proses
                                            </button>
                                            <button type="submit" name="status" value="completed"
                                                class="flex-1 py-1.5 text-[10px] font-bold uppercase bg-green-500/10 hover:bg-green-500/20 text-green-400 rounded-lg border border-green-500/20 transition">
                                                Selesai
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Review / Rating Section --}}
            @if ($order->review)
                <div class="glass rounded-3xl p-6 border border-yellow-500/20 bg-yellow-500/5">
                    <h3 class="font-bold text-white mb-4 flex items-center">
                        <svg class="h-4 w-4 mr-2 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.71-1.838-.197-1.539-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.382-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                        Rating dari Client
                    </h3>
                    <div class="flex items-center mb-3">
                        <div class="flex text-yellow-400 mr-3">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="h-5 w-5 {{ $i <= $order->review->rating ? 'text-yellow-400' : 'text-slate-600' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <span class="text-xs text-slate-400">{{ $order->review->created_at->format('d M Y') }}</span>
                    </div>
                    <p class="text-sm text-slate-300 italic">"{{ $order->review->comment ?? 'Tidak ada komentar.' }}"</p>
                </div>
            @elseif (auth()->user()->role === 'client' && in_array($order->status, ['in_progress', 'completed']))
                <div x-data="{ showReviewForm: false }" class="glass rounded-3xl p-6 border border-yellow-500/20">
                    <div class="text-center" x-show="!showReviewForm">
                        <svg class="h-12 w-12 mx-auto text-yellow-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="font-bold text-white mb-2">Selesaikan Pesanan</h3>
                        <p class="text-xs text-slate-400 mb-6">Jika pekerjaan sudah sesuai, Anda dapat menyelesaikan pesanan ini dan memberikan rating kepada provider.</p>
                        <button @click="showReviewForm = true" class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-xl transition shadow-lg shadow-yellow-500/20">
                            Selesaikan & Beri Rating
                        </button>
                    </div>

                    <form x-show="showReviewForm" action="{{ route('reviews.store', $order) }}" method="POST" style="display: none;" x-transition>
                        @csrf
                        <h3 class="font-bold text-white mb-4">Beri Rating Provider</h3>
                        
                        <div class="mb-4">
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Rating (1-5)</label>
                            <div class="flex space-x-2">
                                @for($i=1; $i<=5; $i++)
                                    <label class="cursor-pointer group relative">
                                        <input type="radio" name="rating" value="{{ $i }}" class="absolute opacity-0 w-0 h-0" required
                                               onchange="
                                                   let siblings = this.closest('.flex').querySelectorAll('svg');
                                                   siblings.forEach((svg, index) => {
                                                       if (index < {{ $i }}) {
                                                           svg.classList.add('text-yellow-400');
                                                           svg.classList.remove('text-slate-600');
                                                       } else {
                                                           svg.classList.remove('text-yellow-400');
                                                           svg.classList.add('text-slate-600');
                                                       }
                                                   });
                                               ">
                                        <svg class="h-8 w-8 text-slate-600 group-hover:text-yellow-400 transition hover:scale-110" 
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                        </div>

                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-400 uppercase mb-2">Pesan / Ulasan (Opsional)</label>
                            <textarea name="comment" rows="3" class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-yellow-500/50 transition resize-none" placeholder="Bagaimana pengalaman Anda bekerja dengan provider ini?"></textarea>
                        </div>

                        <div class="flex justify-end space-x-3">
                            <button type="button" @click="showReviewForm = false" class="px-4 py-2 bg-white/5 hover:bg-white/10 text-white font-bold rounded-xl transition">
                                Batal
                            </button>
                            <button type="submit" class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-xl transition shadow-lg shadow-yellow-500/20">
                                Kirim Rating
                            </button>
                        </div>
                    </form>
                </div>
            @endif

            <!-- Activity Log -->
            <div class="glass rounded-3xl p-6 border-t border-white/5">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Aktivitas Terakhir</h3>
                <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($order->trackingLogs->sortByDesc('created_at') as $log)
                        <div class="flex items-start space-x-3">
                            <div class="h-2 w-2 rounded-full {{ $loop->first ? 'bg-blue-500 animate-pulse' : 'bg-slate-600' }} mt-1.5 flex-shrink-0"></div>
                            <div>
                                <p class="text-xs text-white leading-relaxed">{{ $log->remarks }}</p>
                                <p class="text-[9px] text-slate-500 uppercase mt-1">{{ $log->created_at->diffForHumans() }} • Oleh {{ $log->changer->name ?? 'System' }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-[10px] text-slate-500 italic">Belum ada aktivitas tercatat.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
