@extends('layouts.user')

@section('content')

{{-- HERO --}}
<section class="mb-8">
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
    </div>
</section>

@endsection