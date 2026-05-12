<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'GoalSpace') }}</title>

    <!-- CLEAN PREMIUM FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
        }

        .main-card {
            background: white;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 20px rgba(15, 23, 42, 0.04);
        }

        .nav-link {
            color: #475569;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #2563eb;
            background: #eff6ff;
        }

        .nav-active {
            background: #2563eb;
            color: white !important;
            box-shadow: 0 8px 24px rgba(37,99,235,0.25);
        }

        .logo-accent {
            color: #2563eb;
        }

        .soft-border {
            border: 1px solid #e2e8f0;
        }
    </style>
</head>

<body class="antialiased">

    <!-- HEADER -->
    <header class="sticky top-0 z-50 bg-white/95 backdrop-blur-xl border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">

            <!-- LEFT -->
            <div class="flex items-center gap-10">

                <!-- LOGO -->
                <a href="{{ route('dashboard', $current_team) }}" class="flex items-center gap-3 group">
                    <span class="text-3xl group-hover:scale-110 transition-transform duration-300">⚽</span>

                    <span class="text-2xl font-black tracking-tight">
                        Goal<span class="logo-accent">Space</span>
                    </span>
                </a>

                <!-- DESKTOP NAV -->
                <nav class="hidden md:flex items-center gap-2">

                    <a href="{{ route('dashboard', $current_team) }}"
                       class="px-5 py-3 rounded-2xl text-sm font-bold transition-all
                       {{ request()->routeIs('dashboard') ? 'nav-active' : 'nav-link' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('user.lapangan.index', $current_team) }}"
                       class="px-5 py-3 rounded-2xl text-sm font-bold transition-all
                       {{ request()->routeIs('user.lapangan.*') ? 'nav-active' : 'nav-link' }}">
                        Lapangan
                    </a>

                    <a href="{{ route('user.booking.index', $current_team) }}"
                       class="px-5 py-3 rounded-2xl text-sm font-bold transition-all
                       {{ request()->routeIs('user.booking.*') ? 'nav-active' : 'nav-link' }}">
                        Booking Saya
                    </a>

                    <a href="{{ route('2fa.settings', $current_team) }}"
                       class="px-5 py-3 rounded-2xl text-sm font-bold transition-all
                       {{ request()->routeIs('2fa.*') ? 'nav-active' : 'nav-link' }}">
                        Keamanan
                    </a>

                </nav>
            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-3 md:gap-5">

                <!-- USER INFO -->
                <div class="hidden sm:flex flex-col items-end">
                    <span class="text-sm font-semibold text-slate-800">
                        {{ auth()->user()->name }}
                    </span>

                    <span class="text-[11px] font-bold text-blue-600 uppercase tracking-widest mt-1">
                        Player
                    </span>
                </div>

                <!-- MOBILE BUTTON -->
                <button onclick="toggleUserMenu()"
                        class="md:hidden bg-slate-100 hover:bg-slate-200 text-slate-800 p-3 rounded-2xl transition-all soft-border">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>

                <!-- LOGOUT -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-slate-100 hover:bg-red-500 hover:text-white text-slate-700 p-3 rounded-2xl transition-all soft-border">
                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                  clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>

            </div>
        </div>

        <!-- MOBILE MENU -->
        <div id="mobileUserMenu"
             class="hidden md:hidden bg-white border-t border-slate-200">
            <div class="px-6 py-8 space-y-4">

                <a href="{{ route('dashboard', $current_team) }}"
                   class="block px-6 py-4 rounded-2xl font-bold text-sm
                   {{ request()->routeIs('dashboard') ? 'nav-active' : 'bg-slate-50 text-slate-700' }}">
                    Dashboard
                </a>

                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="block px-6 py-4 rounded-2xl font-bold text-sm
                   {{ request()->routeIs('user.lapangan.*') ? 'nav-active' : 'bg-slate-50 text-slate-700' }}">
                    Lapangan
                </a>

                <a href="{{ route('user.booking.index', $current_team) }}"
                   class="block px-6 py-4 rounded-2xl font-bold text-sm
                   {{ request()->routeIs('user.booking.*') ? 'nav-active' : 'bg-slate-50 text-slate-700' }}">
                    Booking Saya
                </a>

                <a href="{{ route('2fa.settings', $current_team) }}"
                   class="block px-6 py-4 rounded-2xl font-bold text-sm
                   {{ request()->routeIs('2fa.*') ? 'nav-active' : 'bg-slate-50 text-slate-700' }}">
                    Keamanan
                </a>

                <form method="POST" action="{{ route('logout') }}" class="pt-4">
                    @csrf
                    <button type="submit"
                            class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-4 rounded-2xl transition-all">
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </header>

    <!-- MAIN -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        @yield('content')
    </main>

    <!-- MOBILE MENU SCRIPT -->
    <script>
        function toggleUserMenu() {
            const menu = document.getElementById('mobileUserMenu');
            menu.classList.toggle('hidden');
        }
    </script>

</body>
</html>