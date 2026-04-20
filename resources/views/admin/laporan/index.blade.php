@extends('layouts.admin')

@section('title','Laporan')
@section('page_heading','Laporan Booking')

@section('content')

<form method="GET" class="grid grid-cols-1 md:grid-cols-5 gap-3 mb-5">
    <input
        type="date"
        name="dari"
        value="{{ request('dari') }}"
        class="border px-3 py-2 rounded"
    >

    <input
        type="date"
        name="sampai"
        value="{{ request('sampai') }}"
        class="border px-3 py-2 rounded"
    >

    <select name="status" class="border px-3 py-2 rounded">
        <option value="">Semua</option>
        <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
    </select>

    <button class="bg-blue-600 text-white rounded px-3 py-2">
        Filter
    </button>

    <a
        href="{{ route('laporan.pdf', [
            'current_team' => $current_team,
            'dari' => request('dari'),
            'sampai' => request('sampai'),
            'status' => request('status'),
        ]) }}"
        target="_blank"
        class="bg-red-600 text-white rounded px-3 py-2 text-center"
    >
        Cetak PDF
    </a>
</form>

<div class="bg-white rounded-xl shadow p-4 mb-4">
    <h3 class="text-lg font-bold">
        Total Pendapatan:
        <span class="text-green-600">
            Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
        </span>
    </h3>
</div>

<div class="bg-white rounded-xl shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-3">Lapangan</th>
                <th class="p-3">Tanggal</th>
                <th class="p-3">Total</th>
                <th class="p-3">Status</th>
            </tr>
        </thead>

        <tbody>
            @forelse($bookings as $booking)
                <tr class="border-t">
                    <td class="p-3">{{ $booking->lapangan->nama ?? '-' }}</td>
                    <td class="p-3">{{ $booking->tanggal }}</td>
                    <td class="p-3 text-green-600">
                        Rp{{ number_format($booking->total_harga, 0, ',', '.') }}
                    </td>
                    <td class="p-3">{{ ucfirst($booking->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-500">
                        Belum ada data laporan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $bookings->links() }}
</div>

@endsection