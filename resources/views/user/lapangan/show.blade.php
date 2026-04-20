@extends('layouts.user')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="mb-8">
        <div class="bg-gradient-to-r from-green-600 to-green-500 rounded-3xl p-8 text-white shadow-lg">
            <p class="text-sm uppercase tracking-widest text-green-100 mb-3">Detail Lapangan</p>
            <h1 class="text-3xl md:text-4xl font-extrabold leading-tight">
                {{ $lapangan->nama }}
            </h1>
            <p class="mt-3 text-green-100 text-sm md:text-base">
                Lihat informasi lengkap lapangan sebelum melakukan booking.
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="bg-white rounded-3xl shadow-sm border border-green-100 overflow-hidden">
            <div class="h-[320px] bg-green-50">
                @if($lapangan->gambar)
                    <img src="{{ asset('storage/' . $lapangan->gambar) }}"
                         alt="{{ $lapangan->nama }}"
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center text-green-700 font-semibold">
                        No Image
                    </div>
                @endif
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-green-100 p-6 md:p-8">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $lapangan->nama }}</h2>
                    <p class="text-sm text-gray-500 mt-1">{{ $lapangan->jenis ?: 'Lapangan Futsal' }}</p>
                </div>

                @php
                    $status = strtolower(trim($lapangan->status));
                @endphp

                @if($status === 'tersedia')
                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                        Tersedia
                    </span>
                @elseif($status === 'perbaikan')
                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-semibold">
                        Perbaikan
                    </span>
                @else
                    <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                        Tidak Tersedia
                    </span>
                @endif
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                <div class="rounded-2xl bg-green-50 border border-green-100 p-4">
                    <p class="text-sm text-gray-500">Jenis Lapangan</p>
                    <p class="mt-1 font-semibold text-gray-800">{{ $lapangan->jenis ?: '-' }}</p>
                </div>

                <div class="rounded-2xl bg-green-50 border border-green-100 p-4">
                    <p class="text-sm text-gray-500">Harga per Jam</p>
                    <p class="mt-1 font-bold text-green-600 text-lg">
                        Rp {{ number_format($lapangan->harga, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-lg font-bold text-gray-800 mb-3">Deskripsi</h3>
                <div class="rounded-2xl border border-green-100 bg-white p-4">
                    <p class="text-gray-600 leading-relaxed">
                        {{ $lapangan->deskripsi ?: 'Belum ada deskripsi untuk lapangan ini.' }}
                    </p>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3">
                <a href="{{ route('booking.create', [$current_team, 'lapangan_id' => $lapangan->id]) }}"
                   class="inline-flex items-center justify-center bg-green-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-green-700 transition">
                    Booking Sekarang
                </a>

                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="inline-flex items-center justify-center bg-gray-100 text-gray-700 px-6 py-3 rounded-2xl font-semibold hover:bg-gray-200 transition">
                    Kembali ke Daftar Lapangan
                </a>
            </div>
        </div>
    </div>
</div>
@endsection