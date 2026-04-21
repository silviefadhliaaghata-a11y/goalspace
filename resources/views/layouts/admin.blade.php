<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ config('app.name', 'GoalSpace') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-image: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.9)), url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .glass-sidebar {
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .nav-link-active {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981 !important;
            border-left: 4px solid #10b981;
        }
    </style>
</head>
<body class="text-slate-200 min-h-screen antialiased flex overflow-hidden">

    <!-- SIDEBAR -->
    <aside class="w-72 glass-sidebar hidden lg:flex flex-col h-screen sticky top-0">
        <div class="p-8">
            <a href="#" class="flex items-center gap-3 group">
                <span class="text-3xl transition-transform group-hover:scale-110 duration-300">⚽</span>
                <span class="text-2xl font-black tracking-tighter text-white uppercase italic">GOAL<span class="text-emerald-500">ADMIN</span></span>
            </a>
        </div>

        <nav class="flex-1 px-4 space-y-1">
            <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4 italic">Management</p>
            
            <a href="{{ route('admin.dashboard', $current_team) }}" 
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-bold transition-all hover:bg-white/5 {{ request()->routeIs('admin.dashboard') ? 'nav-link-active text-emerald-400' : 'text-slate-400' }}">
                📊 Dashboard
            </a>

            <a href="{{ route('lapangan.index', $current_team) }}" 
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-bold transition-all hover:bg-white/5 {{ request()->routeIs('lapangan.*') ? 'nav-link-active text-emerald-400' : 'text-slate-400' }}">
                🏟️ Lapangan
            </a>

            <a href="{{ route('admin.booking.index', $current_team) }}" 
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-bold transition-all hover:bg-white/5 {{ request()->routeIs('admin.booking.index') ? 'nav-link-active text-emerald-400' : 'text-slate-400' }}">
                📅 Booking
            </a>

            <a href="{{ route('admin.booking.validasi.form', $current_team) }}" 
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-bold transition-all hover:bg-white/5 {{ request()->routeIs('admin.booking.validasi.*') ? 'nav-link-active text-emerald-400' : 'text-slate-400' }}">
                ✅ Validasi Booking
            </a>

            <a href="{{ route('users.index', $current_team) }}" 
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-bold transition-all hover:bg-white/5 {{ request()->routeIs('users.*') ? 'nav-link-active text-emerald-400' : 'text-slate-400' }}">
                👥 Data User
            </a>

            <a href="{{ route('admins.index', $current_team) }}" 
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-bold transition-all hover:bg-white/5 {{ request()->routeIs('admins.*') ? 'nav-link-active text-emerald-400' : 'text-slate-400' }}">
                🛡️ Data Admin
            </a>

            <a href="{{ route('admin.booking.kalender', $current_team) }}" 
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-bold transition-all hover:bg-white/5 {{ request()->routeIs('admin.booking.kalender') ? 'nav-link-active text-emerald-400' : 'text-slate-400' }}">
                🗓️ Kalender
            </a>

            <a href="{{ route('laporan.index', $current_team) }}" 
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-bold transition-all hover:bg-white/5 {{ request()->routeIs('laporan.*') ? 'nav-link-active text-emerald-400' : 'text-slate-400' }}">
                📈 Laporan
            </a>

            <a href="{{ route('2fa.settings', $current_team) }}" 
               class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-bold transition-all hover:bg-white/5 {{ request()->routeIs('2fa.*') ? 'nav-link-active text-emerald-400' : 'text-slate-400' }}">
                🔒 Keamanan 2FA
            </a>

            <div class="pt-8 px-4">
                <button onclick="openLogoutModal()" class="w-full bg-red-600 text-white font-black py-4 rounded-2xl hover:bg-red-700 shadow-lg shadow-red-600/20 transition uppercase tracking-widest text-xs">
                    Logout
                </button>
            </div>
        </nav>

        <div class="p-6">
            <div class="glass-card rounded-2xl p-4 flex items-center gap-3">
                <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center font-black text-slate-900">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div class="overflow-hidden text-ellipsis whitespace-nowrap">
                    <p class="text-xs font-black text-white leading-none">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] font-bold text-emerald-500 uppercase mt-1 tracking-tighter">Super Admin</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- MAIN CONTENT -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <!-- HEADER -->
        <header class="h-20 flex items-center justify-between px-8 bg-black/20 backdrop-blur-sm sticky top-0 z-40 border-b border-white/5">
            <div class="flex items-center gap-4">
                <h1 class="text-xl font-black text-white tracking-tight uppercase tracking-widest">@yield('page_heading', 'Overview')</h1>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden md:flex flex-col items-end mr-4">
                    <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-1">Server Status</span>
                    <span class="flex items-center gap-1.5 text-[10px] font-black text-emerald-400 uppercase tracking-widest">
                        <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Online
                    </span>
                </div>
            </div>
        </header>

        <!-- CONTENT -->
        <section class="p-8 pb-20">
            @yield('content')
        </section>
    </main>

    <!-- LOGOUT MODAL -->
    <div id="logoutModal" class="fixed inset-0 hidden items-center justify-center bg-slate-950/80 backdrop-blur-md z-[100]">
        <div class="glass-card rounded-[3rem] p-12 w-[450px] text-center border-white/10 shadow-2xl">
            <div class="w-24 h-24 bg-red-500/10 text-red-500 rounded-3xl flex items-center justify-center text-4xl mx-auto mb-8 animate-bounce">👋</div>
            <h2 class="text-3xl font-black text-white mb-3 tracking-tighter uppercase tracking-widest">Sudah Selesai?</h2>
            <p class="text-slate-400 mb-10 font-medium">Laporan hari ini sudah terarsip dengan aman. Sampai jumpa besok!</p>

            <div class="grid grid-cols-2 gap-4">
                <button onclick="closeLogoutModal()" class="bg-white/5 text-white font-black py-4 rounded-2xl hover:bg-white/10 transition uppercase tracking-widest text-xs">Batal</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full bg-red-600 text-white font-black py-4 rounded-2xl hover:bg-red-700 shadow-xl shadow-red-600/30 transition uppercase tracking-widest text-xs">Ya, Keluar</button>
                </form>
            </div>
        </div>
    </div>

    @stack('scripts')
    <script>
        function openLogoutModal() { 
            const m = document.getElementById('logoutModal');
            m.classList.remove('hidden'); 
            m.classList.add('flex'); 
        }
        function closeLogoutModal() { 
            const m = document.getElementById('logoutModal');
            m.classList.add('hidden'); 
            m.classList.remove('flex'); 
        }
    </script>
</body>
</html>