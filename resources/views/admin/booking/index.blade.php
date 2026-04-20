@extends('layouts.admin')

@section('title','Data Booking')
@section('page_heading','Data Booking')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
    <a href="{{ route('booking.create', $current_team) }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition w-fit">
        + Booking
    </a>

    <form method="GET" class="flex gap-2 w-full md:w-auto">
    <input type="text"
           name="search"
           value="{{ request('search') }}"
           placeholder="Cari pemesan, tanggal, lapangan..."
           class="border px-3 py-2 rounded-lg w-full md:w-80"
           oninput="debounceSearch(this)">

    <button type="submit"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg">
        Cari
    </button>
</form>
</div>

@if(session('success'))
    <div class="mb-4 bg-green-100 text-green-700 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 bg-red-100 text-red-700 px-4 py-3 rounded-lg">
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif



<div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-700">
                <tr>
                    <th class="p-4 text-left font-semibold">Lapangan</th>
                    <th class="p-4 text-left font-semibold">Pemesan</th>
                    <th class="p-4 text-left font-semibold">Tanggal</th>
                    <th class="p-4 text-left font-semibold">Jam</th>
                    <th class="p-4 text-left font-semibold">Total</th>
                    <th class="p-4 text-left font-semibold">Bukti</th>
                    <th class="p-4 text-left font-semibold">Status</th>
                    <th class="p-4 text-left font-semibold">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-100">
                @forelse($bookings as $booking)
                    <tr class="hover:bg-gray-50 transition align-top">
                        <td class="p-4">
                            {{ $booking->lapangan->nama ?? '-' }}
                        </td>

                        <td class="p-4">
                            {{ $booking->nama_pemesan }}
                        </td>

                        <td class="p-4 whitespace-nowrap">
                            {{ \Carbon\Carbon::parse($booking->tanggal)->format('d-m-Y') }}
                        </td>

                        <td class="p-4">
                            <div class="inline-block bg-gray-100 px-3 py-1 rounded-lg text-gray-800">
                                {{ \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i') }}
                                -
                                {{ \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i') }}
                            </div>
                            <div class="text-xs text-gray-400 mt-1">
                                {{ \Carbon\Carbon::parse($booking->jam_mulai)->diffInMinutes(\Carbon\Carbon::parse($booking->jam_selesai)) / 60 }} jam
                            </div>
                        </td>

                        <td class="p-4 text-green-600 font-bold whitespace-nowrap">
                            Rp{{ number_format($booking->total_harga, 0, ',', '.') }}
                        </td>

                        <td class="p-4">
                            @if($booking->bukti_pembayaran)
                                <img src="{{ asset('storage/' . $booking->bukti_pembayaran) }}"
                                     class="w-14 h-14 object-cover rounded-lg cursor-pointer border"
                                     onclick="openImage(this.src)">
                            @else
                                <span class="text-gray-400">-</span>
                            @endif
                        </td>

                        <td class="p-4">
                            @php $status = strtolower($booking->status); @endphp

                            @if($status == 'pending')
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-medium">
                                    Pending
                                </span>
                            @elseif($status == 'lunas')
                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                    Lunas
                                </span>
                            @elseif($status == 'selesai')
                                <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700 font-medium">
                                    Selesai
                                </span>
                            @elseif($status == 'batal')
                                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-medium">
                                    Batal
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-gray-100 text-gray-700 font-medium">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            @endif
                        </td>

                        <td class="p-4">
                            <div class="flex flex-wrap gap-2 mb-3">
                                <a href="{{ route('admin.booking.edit', [$current_team, $booking->id]) }}"
                                   class="bg-yellow-500 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-yellow-600 transition">
                                    Edit
                                </a>

                                <form action="{{ route('admin.booking.destroy', [$current_team, $booking->id]) }}" method="POST">
    @csrf
    @method('DELETE')
    <button class="bg-red-600 text-white px-2 py-1 rounded text-xs">
        Hapus
    </button>
</form>
                                    
                                </form>
                            </div>

                            <form action="{{ route('admin.booking.updateStatus', [$current_team, $booking->id]) }}"
                                  method="POST"
                                  class="flex items-center gap-2">
                                @csrf
                                @method('PUT')

                                <select name="status"
                                        class="border border-gray-300 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="pending" {{ strtolower($booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="lunas" {{ strtolower($booking->status) == 'lunas' ? 'selected' : '' }}>Lunas</option>
                                    <option value="selesai" {{ strtolower($booking->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="batal" {{ strtolower($booking->status) == 'batal' ? 'selected' : '' }}>Batal</option>
                                </select>

                                <button type="submit"
                                        class="bg-slate-800 text-white px-3 py-1.5 rounded-lg text-xs hover:bg-slate-900 transition">
                                    Update
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="text-center p-6 text-gray-500">
                            Belum ada data booking
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $bookings->links() }}
</div>

@endsection

@push('scripts')
<script>
let bookingSearchTimeout = null;

function debounceSearch(input) {
    clearTimeout(bookingSearchTimeout);

    bookingSearchTimeout = setTimeout(() => {
        input.form.submit();
    }, 500);
}

function openImage(src) {
    let w = window.open("");
    w.document.write("<img src='" + src + "' style='width:100%'>");
}
</script>
@endpush
