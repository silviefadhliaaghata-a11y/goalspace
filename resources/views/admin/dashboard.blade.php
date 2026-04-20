@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_heading', 'Dashboard Admin')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Total User</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalUser }}</h3>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Total Lapangan</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalLapangan }}</h3>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Total Booking</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-2">{{ $totalBooking }}</h3>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Pendapatan</p>
            <h3 class="text-3xl font-bold text-gray-800 mt-2">
                Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
            </h3>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Booking Hari Ini</p>
            <h3 class="text-2xl font-bold text-blue-600 mt-2">{{ $bookingHariIni }}</h3>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
            <p class="text-sm text-gray-500">Booking Pending</p>
            <h3 class="text-2xl font-bold text-yellow-600 mt-2">{{ $bookingPending }}</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-6">
        <div class="bg-white rounded-xl shadow p-5">
            <h3 class="font-semibold mb-3">Booking per Bulan</h3>
            <canvas id="bookingChart"></canvas>
        </div>

        <div class="bg-white rounded-xl shadow p-5">
            <h3 class="font-semibold mb-3">Pendapatan per Bulan</h3>
            <canvas id="pendapatanChart"></canvas>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const bulanLabels = @json($namaBulan);
const bookingData = @json($bookingChartData);
const pendapatanData = @json($pendapatanChartData);

new Chart(document.getElementById('bookingChart'), {
    type: 'bar',
    data: {
        labels: bulanLabels,
        datasets: [{
            label: 'Booking',
            data: bookingData,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

new Chart(document.getElementById('pendapatanChart'), {
    type: 'line',
    data: {
        labels: bulanLabels,
        datasets: [{
            label: 'Pendapatan',
            data: pendapatanData,
            borderWidth: 2,
            tension: 0.3,
            fill: false
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp' + Number(value).toLocaleString('id-ID');
                    }
                }
            }
        },
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(context) {
                        return 'Rp' + Number(context.raw).toLocaleString('id-ID');
                    }
                }
            }
        }
    }
});
</script>
@endpush