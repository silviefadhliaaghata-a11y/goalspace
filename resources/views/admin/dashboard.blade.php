@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_heading', 'Dashboard Admin')

@section('content')
    {{-- STATS UTAMA --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 group hover:border-emerald-500 transition-all duration-300">
            <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center mb-4 text-xl group-hover:bg-emerald-500 group-hover:text-white transition-all">
                👥
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Pelanggan</p>
            <h3 class="text-3xl font-black text-slate-900 mt-2 tracking-tight">{{ $totalUser }}</h3>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 group hover:border-blue-500 transition-all duration-300">
            <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center mb-4 text-xl group-hover:bg-blue-500 group-hover:text-white transition-all">
                🏟️
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Lapangan</p>
            <h3 class="text-3xl font-black text-slate-900 mt-2 tracking-tight">{{ $totalLapangan }}</h3>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 group hover:border-orange-500 transition-all duration-300">
            <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center mb-4 text-xl group-hover:bg-orange-500 group-hover:text-white transition-all">
                📅
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Booking</p>
            <h3 class="text-3xl font-black text-slate-900 mt-2 tracking-tight">{{ $totalBooking }}</h3>
        </div>

        <div class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 group hover:border-emerald-600 transition-all duration-300">
            <div class="w-12 h-12 bg-emerald-100 text-emerald-700 rounded-2xl flex items-center justify-center mb-4 text-xl group-hover:bg-emerald-600 group-hover:text-white transition-all">
                💰
            </div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Pendapatan</p>
            <h3 class="text-2xl font-black text-slate-900 mt-2 tracking-tight">
                Rp{{ number_format($totalPendapatan, 0, ',', '.') }}
            </h3>
        </div>
    </div>

    {{-- STATS HARIAN --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 relative overflow-hidden">
            <div class="absolute right-0 top-0 p-8 text-6xl opacity-5">⚽</div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Booking Hari Ini</p>
            <h3 class="text-5xl font-black text-emerald-500 mt-4 tracking-tighter">{{ $bookingHariIni }} <span class="text-lg text-slate-300">Pertandingan</span></h3>
            <p class="text-sm text-slate-400 mt-2 font-medium">Pantau jadwal hari ini secara realtime.</p>
        </div>

        <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 relative overflow-hidden">
             <div class="absolute right-0 top-0 p-8 text-6xl opacity-5">⏳</div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Menunggu Validasi</p>
            <h3 class="text-5xl font-black text-orange-500 mt-4 tracking-tighter">{{ $bookingPending }} <span class="text-lg text-slate-300">Pending</span></h3>
            <p class="text-sm text-slate-400 mt-2 font-medium">Segera cek pembayaran pelanggan Anda.</p>
        </div>
    </div>

    {{-- CHARTS --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-10">
        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-lg font-black text-slate-900 tracking-tight uppercase tracking-widest">Statistik Booking</h3>
                <span class="text-[10px] font-bold text-slate-400 uppercase bg-slate-50 px-3 py-1 rounded-full">Tahun {{ date('Y') }}</span>
            </div>
            <div class="h-[300px]">
                <canvas id="bookingChart"></canvas>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8">
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-lg font-black text-slate-900 tracking-tight uppercase tracking-widest">Grafik Pendapatan</h3>
                <span class="text-[10px] font-bold text-emerald-500 uppercase bg-emerald-50 px-3 py-1 rounded-full">Lunas</span>
            </div>
            <div class="h-[300px]">
                <canvas id="pendapatanChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const bulanLabels = @json($namaBulan);
const bookingData = @json($bookingChartData);
const pendapatanData = @json($pendapatanChartData);

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: false }
    },
    scales: {
        y: { 
            beginAtZero: true,
            grid: { display: false },
            ticks: { font: { size: 10, weight: 'bold' } }
        },
        x: { 
            grid: { display: false },
            ticks: { font: { size: 10, weight: 'bold' } }
        }
    }
};

new Chart(document.getElementById('bookingChart'), {
    type: 'bar',
    data: {
        labels: bulanLabels,
        datasets: [{
            label: 'Booking',
            data: bookingData,
            backgroundColor: '#10b981',
            borderRadius: 8,
            barThickness: 20
        }]
    },
    options: chartOptions
});

new Chart(document.getElementById('pendapatanChart'), {
    type: 'line',
    data: {
        labels: bulanLabels,
        datasets: [{
            label: 'Pendapatan',
            data: pendapatanData,
            borderColor: '#10b981',
            backgroundColor: '#10b98120',
            borderWidth: 4,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#fff',
            pointBorderColor: '#10b981',
            pointBorderWidth: 2,
            pointRadius: 4
        }]
    },
    options: {
        ...chartOptions,
        scales: {
            ...chartOptions.scales,
            y: {
                ...chartOptions.scales.y,
                ticks: {
                    ...chartOptions.scales.y.ticks,
                    callback: value => 'Rp' + Number(value).toLocaleString('id-ID')
                }
            }
        },
        plugins: {
            ...chartOptions.plugins,
            tooltip: {
                callbacks: {
                    label: context => ' Rp' + Number(context.raw).toLocaleString('id-ID')
                }
            }
        }
    }
});
</script>
@endpush