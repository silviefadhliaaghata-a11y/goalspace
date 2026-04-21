@extends('layouts.admin')

@section('title','Kalender Jadwal')
@section('page_heading','Live Scheduler')

@section('content')

<div class="glass-card rounded-[2.5rem] p-8 mb-8">
    <form method="GET" class="flex flex-col md:flex-row items-center gap-6">
        <div class="flex items-center gap-4">
            <div class="w-10 h-10 bg-emerald-500/10 text-emerald-500 rounded-xl flex items-center justify-center">📅</div>
            <div>
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Pilih Tanggal Kontrol</p>
                <input type="date" name="tanggal" value="{{ $tanggal }}"
                       class="bg-transparent border-none text-white font-black uppercase tracking-widest focus:ring-0 p-0 text-lg cursor-pointer">
            </div>
        </div>

        <button class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black px-8 py-3 rounded-xl transition uppercase tracking-widest text-[10px]">
            Refresh Jadwal
        </button>
        
        <div class="flex-1 text-right hidden md:block">
            <span class="text-[10px] font-black text-slate-500 uppercase tracking-[0.2em] italic italic">Showing availability for {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</span>
        </div>
    </form>
</div>

<div class="glass-card rounded-[2.5rem] overflow-hidden shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-white/5 text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] border-b border-white/5">
                    <th class="px-8 py-6 text-left sticky left-0 bg-slate-900/50 backdrop-blur-md z-10">Arena</th>
                    @for($i=8;$i<=22;$i++)
                        <th class="px-4 py-6 text-center border-l border-white/5">{{ sprintf('%02d:00',$i) }}</th>
                    @endfor
                </tr>
            </thead>

            <tbody class="divide-y divide-white/5">
                @foreach($lapangans as $lapangan)
                    <tr class="hover:bg-white/5 transition duration-300">
                        <td class="px-8 py-6 sticky left-0 bg-slate-900/50 backdrop-blur-md z-10 border-r border-white/5">
                            <p class="font-black text-white uppercase tracking-widest text-xs">{{ $lapangan->nama }}</p>
                        </td>

                        @for($i=8;$i<=22;$i++)
                            @php
                                $booked=false;
                                if(isset($bookings[$lapangan->id])){
                                    foreach($bookings[$lapangan->id] as $b){
                                        if($i >= (int)substr($b->jam_mulai,0,2) && $i < (int)substr($b->jam_selesai,0,2)){
                                            $booked=true;
                                        }
                                    }
                                }
                            @endphp

                            <td class="px-2 py-4 border-l border-white/5">
                                @if($booked)
                                    <div class="bg-red-500/20 text-red-500 border border-red-500/30 px-3 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest text-center shadow-lg shadow-red-500/10 italic">
                                        Occupied
                                    </div>
                                @else
                                    <a href="{{ route('booking.create', [
                                        $current_team,
                                        'lapangan_id'=>$lapangan->id,
                                        'tanggal'=>$tanggal,
                                        'jam_mulai'=>sprintf('%02d:00',$i),
                                        'jam_selesai'=>sprintf('%02d:00',$i+1)
                                    ]) }}"
                                    class="block bg-emerald-500/5 hover:bg-emerald-500 text-emerald-500 hover:text-slate-950 border border-emerald-500/10 px-3 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest text-center transition-all duration-300 italic group">
                                        Open
                                    </a>
                                @endif
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="mt-10 flex gap-4">
    <div class="flex items-center gap-2">
        <span class="w-3 h-3 rounded bg-emerald-500"></span>
        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Tersedia</span>
    </div>
    <div class="flex items-center gap-2">
        <span class="w-3 h-3 rounded bg-red-500/30"></span>
        <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Terpakai</span>
    </div>
</div>

@endsection