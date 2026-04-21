<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | GoalSpace⚽</title>
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
            background-attachment: fixed;
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
<body class="soccer-bg min-h-screen flex flex-col items-center justify-center p-6 antialiased py-12">
    
    <div class="w-full max-w-[480px]">
        <!-- Brand -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-white tracking-tighter uppercase italic leading-none">
                Create Account
            </h1>
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-[0.4em] mt-2">Join GoalSpace Community</p>
        </div>

        <!-- Register Card -->
        <div class="glass-container rounded-[2.5rem] p-8 md:p-10 relative overflow-hidden">
            <div class="absolute -right-20 -top-20 w-40 h-40 bg-emerald-500/10 rounded-full blur-[60px]"></div>
            
            <div class="relative z-10">
                @if (\$errors->any())
                    <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-[10px] font-bold uppercase tracking-wider italic">
                        {{ \$errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf
                    
                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="input-glass w-full text-white rounded-2xl px-6 py-3.5 focus:outline-none placeholder:text-slate-700 text-sm font-bold"
                            placeholder="Aditya Novaldy">
                    </div>

                    <div class="space-y-1.5">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="input-glass w-full text-white rounded-2xl px-6 py-3.5 focus:outline-none placeholder:text-slate-700 text-sm font-bold"
                            placeholder="nama@email.com">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Password</label>
                            <input type="password" name="password" required
                                class="input-glass w-full text-white rounded-2xl px-6 py-3.5 focus:outline-none placeholder:text-slate-700 text-sm font-bold"
                                placeholder="••••••••">
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] ml-1">Confirm</label>
                            <input type="password" name="password_confirmation" required
                                class="input-glass w-full text-white rounded-2xl px-6 py-3.5 focus:outline-none placeholder:text-slate-700 text-sm font-bold"
                                placeholder="••••••••">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="btn-glow w-full bg-emerald-500 text-slate-950 font-black py-5 rounded-2xl uppercase tracking-[0.2em] text-xs transition active:scale-95">
                            Daftar & Main ⚡
                        </button>
                    </div>

                    <div class="relative py-4">
                        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/5"></div></div>
                        <div class="relative flex justify-center text-[9px] uppercase font-black tracking-[0.5em] text-slate-600"><span class="bg-[#0f172a] px-4">OR</span></div>
                    </div>

                    <a href="{{ route('google.login') }}"
                       class="w-full flex items-center justify-center gap-3 bg-white/5 hover:bg-white/10 border border-white/5 text-white font-black py-4 rounded-2xl transition active:scale-95 group">
                        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5 group-hover:scale-110 transition-transform" alt="Google">
                        <span class="text-xs uppercase tracking-widest">Sign Up with Google</span>
                    </a>
                </form>
            </div>
        </div>

        <div class="mt-8 text-center">
            <p class="text-slate-500 text-[10px] font-black uppercase tracking-widest">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-emerald-500 hover:text-emerald-400 ml-1 transition-colors underline decoration-2 underline-offset-4">Masuk Disini</a>
            </p>
        </div>
    </div>

</body>
</html>