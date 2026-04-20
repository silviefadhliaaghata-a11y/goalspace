<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - GoalSpace</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 flex items-center justify-center px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <div class="text-center mb-6">
            <h1 class="text-3xl font-bold text-gray-900">GoalSpace</h1>
            <p class="text-sm text-gray-500 mt-2">Buat akun baru untuk booking lapangan futsal</p>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-xl bg-red-50 border border-red-200 p-3 text-sm text-red-700">
                <ul class="list-disc pl-5 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama
                </label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Masukkan nama" required autofocus>
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Masukkan email" required>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password
                </label>
                <input type="password" name="password" id="password"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Masukkan password" required>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Konfirmasi Password
                </label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
                    placeholder="Ulangi password" required>
            </div>

            <button type="submit"
                class="w-full rounded-xl bg-gray-900 text-white py-3 font-semibold hover:bg-black transition">
                Daftar
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">
                Login di sini
            </a>
        </p>
    </div>
</body>
</html>