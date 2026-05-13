@extends('layouts.' . auth()->user()->role)

@section('title', 'Pesan Layanan')
@section('header', 'Buat Pesanan Baru')
@section('subheader', 'Pilih kategori dan layanan joki IT yang Anda butuhkan.')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('orders.index') }}" class="inline-flex items-center text-sm text-slate-400 hover:text-white transition mb-6">
        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="glass rounded-3xl p-8">
        <form action="{{ route('orders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-sm font-medium text-slate-300 mb-2">Pilih Kategori</label>
                    <select id="category_id" class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition appearance-none">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="service_id" class="block text-sm font-medium text-slate-300 mb-2">Pilih Layanan</label>
                    <select id="service_id" name="service_id" required
                            class="w-full bg-[#0f172a] border @error('service_id') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition appearance-none">
                        <option value="">Pilih Layanan...</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" data-category="{{ $service->category_id }}" {{ old('service_id', request('service_id')) == $service->id ? 'selected' : '' }}>
                                {{ $service->name }} (Rp {{ number_format($service->min_price, 0, ',', '.') }}+)
                            </option>
                        @endforeach
                    </select>
                    @error('service_id') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="attachments" class="block text-sm font-medium text-slate-300 mb-2">Lampiran File (PDF, Word, Img, Zip)</label>
                <div class="border-2 border-dashed border-white/10 rounded-2xl p-6 text-center hover:border-blue-500/50 transition cursor-pointer relative group">
                    <input type="file" name="attachments[]" id="attachments" multiple class="absolute inset-0 opacity-0 cursor-pointer">
                    <div class="space-y-2">
                        <svg class="mx-auto h-8 w-8 text-slate-500 group-hover:text-blue-400 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                        </svg>
                        <p class="text-xs text-slate-400" id="file-label">Klik atau drop file di sini (Max 20MB)</p>
                    </div>
                </div>
                @error('attachments.*') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="payment_type" class="block text-sm font-medium text-slate-300 mb-2">Metode Pembayaran</label>
                    <select id="payment_type" name="payment_type" required
                            class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition appearance-none">
                        <option value="fixed" {{ old('payment_type') == 'fixed' ? 'selected' : '' }}>Bayar Lunas</option>
                        <option value="dp" {{ old('payment_type') == 'dp' ? 'selected' : '' }}>DP (Uang Muka)</option>
                        <option value="negotiable" {{ old('payment_type') == 'negotiable' ? 'selected' : '' }}>Nego Harga</option>
                    </select>
                </div>

                <div>
                    <label for="estimated_completion" class="block text-sm font-medium text-slate-300 mb-2">Estimasi Deadline</label>
                    <input type="text" id="estimated_completion" name="estimated_completion" 
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                           placeholder="Contoh: 3 Hari / ASAP" value="{{ old('estimated_completion') }}">
                </div>
            </div>

            <div>
                <label for="private_notes" class="block text-sm font-medium text-slate-300 mb-2">Detail Kebutuhan & Brief</label>
                <textarea id="private_notes" name="private_notes" rows="5" required
                          class="w-full bg-white/5 border @error('private_notes') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                          placeholder="Jelaskan secara detail instruksi project Anda...">{{ old('private_notes', (request('title') ? 'JUDUL PROJECT: ' . request('title') . "\n\n" : '') . request('description')) }}</textarea>
                @error('private_notes') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl transition shadow-lg shadow-blue-600/20 flex items-center justify-center">
                    <span>Kirim Pesanan ke Admin</span>
                    <svg class="ml-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('category_id').addEventListener('change', function() {
    const categoryId = this.value;
    const serviceSelect = document.getElementById('service_id');
    const options = serviceSelect.querySelectorAll('option');

    options.forEach(option => {
        if (!categoryId || option.getAttribute('data-category') === categoryId || option.value === "") {
            option.style.display = 'block';
        } else {
            option.style.display = 'none';
        }
    });

    if (categoryId && serviceSelect.selectedOptions[0]?.getAttribute('data-category') !== categoryId) {
        serviceSelect.value = "";
    }
});

// Auto-trigger category filter if a service or category is pre-selected via query param
window.addEventListener('DOMContentLoaded', (event) => {
    const serviceSelect = document.getElementById('service_id');
    const categorySelect = document.getElementById('category_id');
    
    const filterServices = (categoryId) => {
        const options = serviceSelect.querySelectorAll('option');
        options.forEach(option => {
            if (!categoryId || option.getAttribute('data-category') === categoryId || option.value === "") {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
    };

    if (serviceSelect.value) {
        const selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
        const categoryId = selectedOption.getAttribute('data-category');
        if (categoryId) {
            categorySelect.value = categoryId;
            filterServices(categoryId);
        }
    } else if (categorySelect.value) {
        filterServices(categorySelect.value);
    }
});

document.getElementById('attachments').addEventListener('change', function() {
    const files = this.files;
    const label = document.getElementById('file-label');
    if (files.length > 0) {
        label.innerText = files.length + ' file terpilih';
        label.classList.add('text-blue-400', 'font-bold');
    } else {
        label.innerText = 'Klik atau drop file di sini (Max 20MB)';
        label.classList.remove('text-blue-400', 'font-bold');
    }
});
</script>
@endsection
