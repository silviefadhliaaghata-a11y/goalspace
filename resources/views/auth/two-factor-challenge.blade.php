<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi OTP - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="min-h-screen bg-slate-100 flex items-center justify-center px-4">
    <div class="w-full max-w-md">
        <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
            <div class="px-8 pt-8 pb-4 text-center">
                <h1 class="text-2xl font-bold text-slate-800">Verifikasi OTP</h1>
                <p class="text-sm text-slate-500 mt-2">
                    Masukkan kode OTP setelah login
                </p>
            </div>

            <div class="px-8 pb-8" x-data="{ recovery: false }">
                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 px-4 py-3 text-sm">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="flex bg-slate-100 rounded-xl p-1 mb-6">
                    <button type="button"
                            @click="recovery = false"
                            :class="!recovery ? 'bg-white shadow text-slate-900' : 'text-slate-500'"
                            class="w-1/2 rounded-lg py-2 text-sm font-medium transition">
                        Kode OTP
                    </button>

                    <button type="button"
                            @click="recovery = true"
                            :class="recovery ? 'bg-white shadow text-slate-900' : 'text-slate-500'"
                            class="w-1/2 rounded-lg py-2 text-sm font-medium transition">
                        Recovery Code
                    </button>
                </div>

                <form method="POST" action="{{ url('/two-factor-challenge') }}" class="space-y-5">
                    @csrf

                    <div x-show="!recovery">
                        <label class="block text-sm font-medium text-slate-700 mb-2">Kode OTP</label>
                        <input
                            type="text"
                            name="code"
                            inputmode="numeric"
                            autocomplete="one-time-code"
                            placeholder="Masukkan 6 digit OTP"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-center text-lg tracking-[0.3em] focus:outline-none focus:ring-2 focus:ring-slate-300"
                        >
                    </div>

                    <div x-show="recovery" x-cloak>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Recovery Code</label>
                        <input
                            type="text"
                            name="recovery_code"
                            placeholder="Masukkan recovery code"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-slate-300"
                        >
                    </div>

                    <button
                        type="submit"
                        class="w-full bg-slate-900 hover:bg-slate-800 text-white font-semibold py-3 rounded-xl transition"
                    >
                        Verifikasi & Masuk
                    </button>
                </form>

                <div class="mt-5 text-center">
                    <a href="{{ route('login') }}" class="text-sm text-slate-500 hover:text-slate-700">
                        Kembali ke login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>