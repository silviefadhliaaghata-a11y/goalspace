@extends('layouts.user')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 text-slate-800">

    <!-- HERO -->
    <section class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 md:p-12 relative overflow-hidden">

    <!-- BACKGROUND IMAGE -->
    <div class="absolute inset-0">
       <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=1600&q=80"
             alt="Futsal Field"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-white/75"></div>
    </div>

    <!-- CONTENT -->
    <div class="relative z-10 flex flex-col lg:flex-row justify-between items-center gap-10">

        <div class="max-w-2xl">
            <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-500 mb-4">
                Dashboard Player
            </p>

            <h1 class="text-4xl md:text-6xl font-black leading-tight text-slate-900">
                Halo, {{ explode(' ', auth()->user()->name)[0] }} 👋
            </h1>

            <p class="mt-5 text-slate-700 text-lg leading-relaxed">
                Kelola booking lapangan, pantau aktivitas pertandingan, dan nikmati pengalaman bermain yang lebih praktis.
            </p>

            <div class="mt-8 flex flex-wrap gap-4">
                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="px-7 py-4 rounded-2xl bg-blue-600 hover:bg-blue-700 text-white font-bold uppercase tracking-wide text-sm transition-all">
                    Booking Lapangan
                </a>

                <a href="{{ route('user.booking.index', $current_team) }}"
                   class="px-7 py-4 rounded-2xl border border-slate-300 hover:border-blue-500 hover:text-blue-600 text-slate-700 font-bold uppercase tracking-wide text-sm transition-all bg-white/80">
                    Lihat Aktivitas
                </a>
            </div>
        </div>

        <!-- QUICK SUMMARY -->
        <div class="grid grid-cols-2 gap-4 w-full max-w-md">

            <div class="bg-white/90 backdrop-blur-sm rounded-2xl p-5 border border-slate-200">
                <p class="text-xs uppercase font-bold tracking-widest text-slate-500">Total</p>
                <h3 class="text-4xl font-black mt-2">{{ $totalBookingSaya }}</h3>
            </div>

            <div class="bg-yellow-50/90 backdrop-blur-sm rounded-2xl p-5 border border-yellow-200">
                <p class="text-xs uppercase font-bold tracking-widest text-yellow-600">Pending</p>
                <h3 class="text-4xl font-black mt-2 text-yellow-600">{{ $bookingPending }}</h3>
            </div>

            <div class="bg-blue-50/90 backdrop-blur-sm rounded-2xl p-5 border border-blue-200">
                <p class="text-xs uppercase font-bold tracking-widest text-blue-600">Lunas</p>
                <h3 class="text-4xl font-black mt-2 text-blue-600">{{ $bookingLunas }}</h3>
            </div>

            <div class="bg-emerald-50/90 backdrop-blur-sm rounded-2xl p-5 border border-emerald-200">
                <p class="text-xs uppercase font-bold tracking-widest text-emerald-600">Selesai</p>
                <h3 class="text-4xl font-black mt-2 text-emerald-600">{{ $bookingSelesai }}</h3>
            </div>

        </div>

    </div>
</section>

    <!-- HISTORY -->
    <section class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-200 flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h3 class="text-2xl font-black text-slate-900">
                    Riwayat Booking
                </h3>
                <p class="text-slate-500 mt-1">
                    Aktivitas terbaru Anda.
                </p>
            </div>

            <a href="{{ route('user.booking.index', $current_team) }}"
               class="text-blue-600 font-bold hover:underline">
                Lihat Semua →
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead class="bg-slate-50">
                    <tr class="text-sm uppercase tracking-wide text-slate-500 font-bold">
                        <th class="px-8 py-4 text-left">Lapangan</th>
                        <th class="px-8 py-4 text-center">Tanggal</th>
                        <th class="px-8 py-4 text-center">Status</th>
                        <th class="px-8 py-4 text-right">Total</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                    @forelse($bookingTerbaru as $booking)
                        <tr class="hover:bg-slate-50 transition-all">

                            <td class="px-8 py-6">
                                <div class="font-bold text-lg">
                                    {{ $booking->lapangan->nama ?? '-' }}
                                </div>
                            </td>

                            <td class="px-8 py-6 text-center text-slate-600">
                                {{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }}
                                <div class="text-xs text-slate-400 mt-1">
                                    {{ $booking->jam_mulai }}
                                </div>
                            </td>

                            <td class="px-8 py-6 text-center">
                                @php $status = strtolower($booking->status); @endphp

                                @if($status === 'pending')
                                    <span class="px-4 py-2 rounded-full bg-yellow-100 text-yellow-700 text-xs font-bold uppercase">
                                        Pending
                                    </span>
                                @elseif($status === 'lunas')
                                    <span class="px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase">
                                        Lunas
                                    </span>
                                @else
                                    <span class="px-4 py-2 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold uppercase">
                                        Selesai
                                    </span>
                                @endif
                            </td>

                            <td class="px-8 py-6 text-right font-black text-blue-600 text-lg">
                                Rp{{ number_format($booking->total_harga, 0, ',', '.') }}
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-16 text-center text-slate-500 italic">
                                Belum ada aktivitas booking.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </section>

</div>
@endsection
```
