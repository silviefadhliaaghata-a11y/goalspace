<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | GoalSpace - Booking Lapangan Futsal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Dekorasi Background -->
    <div class="absolute top-0 -left-20 w-96 h-96 bg-emerald-500/20 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 -right-20 w-96 h-96 bg-blue-600/10 rounded-full blur-[120px]"></div>

    <div class="w-full max-w-[440px] relative z-10">
        <!-- Logo & Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-emerald-400 to-emerald-600 mb-4 shadow-lg shadow-emerald-500/20">
                <span class="text-3xl text-white">⚽</span>
            </div>
            <h1 class="text-4xl font-extrabold text-white tracking-tight">Goal<span class="text-emerald-400">Space</span></h1>
            <p class="text-slate-400 mt-2">Selamat datang kembali, siap cetak gol hari ini?</p>
        </div>

        <div class="glass rounded-[32px] p-8 md:p-10 shadow-2xl">
            <!-- Alert Status -->
            @if (session('status'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Error List -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm italic">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-slate-300 mb-2 ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all duration-300 placeholder:text-slate-600"
                        placeholder="nama@email.com">
                </div>

                <div>
                    <div class="flex justify-between mb-2 ml-1">
                        <label class="text-sm font-semibold text-slate-300">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-xs font-semibold text-emerald-400 hover:text-emerald-300">Lupa?</a>
                        @endif
                    </div>
                    <input type="password" name="password" required
                        class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all duration-300 placeholder:text-slate-600"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center px-1">
                    <label class="flex items-center cursor-pointer group text-slate-400 text-sm">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-slate-700 bg-slate-900 text-emerald-500 focus:ring-emerald-500/50 focus:ring-offset-slate-950">
                        <span class="ml-3 group-hover:text-slate-200 transition-colors">Ingat saya</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-400 hover:to-emerald-500 text-white font-bold py-4 rounded-2xl shadow-lg shadow-emerald-500/25 transform transition active:scale-[0.98] duration-200">
                    Masuk Sekarang
                </button>

                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-800"></div></div>
                    <div class="relative flex justify-center text-xs"><span class="bg-slate-900/50 px-4 text-slate-500 uppercase tracking-widest font-bold">Atau</span></div>
                </div>

                <!-- Google Login Button -->
                <a href="{{ route('google.login') }}"
                   class="w-full flex items-center justify-center gap-3 bg-white hover:bg-slate-50 text-slate-900 font-bold py-4 rounded-2xl transition shadow-xl active:scale-[0.98] duration-200">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                    Login dengan Google
                </a>
            </form>
        </div>

        <p class="text-center mt-8 text-slate-400">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-emerald-400 font-bold hover:underline underline-offset-4 ml-1">Daftar Sekarang</a>
        </p>
    </div>
</body>
</html>