<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'GoalSpace') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.9)), url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="text-white min-h-screen antialiased">

    <header class="bg-black/40 backdrop-blur-md border-b border-white/10 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard', $current_team) }}" class="flex items-center gap-2 group">
                    <span class="text-3xl transition-transform group-hover:scale-110 duration-300">⚽</span>
                    <span class="text-2xl font-black tracking-tighter text-white uppercase">Goal<span class="text-emerald-400">Space</span></span>
                </a>

                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('dashboard', $current_team) }}"
                       class="px-4 py-2 rounded-xl text-sm font-bold transition-all {{ request()->routeIs('dashboard') ? 'bg-emerald-500 text-slate-950' : 'text-gray-400 hover:text-white' }}">
                        Dashboard
                    </a>
                    <a href="{{ route('user.lapangan.index', $current_team) }}"
                       class="px-4 py-2 rounded-xl text-sm font-bold transition-all text-gray-400 hover:text-white">
                        Lapangan
                    </a>
                    <a href="{{ route('user.booking.index', $current_team) }}"
                       class="px-4 py-2 rounded-xl text-sm font-bold transition-all text-gray-400 hover:text-white">
                        Booking Saya
                    </a>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex flex-col items-end mr-2">
                    <span class="text-sm font-bold text-white leading-none">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mt-1">Pemain</span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-white/10 hover:bg-red-600 text-white p-2.5 rounded-xl transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <footer class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 border-t border-white/10 text-center">
        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]">
            © {{ date('Y') }} {{ config('app.name') }} | Coding by 
            <a href="https://sekawanputrapratama.com" target="_blank" class="text-emerald-400 hover:text-emerald-300 transition">Sekawan Putra Pratama</a>
        </p>
    </footer>
</body>
</html>