@extends('layouts.user')

@section('content')
<div class="space-y-10 text-slate-800">

    <!-- HERO -->
    <section class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 md:p-12 relative overflow-hidden">

    <!-- BACKGROUND IMAGE -->
    <div class="absolute inset-0">
        <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=1600&q=80"
             alt="Futsal Arena"
             class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-white/80"></div>
    </div>

    <!-- CONTENT -->
    <div class="relative z-10 max-w-4xl">
        <p class="text-sm font-bold uppercase tracking-[0.3em] text-white-600 mb-4">
            Premium Arena Booking
        </p>

        <h1 class="text-4xl md:text-6xl font-black leading-tight text-slate-900">
            Pilih Arena Terbaik,<br>
            <span class="text-white-600">Main Lebih Maksimal.</span>
        </h1>

        <p class="mt-6 text-slate-700 text-lg leading-relaxed max-w-2xl">
            Temukan lapangan futsal berkualitas, jadwal fleksibel, dan proses booking cepat dalam satu platform modern.
        </p>
    </div>

</section>

    <!-- FILTER -->
    <section class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
        <form method="GET" action="{{ route('user.lapangan.index', $current_team) }}">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-5">

                <!-- SEARCH -->
                <div class="md:col-span-2">
                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama arena atau jenis lapangan..."
                           class="w-full border border-slate-300 rounded-2xl px-6 py-4 text-slate-800 font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                </div>

                <!-- STATUS -->
                <div>
                    <select name="status"
                            class="w-full border border-slate-300 rounded-2xl px-6 py-4 text-slate-700 font-medium focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">

                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>
                            Tersedia
                        </option>
                        <option value="perbaikan" {{ request('status') == 'perbaikan' ? 'selected' : '' }}>
                            Maintenance
                        </option>
                    </select>
                </div>

                <!-- BUTTON -->
                <button type="submit"
        class="bg-blue-600 hover:bg-blue-700 text-white rounded-2xl px-8 py-4 font-bold uppercase tracking-wide transition-all">
    Filter
</button>

            </div>
        </form>
    </section>

    <!-- GRID -->
    @if($lapangans->count() > 0)
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($lapangans as $lapangan)
                @php $status = strtolower(trim($lapangan->status)); @endphp

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col">

                    <!-- IMAGE -->
                    <div class="h-64 relative overflow-hidden">
                        @if($lapangan->gambar)
                            <img src="{{ asset('uploads/' . $lapangan->gambar) }}"
                                 alt="{{ $lapangan->nama }}"
                                 class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-slate-100 flex items-center justify-center text-slate-400 font-bold">
                                No Image
                            </div>
                        @endif

                        <!-- STATUS BADGE -->
                        <div class="absolute top-5 right-5">
                            @if($status == 'tersedia')
                                <span class="px-4 py-2 rounded-xl bg-emerald-100 text-emerald-700 text-xs font-bold uppercase">
                                    Tersedia
                                </span>
                            @else
                                <span class="px-4 py-2 rounded-xl bg-red-100 text-red-700 text-xs font-bold uppercase">
                                    Maintenance
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- CONTENT -->
                    <div class="p-7 flex flex-col flex-1">

                        <div class="flex justify-between items-start gap-4 mb-4">

                            <div>
                                <h3 class="text-2xl font-black text-slate-900 leading-tight">
                                    {{ $lapangan->nama }}
                                </h3>

                                <p class="text-sm font-bold text-blue-600 mt-2 uppercase tracking-wide">
                                    {{ $lapangan->jenis ?: 'Premium Arena' }}
                                </p>
                            </div>

                            <div class="text-right">
                                <p class="text-xs uppercase font-bold text-slate-400">
                                    Harga / Jam
                                </p>

                                <p class="text-xl font-black text-slate-900 mt-1">
                                    Rp{{ number_format($lapangan->harga, 0, ',', '.') }}
                                </p>
                            </div>

                        </div>

                        <!-- DESCRIPTION -->
                        <p class="text-slate-600 leading-relaxed text-sm mb-8 flex-1">
                            {{ $lapangan->deskripsi ?: 'Arena futsal berkualitas tinggi dengan fasilitas premium untuk pengalaman bermain terbaik.' }}
                        </p>

                        <!-- ACTION -->
                        <div class="grid grid-cols-2 gap-3 mt-auto">

                            <a href="{{ route('user.lapangan.show', [$current_team, $lapangan->id]) }}"
                               class="text-center border border-slate-300 hover:border-blue-500 hover:text-blue-600 py-4 rounded-2xl font-bold uppercase tracking-wide text-sm transition-all">
                                Detail
                            </a>

                            @if($status == 'tersedia')
                                <a href="{{ route('booking.create', [$current_team, 'lapangan_id' => $lapangan->id]) }}"
                                   class="text-center bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-2xl font-bold uppercase tracking-wide text-sm transition-all">
                                    Booking
                                </a>
                            @else
                                <button disabled
                                        class="text-center bg-slate-100 text-slate-400 py-4 rounded-2xl font-bold uppercase tracking-wide text-sm cursor-not-allowed">
                                    Offline
                                </button>
                            @endif

                        </div>

                    </div>
                </div>
            @endforeach

        </section>

        <!-- PAGINATION -->
        <div class="pt-6">
            {{ $lapangans->links() }}
        </div>

    @else

        <!-- EMPTY -->
        <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-20 text-center">
            <div class="text-6xl mb-6">🏟️</div>

            <h3 class="text-3xl font-black text-slate-900">
                Arena Tidak Ditemukan
            </h3>

            <p class="text-slate-500 mt-3 text-lg">
                Coba ubah filter atau kata kunci pencarian Anda.
            </p>

            <a href="{{ route('user.lapangan.index', $current_team) }}"
               class="inline-block mt-8 bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-2xl font-bold uppercase tracking-wide transition-all">
                Reset Filter
            </a>
        </div>

    @endif

</div>
@endsection