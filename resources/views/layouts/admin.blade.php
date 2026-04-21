<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name') }}
        @else
            {{ config('app.name') }} - Admin Panel
        @endif
    </title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .sidebar-gradient {
            background: linear-gradient(180deg, #0f172a 0%, #1e293b 100%);
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen antialiased">
@php
    $currentTeam = request()->route('current_team');
    $routeName = Route::currentRouteName();
@endphp

<div class="flex min-h-screen overflow-hidden">
    {{-- Sidebar --}}
    <aside class="w-72 sidebar-gradient text-white hidden lg:flex flex-col shrink-0">
        <div class="px-8 py-8">
            <div class="flex items-center gap-3 group">
                <span class="text-3xl transition-transform group-hover:scale-110 duration-300">⚽</span>
                <span class="text-xl font-black tracking-tighter uppercase">Goal<span class="text-emerald-400">Space</span></span>
            </div>
            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.3em] mt-3">Admin Control Center</p>
        </div>

        <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
            <div class="px-4 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest">Utama</div>
            
            <a href="{{ route('admin.dashboard', $currentTeam) }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all font-bold text-sm {{ $routeName == 'admin.dashboard' ? 'bg-emerald-500 text-slate-950 shadow-lg shadow-emerald-500/20' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <span class="text-lg">📊</span> Dashboard
            </a>

            <div class="px-4 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest mt-4">Manajemen</div>

            <a href="{{ route('lapangan.index', $currentTeam) }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all font-bold text-sm {{ str_starts_with($routeName, 'lapangan') ? 'bg-emerald-500 text-slate-950' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <span class="text-lg">🏟️</span> Lapangan
            </a>

            <a href="{{ route('admin.booking.index', $currentTeam) }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all font-bold text-sm {{ str_starts_with($routeName, 'admin.booking') && !str_contains($routeName, 'kalender') ? 'bg-emerald-500 text-slate-950' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <span class="text-lg">📝</span> Daftar Booking
            </a>

            <a href="{{ route('admin.booking.validasi.form', $currentTeam) }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all font-bold text-sm {{ str_starts_with($routeName, 'admin.booking.validasi') ? 'bg-emerald-500 text-slate-950' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <span class="text-lg">🛡️</span> Validasi Cepat
            </a>

            <a href="{{ route('users.index', $currentTeam) }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all font-bold text-sm {{ str_starts_with($routeName, 'users.') ? 'bg-emerald-500 text-slate-950' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <span class="text-lg">👥</span> Pelanggan
            </a>

            <div class="px-4 py-3 text-[10px] font-black text-slate-500 uppercase tracking-widest mt-4">Analitik & Tools</div>

            <a href="{{ route('admin.booking.kalender', $currentTeam) }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all font-bold text-sm {{ $routeName == 'admin.booking.kalender' ? 'bg-emerald-500 text-slate-950' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <span class="text-lg">📅</span> Kalender Jadwal
            </a>

            <a href="{{ route('laporan.index', $currentTeam) }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all font-bold text-sm {{ str_starts_with($routeName, 'laporan') ? 'bg-emerald-500 text-slate-950' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <span class="text-lg">📈</span> Laporan Keuangan
            </a>

            <a href="{{ route('2fa.settings', $currentTeam) }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all font-bold text-sm {{ str_starts_with($routeName, '2fa') ? 'bg-emerald-500 text-slate-950' : 'text-slate-400 hover:bg-white/5 hover:text-white' }}">
                <span class="text-lg">🔐</span> Keamanan 2FA
            </a>
        </nav>

        <div class="p-6 border-t border-white/5">
            <button onclick="openLogoutModal()"
                    class="w-full flex items-center justify-center gap-2 bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white px-4 py-3.5 rounded-2xl transition-all font-black text-xs uppercase tracking-widest group">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transform group-hover:translate-x-1 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                Keluar Sistem
            </button>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <header class="bg-white/80 backdrop-blur-md border-b border-slate-200 px-8 py-5 flex justify-between items-center sticky top-0 z-30">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight">@yield('page_heading', 'Dashboard')</h2>
                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">Admin: {{ auth()->user()->name }}</p>
            </div>

            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center font-black">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>
        </header>

        <section class="p-8">
            @yield('content')
        </section>
    </main>
</div>

{{-- Toast & Modals --}}
<div id="toast" class="fixed bottom-8 right-8 hidden bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl z-[100] border border-slate-800 animate-bounce"></div>

@stack('scripts')

<script>
function showToast(msg) {
    let t = document.getElementById('toast');
    t.innerText = "✨ " + msg;
    t.classList.remove('hidden');
    setTimeout(() => t.classList.add('hidden'), 3000);
}
</script>

@if(session('success'))
<script>showToast("{{ session('success') }}");</script>
@endif

{{-- Logout Modal --}}
<div id="logoutModal" class="fixed inset-0 hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm z-[100]">
    <div class="bg-white rounded-[2.5rem] shadow-2xl p-10 w-[400px] text-center border border-slate-100">
        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-3xl flex items-center justify-center text-3xl mx-auto mb-6">👋</div>
        <h2 class="text-2xl font-black text-slate-900 mb-2 tracking-tight">Sudah Selesai?</h2>
        <p class="text-slate-500 mb-8 font-medium">Pastikan semua laporan hari ini sudah tersimpan dengan benar.</p>

        <div class="grid grid-cols-2 gap-4">
            <button onclick="closeLogoutModal()" class="bg-slate-100 text-slate-600 font-black py-4 rounded-2xl hover:bg-slate-200 transition">Batal</button>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full bg-red-600 text-white font-black py-4 rounded-2xl hover:bg-red-700 shadow-lg shadow-red-600/20 transition">Ya, Keluar</button>
            </form>
        </div>
    </div>
</div>

<script>
function openLogoutModal() { document.getElementById('logoutModal').classList.remove('hidden'); document.getElementById('logoutModal').classList.add('flex'); }
function closeLogoutModal() { document.getElementById('logoutModal').classList.add('hidden'); document.getElementById('logoutModal').classList.remove('flex'); }
</script>

</body>
</html>