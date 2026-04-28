@extends('layouts.user')

@section('content')

{{-- HERO --}}
<section class="mb-8">
<<<<<<< HEAD
    <div class="bg-gradient-to-r from-green-600 to-green-500 rounded-3xl p-8 text-white shadow-lg">
        <h1 class="text-3xl font-extrabold">
            Selamat Datang, {{ auth()->user()->name }} 👋
        </h1>
        <p class="mt-2 text-green-100">
            Booking lapangan futsal sekarang jadi lebih mudah, cepat, dan rapi.
        </p>

        <div class="mt-6 flex flex-col sm:flex-row gap-3">
            <a href="{{ route('user.lapangan.index', $current_team) }}"
               class="bg-white text-green-600 px-5 py-3 rounded-2xl font-semibold hover:bg-green-100 transition text-center">
                Booking Sekarang
            </a>

            <a href="{{ route('user.booking.index', $current_team) }}"
               class="bg-green-700 text-white px-5 py-3 rounded-2xl font-semibold hover:bg-green-800 transition text-center">
                Booking Saya
            </a>
            @php
    $team = auth()->user()?->currentTeam ?? auth()->user()?->personalTeam();
@endphp

@if ($team)
    <a href="{{ route('2fa.settings', ['current_team' => $team->slug]) }}"
       class="inline-flex items-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 transition">
        Pengaturan OTP
    </a>
@endif
        </div>
    </div>
</section>

{{-- RINGKASAN --}}
<section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-green-100">
        <p class="text-sm text-gray-500">Total Booking Saya</p>
        <h2 class="mt-3 text-3xl font-extrabold text-gray-800">{{ $totalBookingSaya }}</h2>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-yellow-100">
        <p class="text-sm text-gray-500">Booking Pending</p>
        <h2 class="mt-3 text-3xl font-extrabold text-yellow-600">{{ $bookingPending }}</h2>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-green-100">
        <p class="text-sm text-gray-500">Booking Lunas</p>
        <h2 class="mt-3 text-3xl font-extrabold text-green-600">{{ $bookingLunas }}</h2>
    </div>

    <div class="bg-white rounded-3xl p-6 shadow-sm border border-blue-100">
        <p class="text-sm text-gray-500">Booking Selesai</p>
        <h2 class="mt-3 text-3xl font-extrabold text-blue-600">{{ $bookingSelesai }}</h2>
    </div>
</section>

{{-- MENU CEPAT --}}
<section class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="{{ route('user.lapangan.index', $current_team) }}"
       class="bg-white p-6 rounded-3xl shadow-sm border border-green-100 hover:shadow-lg transition">
        <h3 class="font-bold text-lg text-gray-800 mb-2">Pilih Lapangan</h3>
        <p class="text-sm text-gray-500">
            Lihat daftar lapangan yang tersedia dan temukan yang paling cocok untuk kamu.
        </p>
    </a>

    <a href="{{ route('booking.create', $current_team) }}"
       class="bg-white p-6 rounded-3xl shadow-sm border border-green-100 hover:shadow-lg transition">
        <h3 class="font-bold text-lg text-gray-800 mb-2">Booking Baru</h3>
        <p class="text-sm text-gray-500">
            Buat booking lapangan baru dengan cepat dan mudah dari halaman ini.
        </p>
    </a>

    <a href="{{ route('user.booking.index', $current_team) }}"
       class="bg-white p-6 rounded-3xl shadow-sm border border-green-100 hover:shadow-lg transition">
        <h3 class="font-bold text-lg text-gray-800 mb-2">Booking Saya</h3>
        <p class="text-sm text-gray-500">
            Cek riwayat booking, status pembayaran, dan detail jadwal bermain kamu.
        </p>
    </a>
</section>
<section class="mt-8">
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-green-100">
        <div class="flex items-center justify-between mb-5">
            <div>
                <h3 class="text-xl font-bold text-gray-800">Booking Terbaru</h3>
                <p class="text-sm text-gray-500">5 data booking terakhir milik kamu</p>
            </div>

            <a href="{{ route('user.booking.index', $current_team) }}"
               class="text-green-600 font-semibold text-sm hover:text-green-700">
                Lihat Semua
            </a>
        </div>

        @if($bookingTerbaru->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-green-50 text-gray-700">
                        <tr>
                            <th class="p-3 text-left">Lapangan</th>
                            <th class="p-3 text-left">Tanggal</th>
                            <th class="p-3 text-left">Jam</th>
                            <th class="p-3 text-left">Total</th>
                            <th class="p-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookingTerbaru as $booking)
                            <tr class="border-t hover:bg-green-50/50 transition">
                                <td class="p-3 font-medium text-gray-800">
                                    {{ $booking->lapangan->nama ?? '-' }}
                                </td>
                                <td class="p-3 text-gray-600">
                                    {{ $booking->tanggal }}
                                </td>
                                <td class="p-3 text-gray-600">
                                    {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                                </td>
                                <td class="p-3 font-bold text-green-600">
                                    Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="p-3">
                                    @php
                                        $status = strtolower($booking->status);
                                    @endphp

                                    @if($status === 'pending')
                                        <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                                            Pending
                                        </span>
                                    @elseif($status === 'lunas')
                                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                            Lunas
                                        </span>
                                    @elseif($status === 'selesai')
                                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-semibold">
                                            Selesai
                                        </span>
                                    @else
                                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                                            Batal
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="rounded-2xl border border-dashed border-green-200 p-8 text-center">
                <h4 class="text-lg font-bold text-gray-800 mb-2">Belum Ada Booking</h4>
                <p class="text-gray-500 mb-4">Kamu belum punya riwayat booking terbaru.</p>

                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="inline-flex items-center justify-center bg-green-600 text-white px-5 py-3 rounded-xl font-semibold hover:bg-green-700 transition">
                    Booking Sekarang
                </a>
            </div>
        @endif
=======
    <div class="relative overflow-hidden glass-card rounded-[2.5rem] p-6 md:p-12 shadow-2xl">
        <div class="absolute -top-24 -left-24 w-64 h-64 bg-emerald-500/10 rounded-full blur-[80px]"></div>
        
        <div class="relative z-10 text-center md:text-left">
            <h1 class="text-3xl md:text-5xl font-black tracking-tight leading-tight uppercase italic">
                Halo, <span class="text-emerald-400">{{ explode(' ', auth()->user()->name)[0] }}!</span> ⚽
            </h1>
            <p class="mt-4 text-gray-400 text-sm md:text-lg max-w-xl font-medium italic">
                "Kemenangan hari ini dimulai dari booking lapangan yang tepat."
            </p>

            <div class="mt-8 flex flex-wrap justify-center md:justify-start gap-4">
                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="w-full md:w-auto bg-emerald-500 hover:bg-emerald-400 text-slate-950 px-8 py-4 rounded-2xl font-black transition shadow-lg shadow-emerald-500/20 uppercase tracking-widest text-xs italic">
                    BOOKING LAPANGAN 🏟️
                </a>
            </div>
        </div>
    </div>
</section>

{{-- STATS --}}
<section class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="glass-card rounded-3xl p-5 hover:border-emerald-500 transition-all duration-300">
        <p class="text-[9px] font-black text-emerald-400 uppercase tracking-[0.2em] mb-1">Total Main</p>
        <h2 class="text-3xl font-black">{{ $totalBookingSaya }}</h2>
    </div>

    <div class="glass-card rounded-3xl p-5 hover:border-yellow-500 transition-all duration-300 text-yellow-500">
        <p class="text-[9px] font-black uppercase tracking-[0.2em] mb-1">Menunggu</p>
        <h2 class="text-3xl font-black">{{ $bookingPending }}</h2>
    </div>

    <div class="glass-card rounded-3xl p-5 hover:border-emerald-500 transition-all duration-300 text-emerald-400">
        <p class="text-[9px] font-black uppercase tracking-[0.2em] mb-1 text-emerald-400">Lunas</p>
        <h2 class="text-3xl font-black text-emerald-400">{{ $bookingLunas }}</h2>
    </div>

    <div class="glass-card rounded-3xl p-5 hover:border-blue-500 transition-all duration-300 text-blue-400">
        <p class="text-[9px] font-black uppercase tracking-[0.2em] mb-1 text-blue-400">Selesai</p>
        <h2 class="text-3xl font-black text-blue-400">{{ $bookingSelesai }}</h2>
    </div>
</section>

{{-- LATEST ACTIVITIES --}}
<section class="glass-card rounded-[2.5rem] overflow-hidden">
    <div class="px-8 py-6 border-b border-white/10 flex flex-col md:flex-row gap-4 justify-between items-center">
        <h3 class="text-lg font-black uppercase tracking-widest italic">Riwayat Terakhir</h3>
        <a href="{{ route('user.booking.index', $current_team) }}" class="text-emerald-400 font-black text-[10px] hover:underline uppercase tracking-widest">Lihat Semua →</a>
    </div>

    <div class="overflow-x-auto overflow-y-hidden">
        <table class="w-full min-w-[600px]">
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
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
    </div>
</section>

@endsection