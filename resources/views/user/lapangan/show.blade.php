@extends('layouts.user')

@section('content')
<div class="max-w-6xl mx-auto">
    <!-- Breadcrumb / Header -->
    <div class="mb-10 text-center md:text-left">
        <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.4em] mb-2">Arena Details</p>
        <h1 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase italic">{{ $lapangan->nama }}</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Visual Container -->
        <div class="glass-card rounded-[3.5rem] p-4 border-white/10 overflow-hidden relative group">
            <div class="h-[450px] rounded-[2.8rem] overflow-hidden relative">
                @if($lapangan->gambar)
                    <img src="{{ asset('uploads/' . $lapangan->gambar) }}"
                         alt="{{ $lapangan->nama }}"
                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                @else
                    <div class="w-full h-full flex flex-col items-center justify-center bg-white/5 text-slate-700">
                        <span class="text-5xl mb-4">🏟️</span>
                        <p class="font-black uppercase tracking-widest text-[10px]">No Visual Data</p>
                    </div>
                @endif
                
                <!-- Price Badge Over Image -->
                <div class="absolute bottom-8 left-8 bg-slate-900/80 backdrop-blur-xl p-6 rounded-[2rem] border border-white/10">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Rate per jam</p>
                    <p class="text-3xl font-black text-emerald-500 italic tracking-tighter">Rp{{ number_format($lapangan->harga, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Info Container -->
        <div class="glass-card rounded-[3.5rem] p-10 md:p-14 border-white/10 flex flex-col">
            <div class="flex items-center justify-between mb-10">
                <div>
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Kategori Arena</p>
                    <h3 class="text-xl font-black text-white uppercase italic tracking-widest">{{ $lapangan->jenis ?: 'Premium Futsal' }}</h3>
                </div>

                @php $status = strtolower(trim($lapangan->status)); @endphp
                @if($status === 'tersedia')
                    <span class="px-5 py-2 text-[9px] rounded-xl bg-emerald-500/10 text-emerald-500 font-black uppercase tracking-widest border border-emerald-500/20 italic">Available Now</span>
                @elseif($status === 'perbaikan')
                    <span class="px-5 py-2 text-[9px] rounded-xl bg-orange-500/10 text-orange-500 font-black uppercase tracking-widest border border-orange-500/20 italic">Under Maintenance</span>
                @else
                    <span class="px-5 py-2 text-[9px] rounded-xl bg-red-500/10 text-red-500 font-black uppercase tracking-widest border border-red-500/20 italic">Fully Booked</span>
                @endif
            </div>

            <div class="flex-1 space-y-8 mb-12">
                <div class="space-y-4">
                    <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] flex items-center gap-3">
                        <span>📝</span> Deskripsi Arena
                    </h4>
                    <div class="bg-white/5 rounded-3xl p-8 border border-white/5">
                        <p class="text-slate-300 text-sm font-medium leading-relaxed italic">
                            "{{ $lapangan->deskripsi ?: 'Nikmati pengalaman bertanding di arena standar internasional dengan fasilitas pencahayaan LED premium, sirkulasi udara optimal, dan lantai anti-slip berkualitas tinggi.' }}"
                        </p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                @if($status === 'tersedia')
                    <a href="{{ route('booking.create', [$current_team, 'lapangan_id' => $lapangan->id]) }}"
                       class="flex-1 bg-emerald-500 hover:bg-emerald-400 text-slate-950 px-10 py-5 rounded-[2rem] font-black text-center transition-all shadow-xl shadow-emerald-500/20 uppercase tracking-widest text-xs italic">
                        Booking Sekarang
                    </a>
                @else
                    <button disabled class="flex-1 bg-white/5 text-slate-600 px-10 py-5 rounded-[2rem] font-black uppercase tracking-widest text-xs cursor-not-allowed italic">
                        Arena Offline
                    </button>
                @endif

                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="bg-white/5 hover:bg-white/10 text-white px-10 py-5 rounded-[2rem] font-black text-center transition-all uppercase tracking-widest text-xs border border-white/5">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</div>
@endsection