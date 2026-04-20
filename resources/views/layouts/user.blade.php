<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'GoalSpace') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-green-50 text-gray-800 min-h-screen">

    {{-- NAVBAR USER --}}
    <header class="bg-white border-b border-green-100 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <div>
                <a href="{{ route('dashboard', $current_team) }}" class="text-2xl font-extrabold">
                    <span class="text-gray-800">Goal</span><span class="text-green-600">Space</span>
                </a>
                <p class="text-xs text-gray-500 mt-1">User Panel</p>
            </div>

            <nav class="hidden md:flex items-center gap-2">
                <a href="{{ route('dashboard', $current_team) }}"
                   class="px-4 py-2 rounded-xl text-sm font-medium text-gray-700 hover:bg-green-100 hover:text-green-700 transition">
                    Dashboard
                </a>

                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="px-4 py-2 rounded-xl text-sm font-medium text-gray-700 hover:bg-green-100 hover:text-green-700 transition">
                    Lapangan
                </a>

               <a href="{{ route('user.booking.index', $current_team) }}"
   class="px-4 py-2 rounded-xl text-sm font-medium text-gray-700 hover:bg-green-100 hover:text-green-700 transition">
    Booking Saya
</a>
            </nav>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:bg-green-700 transition">
                    Logout
                </button>
            </form>
        </div>
    </header>

    {{-- CONTENT --}}
    <main class="max-w-7xl mx-auto px-6 py-8">
        @yield('content')
    </main>

</body>
</html>