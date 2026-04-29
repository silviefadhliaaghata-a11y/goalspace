<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | GoalSpace⚽</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: #0f172a;
        }
        .glass-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0.01));
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .soccer-bg {
            background-image: linear-gradient(rgba(15, 23, 42, 0.85), rgba(15, 23, 42, 0.95)), url('https://images.unsplash.com/photo-1574629810360-7efbbe195018?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
        }
        .input-glass {
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .input-glass:focus {
            background: rgba(255, 255, 255, 0.07);
            border-color: #10b981;
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.1);
        }
        .btn-glow {
            box-shadow: 0 0 20px rgba(16, 185, 129, 0.2);
            transition: all 0.3s ease;
        }
        .btn-glow:hover {
            box-shadow: 0 0 35px rgba(16, 185, 129, 0.4);
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="soccer-bg min-h-screen flex flex-col items-center justify-center p-6 antialiased">
    
    <div class="w-full max-w-[420px]">
        <!-- Brand -->
        <div class="text-center mb-10 transform transition-all duration-700">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-emerald-500/10 rounded-[2rem] border border-emerald-500/20 mb-4 shadow-2xl">
                <span class="text-4xl animate-bounce">⚽</span>
            </div>
            <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic leading-none">
                Goal<span class="text-emerald-500">Space</span>
            </h1>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.4em] mt-2">Arena Reservation System</p>
        </div>

        <!-- Login Card -->
        <div class="glass-container rounded-[2.5rem] p-8 md:p-10 relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-40 h-40 bg-emerald-500/10 rounded-full blur-[60px]"></div>
            
            <div class="relative z-10">
                <h2 class="text-xl font-black text-white tracking-tight uppercase italic mb-1">Selamat Datang</h2>
                <p class="text-slate-400 text-xs font-medium mb-8">Masuk untuk mengelola arena Anda.</p>

                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-[10px] font-bold uppercase tracking-wider italic">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="input-glass w-full text-white rounded-2xl px-6 py-4 focus:outline-none placeholder:text-slate-700 text-sm font-bold"
                            placeholder="nama@email.com">
                    </div>

                    <div class="space-y-2">
                        <div class="flex justify-between items-center px-1">
                            <label class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em]">Password</label>
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-[9px] font-black text-emerald-500 uppercase tracking-widest hover:text-emerald-400 transition-colors">Lupa?</a>
                            @endif
                        </div>
                        <input type="password" name="password" required
                            class="input-glass w-full text-white rounded-2xl px-6 py-4 focus:outline-none placeholder:text-slate-700 text-sm font-bold"
                            placeholder="••••••••">
                    </div>

                    <div class="flex items-center px-1">
                        <label class="group flex items-center cursor-pointer">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="remember" class="peer hidden">
                                <div class="w-5 h-5 border-2 border-slate-700 rounded-lg peer-checked:bg-emerald-500 peer-checked:border-emerald-500 transition-all duration-300"></div>
                                <svg class="absolute w-3 h-3 text-slate-950 left-1 opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="ml-3 text-[10px] font-bold text-slate-400 uppercase tracking-wider group-hover:text-slate-300 transition-colors">Tetap Masuk</span>
                        </label>
                    </div>

                    <button type="submit"
                        class="btn-glow w-full bg-emerald-500 text-slate-950 font-black py-5 rounded-2xl uppercase tracking-[0.2em] text-xs transition active:scale-95">
                        Login Sekarang ⚡
                    </button>

                    <div class="relative py-4">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/5"></div></div>
                        <div class="relative flex justify-center text-[9px] uppercase font-black tracking-[0.5em] text-slate-600"><span class="bg-[#0f172a] px-4">OR</span></div>
                    </div>

                    <a href="{{ route('google.login') }}"
                       class="w-full flex items-center justify-center gap-3 bg-white/5 hover:bg-white/10 border border-white/5 text-white font-black py-4 rounded-2xl transition active:scale-95 group">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 group-hover:scale-110 transition-transform" alt="Google">
                        <span class="text-xs uppercase tracking-widest">Google Login</span>
                    </a>
                </form>
            </div>
        </div>

        <div class="mt-10 text-center">
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-emerald-500 hover:text-emerald-400 ml-1 transition-colors underline decoration-2 underline-offset-4">Join The Club</a>
            </p>
        </div>
    </div>

</body>
</html>