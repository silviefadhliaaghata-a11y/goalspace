@extends('layouts.user')

@section('content')
<section class="mb-8">
    <div class="bg-gradient-to-r from-green-600 to-green-500 rounded-3xl p-8 text-white shadow-lg">
        <div class="max-w-3xl">
            <p class="text-sm uppercase tracking-widest text-green-100 mb-3">Booking Lapangan Futsal</p>
            <h1 class="text-3xl md:text-4xl font-extrabold leading-tight">
                Pilih Lapangan Terbaik dan Booking Dengan Mudah
            </h1>
            <p class="mt-4 text-green-50 text-sm md:text-base leading-relaxed">
                Lihat lapangan yang tersedia, cek harga per jam, lalu lanjut booking langsung dari halaman ini.
            </p>
        </div>
    </div>
</section>

<section class="mb-6">
    <div class="flex items-center justify-between">
        <div class="mb-6">
    <form method="GET" action="{{ route('user.lapangan.index', $current_team) }}">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama / jenis lapangan..."
                   class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring focus:ring-green-200">

            <select name="status"
                    class="w-full rounded-2xl border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring focus:ring-green-200">
                <option value="">-- Semua Status --</option>
                <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>
                    Tersedia
                </option>
                <option value="perbaikan" {{ request('status') == 'perbaikan' ? 'selected' : '' }}>
                    Perbaikan
                </option>
                <option value="tidak tersedia" {{ request('status') == 'tidak tersedia' ? 'selected' : '' }}>
                    Tidak Tersedia
                </option>
            </select>

            <div class="flex gap-3">
                <button type="submit"
                        class="w-full bg-green-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-green-700 transition">
                    Cari
                </button>

                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="w-full bg-gray-100 text-gray-700 px-6 py-3 rounded-2xl font-semibold hover:bg-gray-200 transition text-center">
                    Reset
                </a>
            </div>
        </div>
    </form>
</div>
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Daftar Lapangan</h2>
            <p class="text-sm text-gray-500">Lapangan tersedia untuk kamu booking</p>
        </div>
    </div>
</section>

@if($lapangans->count() > 0)
    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach($lapangans as $lapangan)
            <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-green-100 hover:shadow-xl transition">
                <div class="h-52 bg-green-100 overflow-hidden">
                    @if($lapangan->gambar)
                        <img src="{{ asset('storage/' . $lapangan->gambar) }}"
                             alt="{{ $lapangan->nama }}"
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-green-700 font-medium">
                            No Image
                        </div>
                    @endif
                </div>

                <div class="p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">{{ $lapangan->nama }}</h3>
                            <p class="text-sm text-gray-500 mt-1">{{ $lapangan->jenis ?: 'Lapangan Futsal' }}</p>
                        </div>

                        @php
                            $status = strtolower(trim($lapangan->status));
                        @endphp

                        @if($status == 'tersedia')
                            <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                Tersedia
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                                Tidak Tersedia
                            </span>
                        @endif
                    </div>

                    <p class="mt-4 text-sm text-gray-600 leading-relaxed min-h-[48px]">
                        {{ $lapangan->deskripsi ?: 'Lapangan siap dipakai untuk booking dengan sistem yang praktis dan cepat.' }}
                    </p>

                    <div class="mt-5 flex items-center justify-between">
                        <div>
                            <p class="text-xs text-gray-500">Harga per jam</p>
                            <p class="text-2xl font-extrabold text-green-600">
                                Rp {{ number_format($lapangan->harga, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-3">
    <a href="{{ route('user.lapangan.show', [$current_team, $lapangan->id]) }}"
       class="block text-center bg-white border border-green-200 text-green-700 py-3 rounded-2xl hover:bg-green-50 transition font-semibold">
        Lihat Detail
    </a>

    <a href="{{ route('booking.create', [$current_team, 'lapangan_id' => $lapangan->id]) }}"
       class="block text-center bg-green-600 text-white py-3 rounded-2xl hover:bg-green-700 transition font-semibold">
        Booking Sekarang
    </a>
</div>
                </div>
            </div>
        @endforeach
    </section>

    <div class="mt-8">
        {{ $lapangans->links() }}
    </div>
@else
   <div class="bg-white rounded-3xl p-10 text-center shadow-sm border border-green-100">
    <h3 class="text-xl font-bold text-gray-800 mb-2">Lapangan Tidak Ditemukan</h3>
    <p class="text-gray-500 mb-5">
        Coba ubah kata kunci pencarian atau filter status yang kamu pilih.
    </p>

    <a href="{{ route('user.lapangan.index', $current_team) }}"
       class="inline-flex items-center justify-center bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 transition">
        Reset Filter
    </a>
</div>
@endif
@endsection