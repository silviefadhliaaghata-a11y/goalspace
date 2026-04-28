@extends('layouts.user')

@section('content')
<div class="mb-8">
    <div class="bg-gradient-to-r from-green-600 to-green-500 rounded-3xl p-8 text-white shadow-lg">
        <h1 class="text-3xl font-extrabold">Booking Saya</h1>
        <p class="mt-2 text-green-100">
            Lihat status booking, jadwal bermain, dan bukti pembayaran kamu di sini.
        </p>
    </div>
</div>

<div class="bg-white rounded-3xl shadow-sm border border-green-100 p-6">
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-xl font-bold text-gray-800">Riwayat Booking</h2>
            <p class="text-sm text-gray-500">Semua data booking milik kamu</p>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <form method="GET" action="{{ route('user.booking.index', $current_team) }}">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari tanggal / lapangan..."
                       class="w-full sm:w-72 rounded-xl border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring focus:ring-green-200">
            </form>

            <a href="{{ route('user.lapangan.index', $current_team) }}"
               class="inline-flex items-center justify-center bg-green-600 text-white px-5 py-3 rounded-xl font-semibold hover:bg-green-700 transition">
                Booking Baru
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-xl bg-green-100 border border-green-200 px-4 py-3 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($bookings->count() > 0)
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
            @foreach($bookings as $booking)
                <div class="rounded-2xl border border-green-100 bg-green-50/40 p-5 hover:shadow-md transition">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">
                                {{ $booking->lapangan->nama ?? '-' }}
                            </h3>
                            <p class="text-sm text-gray-500 mt-1">
                                Pemesan: {{ $booking->nama_pemesan }}
                            </p>
                        </div>

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
                    </div>

                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        <div class="bg-white rounded-xl p-4 border border-green-100">
                            <p class="text-gray-500">Tanggal</p>
                            <p class="font-semibold text-gray-800 mt-1">{{ $booking->tanggal }}</p>
                        </div>

                        <div class="bg-white rounded-xl p-4 border border-green-100">
                            <p class="text-gray-500">Jam Main</p>
                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                            </p>
                        </div>

                        <div class="bg-white rounded-xl p-4 border border-green-100">
                            <p class="text-gray-500">Total Harga</p>
                            <p class="font-bold text-green-600 mt-1">
                                Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="bg-white rounded-xl p-4 border border-green-100">
    <p class="text-gray-500">Kode Booking</p>
    <p class="font-bold text-gray-800 mt-1">
        {{ $booking->kode_booking ?? '-' }}
    </p>
</div>

                        <div class="bg-white rounded-xl p-4 border border-green-100">
                            <p class="text-gray-500">Metode Pembayaran</p>
                            <p class="font-semibold text-gray-800 mt-1">
                                {{ $booking->metode_pembayaran ?: '-' }}
                            </p>
                        </div>
                    </div>

                    @if($booking->catatan_pembayaran)
                        <div class="mt-4 bg-white rounded-xl p-4 border border-green-100">
                            <p class="text-sm text-gray-500 mb-1">Catatan</p>
                            <p class="text-sm text-gray-700">{{ $booking->catatan_pembayaran }}</p>
                        </div>
                    @endif

                    <div class="mt-4 flex items-center justify-between gap-3">
                        @if($booking->kode_booking)
    <div class="mt-4 bg-white rounded-xl p-4 border border-green-100 text-center">
        <p class="text-gray-500 mb-3">QR Booking</p>

       <img
    src="https://quickchart.io/qr?size=180&text={{ urlencode(route('admin.booking.validasi.form', $current_team) . '?kode=' . $booking->kode_booking) }}"
    alt="QR Booking {{ $booking->kode_booking }}"
    class="mx-auto"
>

        <p class="text-xs text-gray-500 mt-3 break-all">
            Scan QR ini untuk validasi booking
        </p>
    </div>
@endif
                        <div>
                            @if($booking->bukti_pembayaran)
<<<<<<< HEAD
                                <a href="{{ asset('storage/' . $booking->bukti_pembayaran) }}"
=======
                                <a href="{{ asset('uploads/' . $booking->bukti_pembayaran) }}"
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
                                   target="_blank"
                                   class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold text-sm">
                                    Lihat Bukti Pembayaran
                                </a>
                            @else
                                <span class="text-sm text-gray-400">Bukti pembayaran belum diupload</span>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $bookings->links() }}
        </div>
    @else
        <div class="rounded-2xl border border-dashed border-green-200 p-10 text-center">
            <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Booking</h3>
            <p class="text-gray-500 mb-5">Kamu belum punya data booking. Yuk booking lapangan sekarang.</p>

            <a href="{{ route('user.lapangan.index', $current_team) }}"
               class="inline-flex items-center justify-center bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 transition">
                Booking Sekarang
            </a>
        </div>
    @endif
</div>
@endsection