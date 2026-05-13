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
                        <p class="text-xs text-slate-500 uppercase tracking-widest mb-1">Total Biaya</p>
                        <h3 class="text-3xl font-bold text-blue-400">Rp
                            {{ number_format($order->total_price ?? 0, 0, ',', '.') }}</h3>
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
                    <h3 class="text-lg font-bold text-white mb-6">Provider Work Control</h3>
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

            <!-- Files Section -->
            <div class="glass rounded-3xl p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-bold text-white">Files & Lampiran</h3>
                    @if (auth()->user()->role !== 'admin')
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
                    @forelse($order->files as $file)
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
                        <p class="text-[10px] text-slate-500 italic">Belum ada file yang diunggah.</p>
                    @endforelse
                </div>
            </div>

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
