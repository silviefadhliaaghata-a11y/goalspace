@extends('layouts.admin')

@section('title','Data Booking')
@section('page_heading','Log Transaksi & Booking')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-orange-500/10 text-orange-500 rounded-2xl flex items-center justify-center text-xl">📅</div>
        <div>
            <h2 class="text-xl font-black text-white tracking-tight uppercase tracking-widest">Log Reservasi</h2>
            <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1">Total: {{ $bookings->total() }} Transaksi</p>
        </div>
    </div>

    <div class="flex flex-col md:flex-row gap-4 items-center">
        <form method="GET" class="relative group">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari pemesan atau tanggal..."
                   class="bg-white/5 border border-white/10 text-white text-xs px-12 py-4 rounded-2xl w-full md:w-80 focus:outline-none focus:border-emerald-500 transition-all placeholder:text-slate-600 font-bold uppercase tracking-widest"
                   oninput="debounceSearch(this)">
            <span class="absolute left-5 top-1/2 -translate-y-1/2 opacity-30 group-focus-within:opacity-100 transition-opacity">🔍</span>
        </form>

        <a href="{{ route('booking.create', $current_team) }}"
           class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 px-8 py-4 rounded-2xl font-black transition shadow-lg shadow-emerald-500/20 uppercase tracking-widest text-xs">
            + Booking Baru
        </a>
    </div>
</div>

<div class="glass-card rounded-[2.5rem] overflow-hidden border-white/5 shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-white/5 text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] border-b border-white/5">
                    <th class="px-8 py-6 text-left">Pelanggan</th>
                    <th class="px-8 py-6 text-left">Arena & Jadwal</th>
                    <th class="px-8 py-6 text-left">Pembayaran</th>
                    <th class="px-8 py-6 text-center">Bukti</th>
                    <th class="px-8 py-6 text-center">Status</th>
                    <th class="px-8 py-6 text-right">Manajemen</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/5">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-white/5 transition duration-300 group">
                        <td class="px-8 py-6">
                            <p class="font-black text-white tracking-tight uppercase tracking-widest text-sm">{{ $booking->nama_pemesan }}</p>
                            <p class="text-[10px] text-slate-500 font-bold uppercase mt-1">Ref: #BK-{{ $booking->id }}</p>
                        </td>

                        <td class="px-8 py-6">
                            <div class="flex items-start gap-3">
                                <div class="w-2 h-10 bg-emerald-500/20 rounded-full"></div>
                                <div>
                                    <p class="text-xs font-black text-slate-300 uppercase tracking-wider">{{ $booking->lapangan->nama ?? 'N/A' }}</p>
                                    <p class="text-[10px] text-emerald-500 font-black mt-1 uppercase">
                                        {{ \Carbon\Carbon::parse($booking->tanggal)->format('d M Y') }} 
                                        <span class="mx-1 opacity-30 text-white">|</span>
                                        {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                                    </p>
                                </div>
                            </div>
                        </td>

                        <td class="px-8 py-6">
                            <p class="font-black text-white italic">Rp{{ number_format($booking->total_harga, 0, ',', '.') }}</p>
                            <p class="text-[9px] text-slate-500 font-bold uppercase mt-0.5">Lunas/Transfer</p>
                        </td>

                        <td class="px-8 py-6 text-center">
                            @if($booking->bukti_pembayaran)
                                <img src="{{ asset('uploads/' . $booking->bukti_pembayaran) }}"
                                     class="w-12 h-12 object-cover rounded-xl cursor-pointer border border-white/10 hover:scale-110 transition duration-300 mx-auto"
                                     onclick="openImage(this.src)">
                            @else
                                <span class="text-[10px] font-black text-slate-700 uppercase tracking-widest italic">No Data</span>
                            @endif
                        </td>

                        <td class="px-8 py-6 text-center">
                            @php $status = strtolower($booking->status); @endphp
                            @if($status == 'pending')
                                <span class="px-4 py-2 text-[9px] rounded-xl bg-orange-500/10 text-orange-400 font-black uppercase tracking-[0.2em] border border-orange-500/20">Pending</span>
                            @elseif($status == 'lunas')
                                <span class="px-4 py-2 text-[9px] rounded-xl bg-emerald-500/10 text-emerald-400 font-black uppercase tracking-[0.2em] border border-emerald-500/20 text-center">Lunas</span>
                            @elseif($status == 'selesai')
                                <span class="px-4 py-2 text-[9px] rounded-xl bg-blue-500/10 text-blue-400 font-black uppercase tracking-[0.2em] border border-blue-500/20 text-center text-center">Selesai</span>
                            @else
                                <span class="px-4 py-2 text-[9px] rounded-xl bg-red-500/10 text-red-400 font-black uppercase tracking-[0.2em] border border-red-500/20 text-center text-center">Batal</span>
                            @endif
                        </td>

                        <td class="px-8 py-6 text-right">
                            <div class="flex flex-col items-end gap-3">
                                <form action="{{ route('admin.booking.updateStatus', [$current_team, $booking->id]) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="bg-white/5 border border-white/10 text-[10px] font-black text-slate-300 uppercase rounded-lg px-3 py-2 focus:outline-none focus:border-emerald-500 tracking-wider">
                                        <option value="pending" class="bg-slate-900" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="lunas" class="bg-slate-900" {{ $status == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                        <option value="selesai" class="bg-slate-900" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                        <option value="batal" class="bg-slate-900" {{ $status == 'batal' ? 'selected' : '' }}>Batal</option>
                                    </select>
                                    <button class="bg-emerald-500/20 text-emerald-400 p-2 rounded-lg hover:bg-emerald-500 hover:text-slate-950 transition">✔️</button>
                                </form>

                                <div class="flex gap-2">
                                    <a href="{{ route('admin.booking.edit', [$current_team, $booking->id]) }}" class="text-slate-500 hover:text-white text-[10px] font-black uppercase tracking-widest transition">Edit Data</a>
                                    <span class="text-slate-800">|</span>
                                    <form action="{{ route('admin.booking.destroy', [$current_team, $booking->id]) }}" method="POST" onsubmit="return confirm('Hapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500/50 hover:text-red-500 text-[10px] font-black uppercase tracking-widest transition">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="text-4xl mb-4 opacity-20">📅</div>
                            <p class="text-sm font-black text-slate-500 uppercase tracking-[0.2em]">Belum ada log reservasi yang masuk.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $bookings->links() }}
</div>

@endsection

@push('scripts')
<script>
let bookingSearchTimeout = null;
function debounceSearch(input) {
    clearTimeout(bookingSearchTimeout);
    bookingSearchTimeout = setTimeout(() => { input.form.submit(); }, 500);
}
function openImage(src) {
    let w = window.open("");
    w.document.write("<img src='" + src + "' style='max-width:100%; border-radius: 20px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);'>");
    w.document.body.style.background = "#0f172a";
    w.document.body.style.display = "flex";
    w.document.body.style.justifyContent = "center";
    w.document.body.style.alignItems = "center";
    w.document.body.style.minHeight = "100vh";
}
</script>
@endpush
