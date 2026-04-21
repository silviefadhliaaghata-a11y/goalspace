@extends('layouts.admin')

@section('title','Laporan Keuangan')
@section('page_heading','Financial Reports')

@section('content')

<div class="glass-card rounded-[2.5rem] p-8 mb-8">
    <form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="space-y-1">
            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2">Dari Tanggal</label>
            <input type="date" name="dari" value="{{ request('dari') }}" 
                   class="w-full bg-white/5 border border-white/10 text-white text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-emerald-500 transition">
        </div>

        <div class="space-y-1">
            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2">Sampai Tanggal</label>
            <input type="date" name="sampai" value="{{ request('sampai') }}" 
                   class="w-full bg-white/5 border border-white/10 text-white text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-emerald-500 transition">
        </div>

        <div class="space-y-1">
            <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest ml-2">Status Pembayaran</label>
            <select name="status" class="w-full bg-white/5 border border-white/10 text-white text-xs px-4 py-3 rounded-xl focus:outline-none focus:border-emerald-500 transition appearance-none">
                <option value="" class="bg-slate-900">Semua Status</option>
                <option value="lunas" class="bg-slate-900" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="pending" class="bg-slate-900" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            </select>
        </div>

        <div class="flex items-end">
            <button class="w-full bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black py-3 rounded-xl transition uppercase tracking-widest text-[10px]">
                Terapkan Filter
            </button>
        </div>

        <div class="flex items-end">
            <a href="{{ route('laporan.pdf', ['current_team' => $current_team, 'dari' => request('dari'), 'sampai' => request('sampai'), 'status' => request('status')]) }}"
               target="_blank" class="w-full bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white border border-red-500/20 font-black py-3 rounded-xl transition text-center uppercase tracking-widest text-[10px]">
                Cetak Laporan (PDF)
            </a>
        </div>
    </form>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="glass-card rounded-[2.5rem] p-8 border-emerald-500/20 relative overflow-hidden group">
        <div class="absolute right-0 top-0 p-8 text-4xl opacity-5 group-hover:opacity-20 transition-opacity">💰</div>
        <p class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.3em] mb-2">Total Omzet</p>
        <h3 class="text-3xl font-black text-white italic tracking-tight">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
        <p class="text-[9px] text-slate-500 mt-2 font-bold uppercase tracking-widest">Berdasarkan filter yang dipilih</p>
    </div>
</div>

<div class="glass-card rounded-[2.5rem] overflow-hidden">
    <table class="w-full">
        <thead>
            <tr class="bg-white/5 text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] border-b border-white/5">
                <th class="px-8 py-6 text-left">Detail Transaksi</th>
                <th class="px-8 py-6 text-left">Waktu Main</th>
                <th class="px-8 py-6 text-left">Nilai Transaksi</th>
                <th class="px-8 py-6 text-right">Status Akhir</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-white/5">
            @forelse($bookings as $booking)
                <tr class="hover:bg-white/5 transition duration-300">
                    <td class="px-8 py-6">
                        <p class="font-black text-white uppercase tracking-widest text-xs">{{ $booking->lapangan->nama ?? 'N/A' }}</p>
                        <p class="text-[9px] text-slate-500 font-bold uppercase mt-1">Ref: #TRX-{{ $booking->id }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="text-xs font-bold text-slate-300 italic">{{ \Carbon\Carbon::parse($booking->tanggal)->format('d F Y') }}</p>
                    </td>
                    <td class="px-8 py-6">
                        <p class="font-black text-emerald-400 italic">Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                    </td>
                    <td class="px-8 py-6 text-right">
                        @php $status = strtolower($booking->status); @endphp
                        @if($status == 'lunas')
                            <span class="text-[9px] font-black text-emerald-500 uppercase tracking-widest bg-emerald-500/10 px-3 py-1 rounded-lg border border-emerald-500/20">Lunas</span>
                        @else
                            <span class="text-[9px] font-black text-orange-500 uppercase tracking-widest bg-orange-500/10 px-3 py-1 rounded-lg border border-orange-500/20">{{ $status }}</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="px-8 py-20 text-center">
                        <p class="text-sm font-black text-slate-500 uppercase tracking-[0.2em] italic">Data tidak ditemukan dalam periode ini.</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-8">
    {{ $bookings->links() }}
</div>

@endsection