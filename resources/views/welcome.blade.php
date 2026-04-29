<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'GoalSpace') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white">

    {{-- HERO SECTION --}}
    <section class="relative min-h-screen overflow-hidden">
        {{-- Background Image --}}
        <div class="absolute inset-0">
            <img
                src="https://images.unsplash.com/photo-1518604666860-9ed391f76460?auto=format&fit=crop&w=1600&q=80"
                alt="Lapangan Futsal"
                class="w-full h-full object-cover"
            >
            <div class="absolute inset-0 bg-black/55"></div>
        </div>

        {{-- Navbar --}}
        <header class="relative z-20">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-5">
                <div class="flex items-center justify-between">
                    <a href="{{ url('/') }}" class="text-2xl font-extrabold tracking-wide">
                        <span class="text-white">Goal</span><span class="text-green-400">Space</span>
                    </a>

                   <div class="flex items-center gap-3">
    @auth
        @php
            $team = auth()->user()?->currentTeam ?? auth()->user()?->personalTeam();
        @endphp

        @if ($team && auth()->user()?->role === 'admin')
            <a href="{{ route('admin.dashboard', ['current_team' => $team->slug]) }}"
               class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/20 transition">
                Dashboard
            </a>
        @elseif ($team)
            <a href="{{ route('dashboard', ['current_team' => $team->slug]) }}"
               class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/20 transition">
                Dashboard
            </a>
        @endif
                        @else
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-5 py-2.5 text-sm font-semibold text-white hover:bg-white/20 transition">
                                Login
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                   class="inline-flex items-center rounded-full bg-green-500 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-600 transition">
                                    Daftar
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <div class="relative z-10 min-h-screen flex items-center">
            <div class="max-w-7xl mx-auto w-full px-6 lg:px-8">
                <div class="max-w-3xl">
                    <p class="mb-4 inline-flex items-center rounded-full border border-white/20 bg-white/10 px-4 py-2 text-sm text-white/90 backdrop-blur-sm">
                        Booking lapangan futsal lebih cepat & praktis
                    </p>

                    <h1 class="text-4xl md:text-6xl font-extrabold leading-tight tracking-tight">
                        Sehatkan Dirimu Dengan
                        <br>
                        Berolahraga di
                        <span class="text-green-400">GoalSpace</span>
                    </h1>

                    <p class="mt-6 max-w-2xl text-base md:text-lg text-gray-200 leading-relaxed">
                        Pesan lapangan futsal dengan mudah, cek jadwal tersedia, upload bukti pembayaran,
                        dan kelola booking dalam satu aplikasi yang modern dan praktis.
                    </p>

                    <div class="mt-8 flex flex-wrap items-center gap-4">
    @auth
        @php
            $team = auth()->user()?->currentTeam ?? auth()->user()?->personalTeam();
        @endphp

        @if ($team && auth()->user()?->role === 'admin')
            <a href="{{ route('admin.dashboard', ['current_team' => $team->slug]) }}"
               class="inline-flex items-center rounded-full bg-green-500 px-7 py-3.5 text-sm md:text-base font-bold text-white shadow-lg hover:bg-green-600 transition">
                Masuk Dashboard →
            </a>
        @elseif ($team)
            <a href="{{ route('user.lapangan.index', ['current_team' => $team->slug]) }}"
               class="inline-flex items-center rounded-full bg-green-500 px-7 py-3.5 text-sm md:text-base font-bold text-white shadow-lg hover:bg-green-600 transition">
                Booking Sekarang →
            </a>
        @endif
    @else
                        
                            <a href="{{ route('login') }}"
                               class="inline-flex items-center rounded-full bg-green-500 px-7 py-3.5 text-sm md:text-base font-bold text-white shadow-lg hover:bg-green-600 transition">
                                Booking Sekarang →
                            </a>
                        @endauth

                        <a href="#tentang"
                           class="inline-flex items-center rounded-full border border-white/20 bg-white/10 px-7 py-3.5 text-sm md:text-base font-semibold text-white hover:bg-white/20 transition">
                            Pelajari Lebih Lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION TENTANG --}}
    <section id="tentang" class="bg-white text-gray-800 py-20">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="rounded-2xl bg-gray-50 p-6 shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold mb-3">Booking Mudah</h3>
                    <p class="text-gray-600 leading-relaxed">
                        User dapat melihat lapangan yang tersedia lalu melakukan booking dengan cepat dan jelas.
                    </p>
                </div>

                <div class="rounded-2xl bg-gray-50 p-6 shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold mb-3">Jadwal Teratur</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistem membantu pengelolaan jadwal lapangan agar pemesanan lebih tertata dan tidak bentrok.
                    </p>
                </div>

                <div class="rounded-2xl bg-gray-50 p-6 shadow-sm border border-gray-100">
                    <h3 class="text-xl font-bold mb-3">Kelola Pembayaran</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Upload bukti pembayaran dan pantau status booking mulai dari pending sampai selesai.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="bg-gray-950 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-10 text-center">
            <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">
                © {{ date('Y') }} <span class="font-bold text-white">GoalSpace</span>. All Rights Reserved.
            </p>
            <p class="text-[10px] mt-2 font-black tracking-[0.2em]">
                <span class="text-gray-500">PUBLISHED BY</span> 
                <a href="https://sekawanputrapratama.com" target="_blank" class="text-yellow-500 hover:text-blue-500 transition-colors">WWW.SEKAWANPUTRAPRATAMA.COM</a>
            </p>
        </div>
    </footer>

</body>
</html>