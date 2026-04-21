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
        .glass-card {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .bg-soccer {
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-soccer min-h-screen flex items-center justify-center p-4">
    
    <div class="w-full max-w-[440px] relative">
        <!-- Logo Branding -->
        <div class="flex justify-center mb-6">
            <div class="flex items-center gap-2">
                <span class="text-4xl">⚽</span>
                <span class="text-3xl font-extrabold text-white tracking-tighter text-center leading-none">GOAL<br><span class="text-emerald-400">SPACE</span></span>
            </div>
        </div>

        <!-- Form Card -->
        <div class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-2xl overflow-hidden relative">
            <!-- Glow Effect -->
            <div class="absolute -top-24 -left-24 w-48 h-48 bg-emerald-500/20 rounded-full blur-[60px]"></div>

            <div class="relative z-10 text-center mb-8">
                <h2 class="text-2xl font-bold text-white">Selamat Datang</h2>
                <p class="text-gray-400 text-sm mt-1">Masuk untuk mulai booking lapangan</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs italic">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full bg-white/5 border border-white/10 text-white rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:bg-white/10 transition-all duration-300 placeholder:text-gray-600"
                        placeholder="email@anda.com">
                </div>

                <div class="space-y-1.5">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-[10px] font-bold text-emerald-400 uppercase tracking-widest">Lupa?</a>
                        @endif
                    </div>
                    <input type="password" name="password" required
                        class="w-full bg-white/5 border border-white/10 text-white rounded-2xl px-5 py-4 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:bg-white/10 transition-all duration-300 placeholder:text-gray-600"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center px-1 py-1">
                    <label class="flex items-center cursor-pointer text-gray-400 text-xs">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/10 bg-black/40 text-emerald-500 focus:ring-emerald-500/50">
                        <span class="ml-3 font-medium">Biarkan saya tetap masuk</span>
                    </label>
                </div>

                <button type="submit"
                    class="w-full bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black py-4 rounded-2xl shadow-xl shadow-emerald-500/20 transform transition active:scale-[0.97] duration-200 uppercase tracking-widest text-sm">
                    GAS LOGIN! 🚀
                </button>

                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/10"></div></div>
                    <div class="relative flex justify-center text-[10px]"><span class="bg-[#0f172a]/0 px-4 text-gray-500 uppercase tracking-[0.3em] font-bold">Atau</span></div>
                </div>

                <a href="{{ route('google.login') }}"
                   class="w-full flex items-center justify-center gap-3 bg-white/10 hover:bg-white/20 border border-white/10 text-white font-bold py-4 rounded-2xl transition active:scale-[0.97]">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                    <span class="text-sm">Masuk via Google</span>
                </a>
            </form>
        </div>

        <p class="text-center mt-8 text-gray-400 text-sm">
            Belum punya akun? 
            <a href="{{ route('register') }}" class="text-emerald-400 font-bold hover:text-emerald-300 ml-1 transition-colors">Daftar Sekarang</a>
        </p>

        <div class="mt-12 text-center">
            <p class="text-[10px] text-gray-500 font-medium uppercase tracking-wider">
                © {{ date('Y') }} <span class="font-bold text-white">GoalSpace</span>. All Rights Reserved.
            </p>
            <p class="text-[9px] mt-2 font-black tracking-[0.2em]">
                <span class="text-gray-600">PUBLISHED BY</span> 
                <a href="https://sekawanputrapratama.com" target="_blank" class="text-yellow-500 hover:text-blue-500 transition-colors">WWW.SEKAWANPUTRAPRATAMA.COM</a>
            </p>
        </div>
    </div>
</body>
</html>