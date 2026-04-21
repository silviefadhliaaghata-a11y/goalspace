@extends('layouts.admin')

@section('title', 'Validasi Booking')
@section('page_heading', 'Security Check-in')

@section('content')
<div class="max-w-4xl mx-auto">

    @if(session('error'))
        <div class="mb-6 rounded-2xl bg-red-500/10 text-red-500 border border-red-500/20 px-6 py-4 font-black uppercase tracking-widest text-[10px]">
            ⚠️ {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="mb-6 rounded-2xl bg-emerald-500/10 text-emerald-500 border border-emerald-500/20 px-6 py-4 font-black uppercase tracking-widest text-[10px]">
            ✅ {{ session('success') }}
        </div>
    @endif

    <div class="glass-card rounded-[3rem] p-12 mb-10 border-white/5 shadow-2xl relative overflow-hidden group">
        <div class="absolute right-0 top-0 p-12 text-6xl opacity-[0.03] group-hover:opacity-10 transition-opacity">🛡️</div>
        <h2 class="text-2xl font-black text-white mb-2 uppercase tracking-tighter italic">Cari Kode Reservasi</h2>
        <p class="text-xs text-slate-500 mb-8 font-bold uppercase tracking-widest">Scan atau ketik kode booking untuk validasi masuk.</p>

        <form method="POST" action="{{ route('admin.booking.validasi.proses', $current_team) }}">
            @csrf

            <div class="flex flex-col sm:flex-row gap-4">
                <input type="text"
                       name="kode_booking"
                       value="{{ old('kode_booking', $booking->kode_booking ?? request('kode')) }}"
                       placeholder="BOOK-202604XX-XXXX"
                       class="flex-1 bg-white/5 border border-white/10 text-white text-xl px-8 py-5 rounded-[2rem] focus:outline-none focus:border-emerald-500 transition-all placeholder:text-slate-700 font-black uppercase tracking-widest"
                       required autofocus>

                <button type="submit"
                        class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 px-12 py-5 rounded-[2rem] font-black transition shadow-xl shadow-emerald-500/20 uppercase tracking-widest text-xs">
                    Search
                </button>
            </div>

            @error('kode_booking')
                <p class="mt-4 text-[10px] text-red-500 font-black uppercase tracking-widest ml-4">{{ $message }}</p>
            @enderror
        </form>
    </div>

    @isset($booking)
        <div class="glass-card rounded-[3rem] p-12 border-emerald-500/20 animate-in fade-in slide-in-from-bottom-10 duration-700">
            <div class="flex items-center justify-between mb-10">
                <h2 class="text-xl font-black text-white uppercase tracking-tighter italic">Informasi Kedatangan</h2>
                <span class="px-4 py-2 text-[9px] rounded-xl bg-white/5 text-slate-400 font-black uppercase tracking-[0.2em] border border-white/10 italic">Verifikasi Berhasil</span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
                <div class="bg-white/5 rounded-3xl p-6 border border-white/5">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Kode Booking</p>
                    <p class="font-black text-white uppercase tracking-widest text-sm">{{ $booking->kode_booking }}</p>
                </div>

                <div class="bg-white/5 rounded-3xl p-6 border border-white/5">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Nama Pelanggan</p>
                    <p class="font-black text-emerald-400 uppercase tracking-widest text-sm">{{ $booking->nama_pemesan }}</p>
                </div>

                <div class="bg-white/5 rounded-3xl p-6 border border-white/5">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Arena Futsal</p>
                    <p class="font-black text-white uppercase tracking-widest text-sm">{{ $booking->lapangan->nama ?? '-' }}</p>
                </div>

                <div class="bg-white/5 rounded-3xl p-6 border border-white/5">
                    <p class="text-[9px] font-black text-slate-500 uppercase tracking-widest mb-1">Jadwal Tanding</p>
                    <p class="font-black text-white uppercase tracking-widest text-sm">
                        {{ \Carbon\Carbon::parse($booking->tanggal)->format('d/m/Y') }} 
                        <span class="mx-1 text-emerald-500 italic">|</span>
                        {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                    </p>
                </div>
            </div>

            <div class="flex items-center justify-between p-8 bg-emerald-500/5 rounded-[2.5rem] border border-emerald-500/10">
                <div>
                    <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1">Status Pembayaran</p>
                    @php $status = strtolower($booking->status); @endphp
                    @if($status === 'lunas')
                        <span class="text-emerald-500 font-black uppercase italic text-xl tracking-tighter">LUNAS / PAID</span>
                    @else
                        <span class="text-orange-500 font-black uppercase italic text-xl tracking-tighter">{{ $status }}</span>
                    @endif
                </div>

                @if(!$booking->checked_in_at)
                    <form method="POST" action="{{ route('admin.booking.checkin', [$current_team, $booking->id]) }}">
                        @csrf
                        <button type="submit"
                                class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 px-10 py-4 rounded-2xl font-black transition shadow-lg shadow-emerald-500/20 uppercase tracking-widest text-xs">
                            Confirm Check-in
                        </button>
                    </form>
                @else
                    <div class="bg-emerald-500 text-slate-950 px-8 py-4 rounded-2xl font-black uppercase tracking-widest text-[9px] flex items-center gap-2">
                        <span>✔️</span> Already Checked-in
                    </div>
                @endif
            </div>
            
            @if($booking->checked_in_at)
                <p class="text-center text-[9px] text-slate-600 font-black uppercase tracking-widest mt-6 italic">Validated on {{ $booking->checked_in_at }}</p>
            @endif
        </div>
    @endisset
</div>
@endsection