<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - GoalSpace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">GoalSpace</h1>
            <p class="text-sm text-gray-500 mt-2">Login ke sistem booking lapangan futsal</p>
        </div>

        @if (session('status'))
            <div class="mb-4 rounded-xl bg-green-50 border border-green-200 p-3 text-sm text-green-700">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-xl bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf


            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Masukkan email" required autofocus>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>
                <input type="password" name="password" id="password"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Masukkan password" required>
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                    <span class="text-gray-600">Ingat saya</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                        Lupa password?
                    </a>
                @endif
            </div>

            <button type="submit"
                class="w-full rounded-xl bg-gray-900 text-white py-3 font-semibold hover:bg-black transition">
                Login
            </button>
        </form>

        @if (Route::has('google.redirect'))
            <div class="my-5 flex items-center gap-3">
                <div class="h-px bg-gray-200 flex-1"></div>
                <span class="text-xs text-gray-400">ATAU</span>
                <div class="h-px bg-gray-200 flex-1"></div>
            </div>

            <a href="{{ route('google.redirect') }}"
               class="w-full inline-flex items-center justify-center gap-2 rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" class="w-5 h-5">
                    <path fill="#FFC107" d="M43.6 20.5H42V20H24v8h11.3C33.6 32.7 29.2 36 24 36c-6.6 0-12-5.4-12-12S17.4 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34.1 6.1 29.3 4 24 4 12.9 4 4 12.9 4 24s8.9 20 20 20 20-8.9 20-20c0-1.3-.1-2.3-.4-3.5z"/>
                    <path fill="#FF3D00" d="M6.3 14.7l6.6 4.8C14.7 15.1 19 12 24 12c3 0 5.7 1.1 7.8 3l5.7-5.7C34.1 6.1 29.3 4 24 4c-7.7 0-14.3 4.3-17.7 10.7z"/>
                    <path fill="#4CAF50" d="M24 44c5.2 0 10-2 13.5-5.2l-6.2-5.2C29.3 35.1 26.8 36 24 36c-5.2 0-9.6-3.3-11.2-8l-6.5 5C9.7 39.6 16.3 44 24 44z"/>
                    <path fill="#1976D2" d="M43.6 20.5H42V20H24v8h11.3c-1.1 3.1-3.3 5.4-6.1 6.8l6.2 5.2C39.1 36.5 44 31 44 24c0-1.3-.1-2.3-.4-3.5z"/>
                </svg>
                Masuk dengan Google
            </a>
        @endif
    </div>
</body>
</html>