<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'GoalSpace') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen antialiased">

    {{-- NAVBAR USER --}}
    <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3.5 flex items-center justify-between">
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard', $current_team) }}" class="flex items-center gap-2 group">
                    <span class="text-2xl transition-transform group-hover:scale-110 duration-300">⚽</span>
                    <span class="text-xl font-black tracking-tighter text-slate-900 uppercase">Goal<span class="text-emerald-500">Space</span></span>
                </a>

                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('dashboard', $current_team) }}"
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-slate-100' }}">
                        Dashboard
                    </a>

                    <a href="{{ route('user.lapangan.index', $current_team) }}"
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('user.lapangan.*') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-slate-100' }}">
                        Lapangan
                    </a>

                    <a href="{{ route('user.booking.index', $current_team) }}"
                       class="px-4 py-2 rounded-xl text-sm font-semibold transition-all {{ request()->routeIs('user.booking.*') ? 'bg-emerald-50 text-emerald-600' : 'text-slate-600 hover:bg-slate-100' }}">
                        Booking Saya
                    </a>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex flex-col items-end mr-2">
                    <span class="text-sm font-bold text-slate-900 leading-none">{{ auth()->user()->name }}</span>
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-1">Pemain</span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="bg-slate-900 text-white p-2.5 rounded-xl hover:bg-red-600 transition-all duration-300 group">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

</body>
</html>