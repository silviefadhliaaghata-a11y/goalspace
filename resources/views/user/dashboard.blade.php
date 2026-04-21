@extends('layouts.user')

@section('content')

{{-- HERO --}}
<section class="mb-8">
    <div class="relative overflow-hidden glass-card rounded-[2.5rem] p-8 md:p-12 shadow-2xl">
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px]"></div>
        
        <div class="relative z-10">
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                Halo, <span class="text-emerald-400">{{ explode(' ', auth()->user()->name)[0] }}!</span> ⚽
            </h1>
            <p class="mt-4 text-gray-400 text-lg max-w-xl font-medium italic">
                "Kemenangan hari ini dimulai dari booking lapangan yang tepat."
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 px-8 py-4 rounded-2xl font-black transition shadow-lg shadow-emerald-500/20 uppercase tracking-widest text-sm">
                    BOOKING LAPANGAN 🏟️
                </a>
            </div>
        </div>
    </div>
</section>

{{-- STATS --}}
<section class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="glass-card rounded-3xl p-6 hover:border-emerald-500 transition-all duration-300">
        <p class="text-[10px] font-bold text-emerald-400 uppercase tracking-[0.2em] mb-1">Total Main</p>
        <h2 class="text-4xl font-black">{{ $totalBookingSaya }}</h2>
    </div>

    <div class="glass-card rounded-3xl p-6 hover:border-yellow-500 transition-all duration-300 text-yellow-500">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] mb-1">Menunggu</p>
        <h2 class="text-4xl font-black">{{ $bookingPending }}</h2>
    </div>

    <div class="glass-card rounded-3xl p-6 hover:border-emerald-500 transition-all duration-300 text-emerald-400">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] mb-1 text-emerald-400">Lunas</p>
        <h2 class="text-4xl font-black text-emerald-400">{{ $bookingLunas }}</h2>
    </div>

    <div class="glass-card rounded-3xl p-6 hover:border-blue-500 transition-all duration-300 text-blue-400">
        <p class="text-[10px] font-bold uppercase tracking-[0.2em] mb-1 text-blue-400">Selesai</p>
        <h2 class="text-4xl font-black text-blue-400">{{ $bookingSelesai }}</h2>
    </div>
</section>

{{-- LATEST ACTIVITIES --}}
<section class="glass-card rounded-[2.5rem] overflow-hidden">
    <div class="px-8 py-6 border-b border-white/10 flex justify-between items-center">
        <h3 class="text-xl font-black uppercase tracking-widest">Riwayat Terakhir</h3>
        <a href="{{ route('user.booking.index', $current_team) }}" class="text-emerald-400 font-bold text-xs hover:underline uppercase tracking-widest">Lihat Semua →</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-white/5">
                <tr class="text-[10px] font-black text-gray-500 uppercase tracking-[0.3em]">
                    <th class="px-8 py-4 text-left">Lapangan</th>
                    <th class="px-8 py-4 text-center">Status</th>
                    <th class="px-8 py-4 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($bookingTerbaru as $booking)
                    <tr class="hover:bg-white/5 transition">
                        <td class="px-8 py-6 font-bold text-gray-300">
                            {{ $booking->lapangan->nama ?? '-' }}
                            <div class="text-[10px] text-gray-500 mt-1 font-medium">{{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }} | {{ $booking->jam_mulai }}</div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @php $status = strtolower($booking->status); @endphp
                            @if($status === 'pending')
                                <span class="px-3 py-1 rounded-full bg-yellow-500/10 text-yellow-500 text-[9px] font-black uppercase tracking-widest border border-yellow-500/20">Pending</span>
                            @elseif($status === 'lunas')
                                <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 text-[9px] font-black uppercase tracking-widest border border-emerald-500/20 text-center">Lunas</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-blue-500/10 text-blue-400 text-[9px] font-black uppercase tracking-widest border border-blue-500/20 text-center text-center">Selesai</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right font-black text-emerald-400">Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-8 py-20 text-center text-gray-500 italic">Belum ada aktivitas booking.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>

@endsection