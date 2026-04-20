<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Booking</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            margin-bottom: 5px;
        }

        p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
        }

        th {
            background: #eeeeee;
            text-align: left;
        }
    </style>
</head>
<body>

    <h2>Laporan Booking Lapangan</h2>

    @if($dari || $sampai)
        <p>
            Periode: {{ $dari ?: '-' }} s/d {{ $sampai ?: '-' }}
        </p>
    @endif

    @if($status)
        <p>Status: {{ ucfirst($status) }}</p>
    @endif

    <p>
        Total Pendapatan:
        <strong>Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</strong>
    </p>

    <table>
        <thead>
            <tr>
                <th>Lapangan</th>
                <th>Pemesan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>{{ $booking->lapangan->nama ?? '-' }}</td>
                    <td>{{ $booking->nama_pemesan ?? '-' }}</td>
                    <td>{{ $booking->tanggal ?? '-' }}</td>
                    <td>{{ $booking->jam_mulai ?? '-' }} - {{ $booking->jam_selesai ?? '-' }}</td>
                    <td>Rp{{ number_format($booking->total_harga ?? 0, 0, ',', '.') }}</td>
                    <td>{{ ucfirst($booking->status ?? '-') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">
                        Tidak ada data booking
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>