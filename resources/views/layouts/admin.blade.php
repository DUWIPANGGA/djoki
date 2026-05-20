<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard') - D'JOKI</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body { font-family: 'Outfit', sans-serif; }
        .glass {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .sidebar-item-active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, rgba(59, 130, 246, 0) 100%);
            border-left: 3px solid #3b82f6;
            color: #3b82f6;
        }
        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.02);
            color: #3b82f6;
        }
        .text-gradient {
            background: linear-gradient(to right, #60a5fa, #a855f7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body class="bg-[#0f172a] text-slate-200 min-h-screen">
    <div class="flex flex-col lg:flex-row min-h-screen">
        <!-- Sidebar Backdrop (mobile & tablet) -->
        <div id="sidebar-backdrop" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 hidden lg:hidden" aria-hidden="true"></div>

        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 w-72 max-w-[85vw] h-screen border-r border-white/5 bg-[#0f172a]/95 backdrop-blur-xl z-50 flex flex-col transform -translate-x-full transition-transform duration-300 ease-out lg:translate-x-0 lg:static lg:max-w-none lg:sticky lg:top-0 lg:bg-[#0f172a]/50">
            <div class="p-6 lg:p-8 flex justify-between items-center shrink-0">
                <div>
                    <a href="/" class="text-3xl font-bold text-gradient">D'JOKI</a>
                    <p class="text-[10px] uppercase tracking-widest text-slate-500 mt-1">Admin Panel</p>
                </div>
                <button type="button" id="sidebar-close" class="p-2 rounded-xl bg-white/5 border border-white/10 text-slate-400 hover:text-white lg:hidden transition" aria-label="Tutup menu">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
                <p class="px-4 text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2 mt-4">Aktivitas</p>
                
                <a href="{{ route('dashboard') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('dashboard') ? 'sidebar-item-active' : '' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('orders.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('orders.*') ? 'sidebar-item-active' : '' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    Daftar Pesanan
                </a>

                <a href="{{ route('finance.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('finance.*') ? 'sidebar-item-active' : '' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Verifikasi Payout
                </a>

                <p class="px-4 text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2 mt-8">Verifikasi Akun</p>

                <a href="{{ route('verification-documents.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('verification-documents.*') ? 'sidebar-item-active' : '' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Dokumen Provider
                </a>

                <p class="px-4 text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2 mt-8">Master Layanan</p>

                <a href="{{ route('service-categories.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('service-categories.*') ? 'sidebar-item-active' : '' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    Kategori Layanan
                </a>

                <a href="{{ route('services.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('services.*') ? 'sidebar-item-active' : '' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Daftar Layanan
                </a>

                <a href="{{ route('payment-methods.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('payment-methods.*') ? 'sidebar-item-active' : '' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Metode Pembayaran
                </a>

                <p class="px-4 text-[10px] font-semibold text-slate-500 uppercase tracking-widest mb-2 mt-8">Users</p>

                <a href="{{ route('users.index') }}" class="sidebar-item group flex items-center px-4 py-3 text-sm font-medium rounded-xl transition {{ request()->routeIs('users.*') ? 'sidebar-item-active' : '' }}">
                    <svg class="mr-3 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Semua Pengguna
                </a>
            </nav>

            <div class="p-4 border-t border-white/5">
                <div class="glass rounded-2xl p-4">
                    <div class="flex items-center">
                        @if(auth()->user()->avatar)
                            <img src="{{ auth()->user()->avatar }}" class="h-10 w-10 rounded-xl object-cover border border-white/10" alt="{{ auth()->user()->name }}">
                        @else
                            <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-red-500 to-orange-500 flex items-center justify-center text-white font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="ml-3 overflow-hidden">
                            <p class="text-sm font-medium text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-xs text-slate-500 truncate capitalize">{{ auth()->user()->role }} Account</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="w-full text-left text-xs text-slate-400 hover:text-red-400 transition flex items-center">
                            <svg class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Keluar Sesi
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 w-full min-w-0 p-4 sm:p-6 lg:p-8">
            <header class="flex flex-col sm:flex-row sm:justify-between sm:items-center mb-6 sm:mb-8 gap-4">
                <div class="flex items-center gap-3 min-w-0 flex-1">
                    <button type="button" id="sidebar-toggle" class="p-2.5 rounded-xl bg-white/5 border border-white/10 text-slate-300 hover:text-white lg:hidden transition active:scale-95 shrink-0" aria-label="Buka menu" aria-expanded="false" aria-controls="sidebar">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="min-w-0">
                        <h1 class="text-xl sm:text-2xl font-bold text-white truncate">@yield('header', 'Overview')</h1>
                        <p class="text-slate-400 text-xs sm:text-sm truncate">@yield('subheader', 'Selamat datang kembali, Admin.')</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 shrink-0 self-start sm:self-auto">
                    <div class="flex items-center space-x-2 px-3 py-1.5 bg-red-500/10 rounded-full border border-red-500/20">
                        <span class="h-2 w-2 bg-red-500 rounded-full animate-pulse"></span>
                        <span class="text-[10px] font-bold text-red-400 uppercase tracking-widest">Master</span>
                    </div>
                </div>
            </header>

            @if(session('success'))
                <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm flex items-center">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm flex items-center">
                    <svg class="h-5 w-5 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

</body>
</html>
