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
        .glass {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>
<body class="bg-slate-950 min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <!-- Dekorasi Background -->
    <div class="absolute top-0 -left-20 w-96 h-96 bg-blue-500/10 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-0 -right-20 w-96 h-96 bg-emerald-500/20 rounded-full blur-[120px]"></div>

    <div class="w-full max-w-[480px] relative z-10 py-10">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <h1 class="text-4xl font-extrabold text-white tracking-tight">Goal<span class="text-emerald-400">Space</span></h1>
            <p class="text-slate-400 mt-2 italic font-medium">"Gabung sekarang & rasakan kemudahan booking lapangan!"</p>
        </div>

        <div class="glass rounded-[32px] p-8 md:p-10 shadow-2xl">
            <!-- Errors -->
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-2xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                
                <div class="grid grid-cols-1 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-1.5 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus
                            class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all placeholder:text-slate-600"
                            placeholder="John Doe">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-slate-300 mb-1.5 ml-1">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all placeholder:text-slate-600"
                            placeholder="nama@email.com">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1.5 ml-1">Password</label>
                            <input type="password" name="password" required
                                class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all placeholder:text-slate-600"
                                placeholder="••••••••">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-300 mb-1.5 ml-1">Konfirmasi</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full bg-slate-900/50 border border-slate-700 text-white rounded-2xl px-5 py-3.5 focus:outline-none focus:ring-2 focus:ring-emerald-500/50 focus:border-emerald-500 transition-all placeholder:text-slate-600"
                                placeholder="••••••••">
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-400 hover:to-emerald-500 text-white font-extrabold py-4 rounded-2xl shadow-lg shadow-emerald-500/25 transform transition active:scale-[0.98] duration-200">
                        Buat Akun Saya
                    </button>
                </div>

                <div class="relative py-2 text-center">
                    <span class="text-slate-500 text-[10px] uppercase tracking-widest font-bold">Atau Bergabung Dengan</span>
                </div>

                <!-- Google Register Button -->
                <a href="{{ route('google.login') }}"
                   class="w-full flex items-center justify-center gap-3 bg-slate-900/50 hover:bg-slate-800 border border-slate-700 text-white font-bold py-4 rounded-2xl transition active:scale-[0.98] duration-200">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                    Daftar via Google
                </a>
            </form>
        </div>

        <p class="text-center mt-8 text-slate-400">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-emerald-400 font-bold hover:underline underline-offset-4 ml-1">Login di sini</a>
        </p>
    </div>
</body>
</html>