@extends('layouts.admin')

@section('title', 'Validasi Booking')
@section('page_heading', 'Validasi Booking')

@section('content')
<div class="max-w-3xl mx-auto">

    @if(session('error'))
        <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3">
            {{ session('error') }}
        </div>
    @endif

    @if(session('success'))
        <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-800 mb-2">Cari Booking</h2>
        <p class="text-sm text-gray-500 mb-4">Masukkan kode booking untuk validasi masuk lapangan.</p>

        <form method="POST" action="{{ route('admin.booking.validasi.proses', $current_team) }}">
            @csrf

            <div class="flex flex-col sm:flex-row gap-3">
                <input type="text"
                       name="kode_booking"
                       value="{{ old('kode_booking', $booking->kode_booking ?? request('kode')) }}"
                       placeholder="Contoh: BOOK-20260418-ABCD"
                       class="w-full rounded-xl border border-gray-300 px-4 py-3"
                       required>

                <button type="submit"
                        class="bg-blue-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-blue-700 transition">
                    Cari
                </button>
            </div>

            @error('kode_booking')
                <p class="mt-2 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </form>
    </div>

    @isset($booking)
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-bold text-gray-800 mb-4">Detail Booking</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="rounded-xl border p-4">
                    <p class="text-sm text-gray-500">Kode Booking</p>
                    <p class="font-bold text-gray-800 mt-1">{{ $booking->kode_booking }}</p>
                </div>

                <div class="rounded-xl border p-4">
                    <p class="text-sm text-gray-500">Nama Pemesan</p>
                    <p class="font-bold text-gray-800 mt-1">{{ $booking->nama_pemesan }}</p>
                </div>

                <div class="rounded-xl border p-4">
                    <p class="text-sm text-gray-500">Lapangan</p>
                    <p class="font-bold text-gray-800 mt-1">{{ $booking->lapangan->nama ?? '-' }}</p>
                </div>

                <div class="rounded-xl border p-4">
                    <p class="text-sm text-gray-500">Tanggal</p>
                    <p class="font-bold text-gray-800 mt-1">{{ $booking->tanggal }}</p>
                </div>

                <div class="rounded-xl border p-4">
                    <p class="text-sm text-gray-500">Jam Main</p>
                    <p class="font-bold text-gray-800 mt-1">
                        {{ $booking->jam_mulai }} - {{ $booking->jam_selesai }}
                    </p>
                </div>

                <div class="rounded-xl border p-4">
                    <p class="text-sm text-gray-500">Status</p>
                    <div class="mt-1">
                        @php $status = strtolower($booking->status); @endphp

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
                </div>
            </div>

            @if(!$booking->checked_in_at)
                <form method="POST"
                      action="{{ route('admin.booking.checkin', [$current_team, $booking->id]) }}"
                      class="mt-6">
                    @csrf

                    <button type="submit"
                            class="bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 transition">
                        Validasi Masuk
                    </button>
                </form>
            @else
                <div class="mt-6 rounded-xl bg-green-100 text-green-700 px-4 py-3">
                    Booking ini sudah check-in pada {{ $booking->checked_in_at }}
                </div>
            @endif
        </div>
    @endisset
</div>
@endsection