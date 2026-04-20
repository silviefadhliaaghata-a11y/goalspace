<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="bg-white p-8 rounded-xl shadow w-full max-w-md">
        <h2 class="text-2xl font-bold mb-4 text-center">
            Konfirmasi Password
        </h2>

        <p class="text-sm text-gray-600 mb-6 text-center">
            Masukkan password untuk melanjutkan
        </p>

        @if ($errors->any())
            <div class="mb-4 text-red-500 text-sm">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <input type="password" name="password"
                class="w-full border rounded-lg px-3 py-2 mb-4"
                placeholder="Password" required autofocus>

            <button type="submit"
                class="w-full bg-black text-white py-2 rounded-lg">
                Konfirmasi
            </button>
        </form>
    </div>

</body>
</html>