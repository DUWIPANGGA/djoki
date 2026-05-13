<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun - D'JOKI</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#0f172a] min-h-screen flex items-center justify-center p-6">
    <div class="absolute inset-0 z-0 overflow-hidden">
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-indigo-600/10 blur-[120px] rounded-full"></div>
    </div>

    <div class="w-full max-w-lg relative z-10">
        <div class="text-center mb-8">
            <a href="/" class="text-3xl font-bold text-gradient inline-block mb-2">D'JOKI</a>
            <p class="text-slate-400">Bergabunglah dengan komunitas IT joki terbaik.</p>
        </div>

        <div class="glass p-8 rounded-3xl">
            <form action="{{ route('register') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required 
                               class="w-full bg-white/5 border @error('name') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition"
                               placeholder="Budi Santoso" value="{{ old('name') }}">
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror

                    </div>
                    <div>
                        <label for="username" class="block text-sm font-medium text-slate-300 mb-2">Username</label>
                        <input type="text" id="username" name="username" required 
                               class="w-full bg-white/5 border @error('username') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition"
                               placeholder="budi_tech" value="{{ old('username') }}">
                        @error('username')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror

                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" required 
                           class="w-full bg-white/5 border @error('email') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition"
                           placeholder="nama@email.com" value="{{ old('email') }}">
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                </div>

                <div>
                    <label for="role" class="block text-sm font-medium text-slate-300 mb-2">Saya Ingin Menjadi</label>
                    <select id="role" name="role" class="w-full bg-white/5 border @error('role') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 transition appearance-none">
                        <option value="client" class="bg-[#0f172a]" {{ old('role') == 'client' ? 'selected' : '' }}>Pemesan Joki (Client)</option>
                        <option value="provider" class="bg-[#0f172a]" {{ old('role') == 'provider' ? 'selected' : '' }}>Penyedia Joki (Freelancer)</option>
                    </select>
                    @error('role')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror

                </div>

                <div class="grid md:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                        <input type="password" id="password" name="password" required 
                               class="w-full bg-white/5 border @error('password') border-red-500 @else border-white/10 @enderror rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition"
                               placeholder="••••••••">
                        @error('password')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror

                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required 
                               class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-500/50 focus:border-blue-500/50 transition"
                               placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="terms" name="terms" required class="w-4 h-4 rounded border-white/10 bg-white/5 text-blue-600 focus:ring-blue-500/50">
                    <label for="terms" class="ml-2 text-sm text-slate-400">Saya setuju dengan <a href="#" class="text-blue-400 hover:underline">Syarat & Ketentuan</a></label>
                </div>

                <button type="submit" class="w-full btn-premium py-4">
                    Buat Akun Sekarang
                </button>
            </form>

            <div class="mt-8 pt-6 border-t border-white/10 text-center">
                <p class="text-slate-400 text-sm">
                    Sudah punya akun? 
                    <a href="/login" class="text-blue-400 font-bold hover:underline">Masuk Disini</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
