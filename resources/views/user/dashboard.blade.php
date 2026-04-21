@extends('layouts.user')

@section('content')

{{-- HERO --}}
<section class="mb-10">
    <div class="relative overflow-hidden bg-slate-900 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl">
        <!-- Dekorasi Background -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-emerald-500/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 bg-blue-500/10 rounded-full blur-[100px]"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="text-center md:text-left">
                <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                    Halo, <span class="text-emerald-400">{{ explode(' ', auth()->user()->name)[0] }}</span>! ⚽
                </h1>
                <p class="mt-4 text-slate-400 text-lg max-w-xl font-medium">
                    Siap untuk bertanding hari ini? Booking lapangan favoritmu sekarang dan tunjukkan skil terbaikmu!
                </p>

                <div class="mt-8 flex flex-wrap justify-center md:justify-start gap-4">
                    <a href="{{ route('user.lapangan.index', $current_team) }}"
                       class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 px-8 py-4 rounded-2xl font-black transition shadow-lg shadow-emerald-500/20 uppercase tracking-widest text-sm">
                        Booking Sekarang
                    </a>

                    <a href="{{ route('user.booking.index', $current_team) }}"
                       class="bg-white/10 hover:bg-white/20 backdrop-blur-md text-white border border-white/10 px-8 py-4 rounded-2xl font-black transition uppercase tracking-widest text-sm">
                        Riwayat Main
                    </a>
                </div>
            </div>

            <div class="hidden lg:block relative">
                 <div class="w-48 h-48 bg-gradient-to-tr from-emerald-400 to-emerald-600 rounded-[2rem] rotate-12 flex items-center justify-center shadow-2xl shadow-emerald-500/40">
                    <span class="text-7xl -rotate-12 transform">⚽</span>
                 </div>
            </div>
        </div>
    </div>
</section>

{{-- RINGKASAN STATISTIK --}}
<section class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-10">
    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 group hover:border-emerald-500 transition-all duration-300">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 text-xl group-hover:bg-emerald-500 group-hover:text-white transition-all">
            🏆
        </div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Main</p>
        <h2 class="mt-2 text-3xl font-black text-slate-900">{{ $totalBookingSaya }}</h2>
    </div>

    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 group hover:border-yellow-500 transition-all duration-300">
        <div class="w-12 h-12 bg-yellow-50 text-yellow-600 rounded-2xl flex items-center justify-center mb-4 text-xl group-hover:bg-yellow-500 group-hover:text-white transition-all">
            ⏳
        </div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Menunggu</p>
        <h2 class="mt-2 text-3xl font-black text-slate-900">{{ $bookingPending }}</h2>
    </div>

    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 group hover:border-emerald-500 transition-all duration-300">
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 text-xl group-hover:bg-emerald-500 group-hover:text-white transition-all">
            ✅
        </div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Lunas</p>
        <h2 class="mt-2 text-3xl font-black text-slate-900">{{ $bookingLunas }}</h2>
    </div>

    <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 group hover:border-blue-500 transition-all duration-300">
        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4 text-xl group-hover:bg-blue-500 group-hover:text-white transition-all">
            🌟
        </div>
        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Selesai</p>
        <h2 class="mt-2 text-3xl font-black text-slate-900">{{ $bookingSelesai }}</h2>
    </div>
</section>

{{-- TABEL BOOKING --}}
<section>
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-8 py-6 border-b border-slate-50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-xl font-black text-slate-900">Aktivitas Terakhir</h3>
                <p class="text-sm text-slate-400 font-medium">Jadwal pertandingan kamu yang akan datang</p>
            </div>
            <a href="{{ route('user.booking.index', $current_team) }}" class="text-emerald-500 font-bold text-sm hover:text-emerald-600">Lihat Semua Riwayat →</a>
        </div>

        @if($bookingTerbaru->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-slate-50/50 text-[10px] uppercase tracking-[0.2em] font-black text-slate-400">
                            <th class="px-8 py-4 text-left">Lapangan</th>
                            <th class="px-8 py-4 text-left">Waktu</th>
                            <th class="px-8 py-4 text-left text-right">Total Bayar</th>
                            <th class="px-8 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @foreach($bookingTerbaru as $booking)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-lg">⚽</div>
                                        <span class="font-bold text-slate-800">{{ $booking->lapangan->nama ?? '-' }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-sm">
                                    <div class="flex flex-col">
                                        <span class="font-bold text-slate-700">{{ \Carbon\Carbon::parse($booking->tanggal)->translatedFormat('d M Y') }}</span>
                                        <span class="text-slate-400 text-xs font-medium">{{ $booking->jam_mulai }} - {{ $booking->jam_selesai }} WIB</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <span class="font-black text-slate-900">Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</span>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-center">
                                        @php $status = strtolower($booking->status); @endphp
                                        @if($status === 'pending')
                                            <span class="px-4 py-1.5 rounded-full bg-yellow-100 text-yellow-700 text-[10px] font-black uppercase tracking-widest">Pending</span>
                                        @elseif($status === 'lunas')
                                            <span class="px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700 text-[10px] font-black uppercase tracking-widest text-center">Lunas</span>
                                        @elseif($status === 'selesai')
                                            <span class="px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-[10px] font-black uppercase tracking-widest text-center text-center">Selesai</span>
                                        @else
                                            <span class="px-4 py-1.5 rounded-full bg-red-100 text-red-700 text-[10px] font-black uppercase tracking-widest text-center">Batal</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-16 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-slate-50 rounded-[2rem] text-4xl mb-4">💨</div>
                <h4 class="text-lg font-black text-slate-800">Belum ada booking</h4>
                <p class="text-slate-400 max-w-xs mx-auto mt-2 font-medium text-sm italic">"Lapangan sudah rindu tendanganmu!"</p>
                <div class="mt-6">
                    <a href="{{ route('user.lapangan.index', $current_team) }}" class="text-emerald-500 font-black text-sm uppercase tracking-widest border-b-2 border-emerald-500 pb-1">Cari Lapangan</a>
                </div>
            </div>
        @endif
    </div>
</section>

@endsection