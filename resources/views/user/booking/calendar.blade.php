@extends('layouts.user')

@section('content')

<div class="space-y-8 text-slate-800">

    <!-- HEADER -->
    <section class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
        <form method="GET" class="flex flex-col md:flex-row items-center gap-6">

            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-blue-600 mb-2">
                    Pilih Tanggal Booking
                </p>

                <input type="date"
                       name="tanggal"
                       value="{{ $tanggal }}"
                       class="border border-slate-300 rounded-2xl px-5 py-3 font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>

            <button class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-2xl font-bold uppercase tracking-wide transition-all">
                Lihat Jadwal
            </button>

            <div class="md:ml-auto text-sm text-slate-500 font-semibold">
                Jadwal {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}
            </div>

        </form>
    </section>

    <!-- LIVE SCHEDULER -->
    <section class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">

        <div class="px-8 py-6 border-b border-slate-200">
            <h2 class="text-3xl font-black text-slate-900">
                Live Booking Scheduler
            </h2>
            <p class="text-slate-500 mt-2">
                Pilih slot kosong untuk booking lapangan.
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full min-w-[1400px]">

                <!-- HEAD -->
                <thead class="bg-slate-50">
                    <tr>
                        <th class="sticky left-0 z-10 bg-slate-50 px-8 py-5 text-left text-sm font-black uppercase tracking-widest text-slate-600 border-r border-slate-200">
                            Lapangan
                        </th>

                        @for($i=8;$i<=22;$i++)
                            <th class="px-4 py-5 text-center text-xs font-black uppercase text-slate-500 border-l border-slate-200">
                                {{ sprintf('%02d:00', $i) }}
                            </th>
                        @endfor
                    </tr>
                </thead>

                <!-- BODY -->
                <tbody class="divide-y divide-slate-100">

                    @foreach($lapangans as $lapangan)
                        <tr class="hover:bg-slate-50 transition-all">

                            <!-- NAMA -->
                            <td class="sticky left-0 z-10 bg-white px-8 py-6 border-r border-slate-200">
                                <p class="font-black text-slate-900 text-sm uppercase tracking-wide">
                                    {{ $lapangan->nama }}
                                </p>

                                <p class="text-blue-600 font-bold text-xs mt-2">
                                    Rp{{ number_format($lapangan->harga,0,',','.') }}/Jam
                                </p>
                            </td>

                            <!-- SLOT -->
                            @for($i=8;$i<=22;$i++)
                                @php
                                    $booked = false;

                                    if(isset($bookings[$lapangan->id])) {
                                        foreach($bookings[$lapangan->id] as $b) {
                                            if(
                                                $i >= (int)substr($b->jam_mulai,0,2) &&
                                                $i < (int)substr($b->jam_selesai,0,2)
                                            ) {
                                                $booked = true;
                                            }
                                        }
                                    }
                                @endphp

                                <td class="px-2 py-4 border-l border-slate-100">

                                    @if($booked)

                                        <!-- BOOKED -->
                                        <div class="bg-red-100 text-red-600 border border-red-200 px-3 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest text-center">
                                            Terisi
                                        </div>

                                    @else

                                        <!-- AVAILABLE -->
                                        <a href="{{ route('booking.create', [
    $current_team,
    'lapangan_id' => $lapangan->id,
    'tanggal' => $tanggal
]) }}"
                                           class="block bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white border border-blue-200 px-3 py-3 rounded-xl text-[10px] font-bold uppercase tracking-widest text-center transition-all duration-300">
                                            Tersedia
                                        </a>

                                    @endif

                                </td>
                            @endfor

                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    </section>

    <!-- LEGEND -->
    <section class="flex flex-wrap gap-6">

        <div class="flex items-center gap-3">
            <span class="w-4 h-4 rounded bg-blue-600"></span>
            <span class="text-sm font-bold text-slate-600">
                Tersedia
            </span>
        </div>

        <div class="flex items-center gap-3">
            <span class="w-4 h-4 rounded bg-red-500"></span>
            <span class="text-sm font-bold text-slate-600">
                Terisi
            </span>
        </div>

    </section>

</div>

@endsection