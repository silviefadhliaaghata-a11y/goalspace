@extends('layouts.user')

@section('content')
<<<<<<< HEAD
<section class="mb-8">
    <div class="bg-gradient-to-r from-green-600 to-green-500 rounded-3xl p-8 text-white shadow-lg">
        <div class="max-w-3xl">
            <p class="text-sm uppercase tracking-widest text-green-100 mb-3">Booking Lapangan Futsal</p>
            <h1 class="text-3xl md:text-4xl font-extrabold leading-tight">
                Pilih Lapangan Terbaik dan Booking Dengan Mudah
            </h1>
            <p class="mt-4 text-green-50 text-sm md:text-base leading-relaxed">
                Lihat lapangan yang tersedia, cek harga per jam, lalu lanjut booking langsung dari halaman ini.
=======
<!-- Hero Section -->
<section class="mb-12 relative">
    <div class="glass-card rounded-[3rem] p-12 overflow-hidden relative">
        <div class="absolute -right-20 -top-20 w-80 h-80 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="max-w-3xl relative z-10">
            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.4em] mb-4">Pro Futsal Management</p>
            <h1 class="text-4xl md:text-6xl font-black text-white leading-none tracking-tighter uppercase italic">
                Pilih <span class="text-emerald-500">Arena</span><br>Tunjukkan Skillmu.
            </h1>
            <p class="mt-6 text-slate-400 font-bold uppercase tracking-widest text-xs leading-relaxed max-w-xl">
                Booking lapangan futsal standar internasional dengan sistem pembayaran instan dan jadwal yang selalu akurat.
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
            </p>
        </div>
    </div>
</section>

<<<<<<< HEAD
<section class="mb-6">
    <div class="flex items-center justify-between">
        <div class="mb-6">
    <form method="GET" action="{{ route('user.lapangan.index', $current_team) }}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama / jenis lapangan..."
                   class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring focus:ring-green-200">

            <select name="status"
                    class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring focus:ring-green-200">
                <option value="">-- Semua Status --</option>
                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>
                    Tersedia
                </option>
                <option value="perbaikan" {{ request('status') == 'perbaikan' ? 'selected' : '' }}>
                    Perbaikan
                </option>
                <option value="tidak tersedia" {{ request('status') == 'tidak tersedia' ? 'selected' : '' }}>
                    Tidak Tersedia
                </option>
            </select>

            <div class="flex gap-3">
                <button type="submit"
                        class="w-full bg-green-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-green-700 transition">
                    Cari
                </button>

                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="w-full bg-gray-100 text-gray-700 px-6 py-3 rounded-2xl font-semibold hover:bg-gray-200 transition text-center">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Lapangan</h2>
            <p class="text-sm text-gray-500">Lapangan tersedia untuk kamu booking</p>
        </div>
    </div>
</section>

@if($lapangans->count() > 0)
    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($lapangans as $lapangan)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-green-100 hover:shadow-xl transition">
                <div class="h-52 bg-green-100 overflow-hidden">
                    @if($lapangan->gambar)
                        <img src="{{ asset('storage/' . $lapangan->gambar) }}"
                             alt="{{ $lapangan->nama }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-green-700 font-medium">
                            No Image
                        </div>
                    @endif
                </div>

                <div class="p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $lapangan->nama }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $lapangan->jenis ?: 'Lapangan Futsal' }}</p>
                        </div>

                        @php
                            $status = strtolower(trim($lapangan->status));
                        @endphp

                        @if($status == 'tersedia')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                Tersedia
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                                Tidak Tersedia
                            </span>
                        @endif
                    </div>

                    <p class="mt-4 text-sm text-gray-600 leading-relaxed min-h-[48px]">
                        {{ $lapangan->deskripsi ?: 'Lapangan siap dipakai untuk booking dengan sistem yang praktis dan cepat.' }}
                    </p>

                    <div class="mt-5 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Harga per jam</p>
                            <p class="text-2xl font-extrabold text-green-600">
                                Rp {{ number_format($lapangan->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
    <a href="{{ route('user.lapangan.show', [$current_team, $lapangan->id]) }}"
       class="block text-center bg-white border border-green-200 text-green-700 py-3 rounded-2xl hover:bg-green-50 transition font-semibold">
        Lihat Detail
    </a>

    <a href="{{ route('booking.create', [$current_team, 'lapangan_id' => $lapangan->id]) }}"
       class="block text-center bg-green-600 text-white py-3 rounded-2xl hover:bg-green-700 transition font-semibold">
        Booking Sekarang
    </a>
</div>
=======
<!-- Filter Section -->
<section class="mb-12">
    <div class="glass-card rounded-[2.5rem] p-8 border-white/5">
        <form method="GET" action="{{ route('user.lapangan.index', $current_team) }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="md:col-span-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Cari Nama Arena atau Jenis Lapangan..."
                           class="w-full bg-white/5 border border-white/10 text-white font-bold uppercase tracking-widest text-xs px-8 py-5 rounded-2xl focus:outline-none focus:border-emerald-500 transition-all placeholder:text-slate-600">
                </div>

                <div>
                    <select name="status" class="w-full bg-white/5 border border-white/10 text-white font-black uppercase tracking-widest text-[10px] px-6 py-5 rounded-2xl focus:outline-none focus:border-emerald-500 transition appearance-none cursor-pointer">
                        <option value="" class="bg-slate-900">Semua Status</option>
                        <option value="tersedia" class="bg-slate-900" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="perbaikan" class="bg-slate-900" {{ request('status') == 'perbaikan' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>

                <button type="submit" class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black py-5 rounded-2xl transition shadow-xl shadow-emerald-500/20 uppercase tracking-widest text-xs italic">
                    Filter Arena
                </button>
            </div>
        </form>
    </div>
</section>

<!-- Grid Section -->
@if($lapangans->count() > 0)
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($lapangans as $lapangan)
            <div class="glass-card rounded-[3rem] overflow-hidden group hover:border-emerald-500/50 transition-all duration-500 flex flex-col">
                <div class="h-64 relative overflow-hidden">
                    @if($lapangan->gambar)
                        <img src="{{ asset('uploads/' . $lapangan->gambar) }}"
                             alt="{{ $lapangan->nama }}"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-white/5 text-slate-700 font-black uppercase tracking-[0.2em] text-xs">
                            No Visual Data
                        </div>
                    @endif
                    
                    <div class="absolute top-6 right-6">
                        @php $status = strtolower(trim($lapangan->status)); @endphp
                        @if($status == 'tersedia')
                            <span class="px-4 py-2 text-[9px] rounded-xl bg-emerald-500/90 backdrop-blur-md text-slate-950 font-black uppercase tracking-widest">Available</span>
                        @else
                            <span class="px-4 py-2 text-[9px] rounded-xl bg-red-600/90 backdrop-blur-md text-white font-black uppercase tracking-widest">Closed</span>
                        @endif
                    </div>
                </div>

                <div class="p-8 flex-1 flex flex-col">
                    <div class="flex items-start justify-between gap-4 mb-4">
                        <div>
                            <h3 class="text-xl font-black text-white tracking-tighter uppercase italic">{{ $lapangan->nama }}</h3>
                            <p class="text-[10px] font-black text-emerald-500 uppercase tracking-widest mt-1">{{ $lapangan->jenis ?: 'Premium Arena' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Rate / Jam</p>
                            <p class="text-xl font-black text-white italic tracking-tight">Rp{{ number_format($lapangan->harga, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <p class="text-slate-400 text-xs font-medium leading-relaxed mb-8 flex-1">
                        {{ $lapangan->deskripsi ?: 'Arena futsal kualitas terbaik dengan pencahayaan maksimal dan sirkulasi udara optimal untuk performa bertanding Anda.' }}
                    </p>

                    <div class="grid grid-cols-2 gap-3 mt-auto">
                        <a href="{{ route('user.lapangan.show', [$current_team, $lapangan->id]) }}"
                           class="text-center bg-white/5 border border-white/10 text-white py-4 rounded-2xl hover:bg-white/10 transition font-black uppercase tracking-widest text-[10px]">
                            Detail
                        </a>

                        @if($status == 'tersedia')
                            <a href="{{ route('booking.create', [$current_team, 'lapangan_id' => $lapangan->id]) }}"
                               class="text-center bg-emerald-500 text-slate-950 py-4 rounded-2xl hover:bg-emerald-400 transition font-black uppercase tracking-widest text-[10px] italic shadow-lg shadow-emerald-500/20">
                                Booking
                            </a>
                        @else
                            <button disabled class="text-center bg-white/5 text-slate-600 py-4 rounded-2xl font-black uppercase tracking-widest text-[10px] cursor-not-allowed">
                                Offline
                            </button>
                        @endif
                    </div>
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
                </div>
            </div>
        @endforeach
    </section>

<<<<<<< HEAD
    <div class="mt-8">
        {{ $lapangans->links() }}
    </div>
@else
   <div class="bg-white rounded-3xl p-10 text-center shadow-sm border border-green-100">
    <h3 class="text-xl font-bold text-gray-800 mb-2">Lapangan Tidak Ditemukan</h3>
    <p class="text-gray-500 mb-5">
        Coba ubah kata kunci pencarian atau filter status yang kamu pilih.
    </p>

    <a href="{{ route('user.lapangan.index', $current_team) }}"
       class="inline-flex items-center justify-center bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 transition">
        Reset Filter
    </a>
</div>
=======
    <div class="mt-12">
        {{ $lapangans->links() }}
    </div>
@else
    <div class="glass-card rounded-[3rem] p-20 text-center border-dashed border-white/10">
        <div class="text-5xl mb-6 opacity-20">🏟️</div>
        <h3 class="text-2xl font-black text-white uppercase tracking-tighter italic">Arena Tidak Ditemukan</h3>
        <p class="text-slate-500 font-bold uppercase tracking-widest text-xs mt-2 mb-8">Coba sesuaikan filter atau kata kunci pencarian Anda.</p>
        <a href="{{ route('user.lapangan.index', $current_team) }}"
           class="inline-block bg-emerald-500 text-slate-950 px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-emerald-400 transition">
            Reset Filter
        </a>
    </div>
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
@endif
@endsection