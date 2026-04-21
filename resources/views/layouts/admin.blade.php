<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ config('app.name', 'GoalSpace') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #0f172a;
        }
        .glass-sidebar {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.05);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .nav-link-active {
            background: linear-gradient(to right, rgba(16, 185, 129, 0.1), transparent);
            border-left: 4px solid #10b981;
            color: #10b981 !important;
        }
    </style>
</head>
<body class="text-slate-200 min-h-screen antialiased">

    <!-- MOBILE HEADER -->
    <div class="lg:hidden fixed top-0 left-0 right-0 h-20 bg-slate-900/90 backdrop-blur-xl border-b border-white/5 z-[100] flex items-center justify-between px-6">
        <div class="flex flex-col">
            <span class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.3em] italic">Administrator</span>
            <div class="flex items-center gap-2">
                <span class="text-xl">⚽</span>
                <span class="text-lg font-black tracking-tighter text-white uppercase italic">GOAL<span class="text-emerald-500">ADMIN</span></span>
            </div>
        </div>
        <div class="flex items-center gap-3">
            <button onclick="openLogoutModal()" class="w-10 h-10 bg-red-500/10 text-red-500 rounded-xl flex items-center justify-center border border-red-500/20 active:scale-90 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </button>
            <button onclick="toggleMobileSidebar()" class="w-10 h-10 bg-white/5 text-white rounded-xl flex items-center justify-center border border-white/10 active:scale-95">
                <span id="menuIcon" class="text-xl">☰</span>
            </button>
        </div>
    </div>

    <!-- MAIN WRAPPER (Flex Layout) -->
    <div class="flex min-h-screen">
        
        <!-- SIDEBAR (Desktop: Static, Mobile: Fixed) -->
        <aside id="adminSidebar" class="w-72 glass-sidebar shrink-0 h-screen sticky top-0 z-[90] hidden lg:flex flex-col transition-all duration-300 mobile-sidebar">
            <!-- Mobile Close Button -->
            <button onclick="toggleMobileSidebar()" class="lg:hidden absolute right-4 top-4 text-slate-400">✕</button>

            <div class="p-8 shrink-0">
                <a href="#" class="flex items-center gap-3 group">
                    <span class="text-3xl transition-transform group-hover:scale-110 duration-300">⚽</span>
                    <span class="text-2xl font-black tracking-tighter text-white uppercase italic">GOAL<span class="text-emerald-500">ADMIN</span></span>
                </a>
            </div>

            <nav class="flex-1 px-4 space-y-1 overflow-y-auto pb-10">
                <p class="px-4 text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4 italic">Management</p>
                
                @php
                    $navItems = [
                        ['route' => 'admin.dashboard', 'icon' => '📊', 'label' => 'Dashboard'],
                        ['route' => 'lapangan.index', 'icon' => '🏟️', 'label' => 'Lapangan'],
                        ['route' => 'admin.booking.index', 'icon' => '📅', 'label' => 'Booking'],
                        ['route' => 'admin.booking.validasi.form', 'icon' => '✅', 'label' => 'Validasi'],
                        ['route' => 'users.index', 'icon' => '👥', 'label' => 'Data User'],
                        ['route' => 'admins.index', 'icon' => '🛡️', 'label' => 'Data Admin'],
                        ['route' => 'admin.booking.kalender', 'icon' => '🗓️', 'label' => 'Kalender'],
                        ['route' => 'laporan.index', 'icon' => '📈', 'label' => 'Laporan'],
                        ['route' => '2fa.settings', 'icon' => '🔒', 'label' => 'Keamanan'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <a href="{{ route($item['route'], $current_team) }}" 
                       class="flex items-center gap-3 px-4 py-3.5 rounded-xl text-sm font-bold transition-all hover:bg-white/10 {{ request()->routeIs($item['route'].'*') ? 'nav-link-active' : 'text-slate-200' }}">
                        <span>{{ $item['icon'] }}</span>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach

                <div class="pt-8 px-4">
                    <button onclick="openLogoutModal()" class="w-full bg-red-600/10 text-red-500 border border-red-500/20 font-black py-4 rounded-2xl hover:bg-red-600 hover:text-white transition-all uppercase tracking-widest text-[10px] italic">
                        Logout System
                    </button>
                </div>
            </nav>
        </aside>

        <!-- CONTENT AREA -->
        <div class="flex-1 min-w-0 flex flex-col pt-20 lg:pt-0">
            <!-- Desktop Top Header -->
            <header class="hidden lg:flex h-20 items-center justify-between px-8 bg-black/20 backdrop-blur-sm sticky top-0 z-40 border-b border-white/5 shrink-0">
                <div class="flex items-center gap-4">
                    <h1 class="text-xl font-black text-white tracking-tight uppercase tracking-widest">@yield('page_heading', 'Overview')</h1>
                </div>

                <div class="flex items-center gap-6">
                    <div class="flex flex-col items-end">
                        <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] mb-1">Server Status</span>
                        <span class="flex items-center gap-1.5 text-[10px] font-black text-emerald-400 uppercase tracking-widest">
                            <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span> Online
                        </span>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <section class="p-4 md:p-8">
                @yield('content')
            </section>
        </div>
    </div>

    @stack('modals')
    @stack('scripts')

    <!-- LOGOUT MODAL -->
    <div id="logoutModal" class="fixed inset-0 hidden items-center justify-center bg-slate-950/90 backdrop-blur-xl z-[200]">
        <div class="glass-card rounded-[3rem] p-10 w-full max-w-[400px] mx-4 text-center border-white/10 shadow-2xl">
            <div class="w-20 h-20 bg-red-500/10 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-6 animate-bounce">👋</div>
            <h2 class="text-2xl font-black text-white mb-2 uppercase tracking-widest">Logout?</h2>
            <p class="text-slate-400 mb-8 text-xs font-medium">Sesi Anda akan diakhiri. Pastikan semua data sudah tersimpan.</p>

            <div class="grid grid-cols-2 gap-4">
                <button onclick="closeLogoutModal()" class="bg-white/5 text-white font-black py-4 rounded-2xl hover:bg-white/10 transition uppercase tracking-widest text-[10px]">Batal</button>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full bg-red-600 text-white font-black py-4 rounded-2xl hover:bg-red-700 shadow-xl shadow-red-600/30 transition uppercase tracking-widest text-[10px]">Keluar</button>
                </form>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 1023px) {
            .mobile-sidebar {
                position: fixed !important;
                left: 0;
                top: 0;
                transform: translateX(-100%);
                display: flex !important;
            }
            .mobile-sidebar.active {
                transform: translateX(0);
            }
        }
    </style>

    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            sidebar.classList.toggle('active');
        }

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