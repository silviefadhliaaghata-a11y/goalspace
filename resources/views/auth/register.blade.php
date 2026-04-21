<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar | GoalSpace - Booking Lapangan Futsal</title>
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
            background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1529900748604-07564a03e7a6?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
        }
    </style>
</head>
<body class="bg-soccer min-h-screen flex items-center justify-center p-4 py-12">
    
    <div class="w-full max-w-[480px] relative">
        <div class="flex justify-center mb-6">
            <div class="flex items-center gap-2">
                <span class="text-4xl">⚽</span>
                <span class="text-3xl font-extrabold text-white tracking-tighter text-center leading-none">GOAL<br><span class="text-emerald-400">SPACE</span></span>
            </div>
        </div>

        <div class="glass-card rounded-[2.5rem] p-8 md:p-10 shadow-2xl relative">
            <div class="absolute -bottom-24 -right-24 w-48 h-48 bg-emerald-500/20 rounded-full blur-[60px]"></div>

            <div class="relative z-10 text-center mb-8">
                <h2 class="text-2xl font-bold text-white">Buat Akun Baru</h2>
                <p class="text-gray-400 text-sm mt-1">Gabung komunitas futsal terbesar</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-xs italic">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                
                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full bg-white/5 border border-white/10 text-white rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:bg-white/10 transition-all placeholder:text-gray-600"
                        placeholder="Si Pemain Handal">
                </div>

                <div class="space-y-1.5">
                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full bg-white/5 border border-white/10 text-white rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:bg-white/10 transition-all placeholder:text-gray-600"
                        placeholder="email@anda.com">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Password</label>
                        <input type="password" name="password" required
                            class="w-full bg-white/5 border border-white/10 text-white rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:bg-white/10 transition-all placeholder:text-gray-600"
                            placeholder="••••••••">
                    </div>
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest ml-1">Konfirmasi</label>
                        <input type="password" name="password_confirmation" required
                            class="w-full bg-white/5 border border-white/10 text-white rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:bg-white/10 transition-all placeholder:text-gray-600"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black py-4 rounded-2xl shadow-xl shadow-emerald-500/20 transform transition active:scale-[0.97] duration-200 uppercase tracking-widest text-sm">
                        DAFTAR SEKARANG ⚽
                    </button>
                </div>

                <div class="relative py-2">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-white/10"></div></div>
                    <div class="relative flex justify-center text-[10px]"><span class="bg-[#0f172a]/0 px-4 text-gray-500 uppercase tracking-[0.3em] font-bold">Atau</span></div>
                </div>

                <a href="{{ route('google.login') }}"
                   class="w-full flex items-center justify-center gap-3 bg-white/10 hover:bg-white/20 border border-white/10 text-white font-bold py-4 rounded-2xl transition active:scale-[0.97]">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                    <span class="text-sm">Gabung via Google</span>
                </a>
            </form>
        </div>

        <p class="text-center mt-8 text-gray-400 text-sm">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-emerald-400 font-bold hover:text-emerald-300 ml-1 transition-colors">Login di sini</a>
        </p>

        <div class="mt-12 text-center">
            <p class="text-[10px] font-bold text-gray-500 uppercase tracking-[0.2em]">
                © {{ date('Y') }} GoalSpace | Coding by 
                <a href="https://sekawanputrapratama.com" target="_blank" class="text-emerald-400 hover:text-emerald-300 transition">Sekawan Putra Pratama</a>
            </p>
        </div>
    </div>
</body>
</html>