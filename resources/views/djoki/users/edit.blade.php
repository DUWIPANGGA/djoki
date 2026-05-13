@extends('layouts.admin')

@section('title', 'Edit User')
@section('header', 'Edit Profil & Peran User')
@section('subheader', 'Ubah informasi dasar, peran, dan status akses pengguna.')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm text-slate-400 hover:text-white transition mb-6">
        <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Daftar
    </a>

    <div class="glass rounded-3xl p-8">
        <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required 
                           class="w-full bg-white/5 border @error('name') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                           value="{{ old('name', $user->name) }}">
                    @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="username" class="block text-sm font-medium text-slate-300 mb-2">Username</label>
                    <input type="text" id="username" name="username" required 
                           class="w-full bg-white/5 border @error('username') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                           value="{{ old('username', $user->username) }}">
                    @error('username') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                <input type="email" id="email" name="email" required 
                       class="w-full bg-white/5 border @error('email') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition"
                       value="{{ old('email', $user->email) }}">
                @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label for="role" class="block text-sm font-medium text-slate-300 mb-2">Peran (Role)</label>
                    <select id="role" name="role" required
                            class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition appearance-none">
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="provider" {{ old('role', $user->role) === 'provider' ? 'selected' : '' }}>Provider (Joki)</option>
                        <option value="client" {{ old('role', $user->role) === 'client' ? 'selected' : '' }}>Client (User)</option>
                    </select>
                    @error('role') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="is_active" class="block text-sm font-medium text-slate-300 mb-2">Status Akun</label>
                    <select id="is_active" name="is_active" required
                            class="w-full bg-[#0f172a] border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition appearance-none">
                        <option value="1" {{ old('is_active', $user->is_active) ? 'selected' : '' }}>Aktif</option>
                        <option value="0" {{ !old('is_active', $user->is_active) ? 'selected' : '' }}>Non-aktif / Banned</option>
                    </select>
                    @error('is_active') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="p-6 bg-yellow-500/10 border border-yellow-500/20 rounded-2xl">
                <h4 class="text-sm font-bold text-yellow-500 mb-2">Ganti Password (Opsional)</h4>
                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <input type="password" name="password" placeholder="Password baru"
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition">
                    </div>
                    <div>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi password baru"
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition">
                    </div>
                </div>
                <p class="mt-2 text-[10px] text-slate-500 italic">Kosongkan jika tidak ingin mengubah password.</p>
                @error('password') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4">
                <button type="submit" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-2xl transition shadow-lg shadow-blue-600/20">
                    Simpan Perubahan User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
