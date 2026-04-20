<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @hasSection('title')
            @yield('title') - {{ config('app.name') }}
        @else
            {{ config('app.name') }} - Booking Lapangan Futsal
        @endif
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100">
@php
    $currentTeam = request()->route('current_team');
    $routeName = Route::currentRouteName();
@endphp

<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-900 text-white">
        <div class="px-6 py-5 border-b border-gray-800">
            <h1 class="text-2xl font-bold">{{ config('app.name') }}</h1>
            <p class="text-sm text-gray-400 mt-1">Booking Lapangan Futsal Modern</p>
        </div>

        <nav class="p-4 space-y-2 text-sm">
            <a href="{{ route('admin.dashboard', $currentTeam) }}"
               class="block px-4 py-2 rounded {{ $routeName == 'admin.dashboard' ? 'bg-gray-800' : 'hover:bg-gray-800' }}">
                Dashboard
            </a>

            <a href="{{ route('lapangan.index', $currentTeam) }}"
               class="block px-4 py-2 rounded {{ str_starts_with($routeName, 'lapangan') ? 'bg-gray-800' : 'hover:bg-gray-800' }}">
                Lapangan
            </a>

            <a href="{{ route('admin.booking.index', $currentTeam) }}"
               class="block px-4 py-2 rounded {{ str_starts_with($routeName, 'admin.booking') ? 'bg-gray-800' : 'hover:bg-gray-800' }}">
                Booking
            </a>
            <a href="{{ route('admin.booking.validasi.form', $currentTeam) }}"
   class="block px-4 py-2 rounded {{ str_starts_with($routeName, 'admin.booking.validasi') ? 'bg-gray-800' : 'hover:bg-gray-800' }}">
    Validasi Booking
</a>

            <a href="{{ route('users.index', $currentTeam) }}"
               class="block px-4 py-2 rounded {{ str_starts_with($routeName, 'users.') ? 'bg-gray-800' : 'hover:bg-gray-800' }}">
                Data User
            </a>

            <a href="{{ route('admins.index', $currentTeam) }}"
               class="block px-4 py-2 rounded {{ str_starts_with($routeName, 'admins.') ? 'bg-gray-800' : 'hover:bg-gray-800' }}">
                Data Admin
            </a>

            <a href="{{ route('admin.booking.kalender', $currentTeam) }}"
               class="block px-4 py-2 rounded {{ $routeName == 'admin.booking.kalender' ? 'bg-gray-800' : 'hover:bg-gray-800' }}">
                Kalender
            </a>

            <a href="{{ route('laporan.index', $currentTeam) }}"
               class="block px-4 py-2 rounded {{ str_starts_with($routeName, 'laporan') ? 'bg-gray-800' : 'hover:bg-gray-800' }}">
                Laporan
            </a>
            <a href="{{ route('2fa.settings', $current_team) }}"
   class="block px-4 py-2 rounded-lg hover:bg-slate-800 text-white/90">
    Keamanan 2FA
</a>
        </nav>

        <div class="p-4 border-t border-gray-800">
            <button onclick="openLogoutModal()"
                    class="w-full bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                Logout
            </button>
        </div>
    </aside>

    {{-- Main --}}
    <main class="flex-1 flex flex-col">
        <header class="bg-white border-b px-6 py-4 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-bold">@yield('page_heading', 'Dashboard')</h2>
                <p class="text-sm text-gray-500">Halo, {{ auth()->user()->name }}</p>
            </div>
        </header>

        <section class="p-6 flex-1">
            @yield('content')

            <div class="text-center text-xs text-gray-400 mt-10">
                © {{ date('Y') }} {{ config('app.name') }}
            </div>
        </section>
    </main>
</div>

{{-- Toast --}}
<div id="toast" class="fixed top-5 right-5 hidden bg-green-600 text-white px-4 py-2 rounded shadow"></div>

@stack('scripts')

<script>
function showToast(msg) {
    let t = document.getElementById('toast');
    t.innerText = msg;
    t.classList.remove('hidden');
    setTimeout(() => t.classList.add('hidden'), 2000);
}
</script>

@if(session('success'))
<script>
    showToast("{{ session('success') }}");
</script>
@endif

{{-- Modal hapus global --}}
<div id="globalDeleteModal"
     class="fixed inset-0 hidden items-center justify-center bg-black/40 z-50">
    <div class="bg-white w-[90%] max-w-sm rounded-2xl shadow-xl p-6 text-center">
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Konfirmasi Hapus</h2>
        <p class="text-sm text-gray-600 mb-5">Yakin ingin menghapus data ini?</p>

        <div class="flex justify-center gap-3">
            <button type="button"
                    id="cancelDeleteBtn"
                    class="px-4 py-2 rounded-lg bg-gray-200 text-gray-700 hover:bg-gray-300">
                Batal
            </button>

            <button type="button"
                    id="confirmDeleteBtn"
                    class="px-4 py-2 rounded-lg bg-red-600 text-white hover:bg-red-700">
                Hapus
            </button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('globalDeleteModal');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const cancelBtn = document.getElementById('cancelDeleteBtn');

    let targetForm = null;

    function openGlobalDeleteModal(form) {
        targetForm = form;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeGlobalDeleteModal() {
        targetForm = null;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.addEventListener('submit', function (e) {
        const form = e.target;

        if (!(form instanceof HTMLFormElement)) return;

        const methodInput = form.querySelector('input[name="_method"]');
        const isDeleteForm = methodInput && methodInput.value.toUpperCase() === 'DELETE';

        if (isDeleteForm && !form.dataset.confirmed) {
            e.preventDefault();
            openGlobalDeleteModal(form);
        }
    });

    confirmBtn.addEventListener('click', function () {
        if (targetForm) {
            targetForm.dataset.confirmed = 'true';
            targetForm.submit();
        }
        closeGlobalDeleteModal();
    });

    cancelBtn.addEventListener('click', closeGlobalDeleteModal);

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeGlobalDeleteModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeGlobalDeleteModal();
        }
    });
});
</script>

{{-- Modal logout --}}
<div id="logoutModal"
     class="fixed inset-0 hidden items-center justify-center bg-black/40 z-50">
    <div class="bg-white rounded-xl shadow-lg p-6 w-80 text-center">
        <h2 class="text-lg font-semibold mb-3">Logout</h2>
        <p class="text-gray-600 mb-5">Yakin ingin keluar?</p>

        <div class="flex justify-center gap-3">
            <button onclick="closeLogoutModal()"
                    class="bg-gray-300 px-4 py-2 rounded-lg">
                Batal
            </button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-600 text-white px-4 py-2 rounded-lg">
                    Logout
                </button>
            </form>
        </div>
    </div>
</div>

<script>
function openLogoutModal() {
    document.getElementById('logoutModal').classList.remove('hidden');
    document.getElementById('logoutModal').classList.add('flex');
}

function closeLogoutModal() {
    document.getElementById('logoutModal').classList.add('hidden');
    document.getElementById('logoutModal').classList.remove('flex');
}
</script>
</body>
</html>