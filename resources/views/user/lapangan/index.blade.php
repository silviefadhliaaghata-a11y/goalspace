@extends('layouts.user')

@section('content')
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
            </p>
        </div>
    </div>
</section>

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
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($lapangan->gambar) }}"
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
                </div>
            </div>
        @endforeach
    </section>

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
@endif
@endsection