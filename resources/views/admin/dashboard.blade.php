@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page_heading', 'Administrator Dashboard')

@section('content')
    <!-- STATS GRID -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div class="glass-card rounded-[2.5rem] p-8 group hover:border-emerald-500 transition-all duration-500 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-500/5 rounded-full blur-2xl group-hover:bg-emerald-500/20 transition-all duration-500"></div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Total Pelanggan</p>
            <div class="flex items-end gap-3">
                <h3 class="text-5xl font-black text-white tracking-tighter">{{ $totalUser }}</h3>
                <span class="text-xs font-bold text-emerald-400 mb-2 uppercase">Aktif</span>
            </div>
        </div>

        <div class="glass-card rounded-[2.5rem] p-8 group hover:border-blue-500 transition-all duration-500 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-blue-500/5 rounded-full blur-2xl group-hover:bg-blue-500/20 transition-all duration-500"></div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Total Lapangan</p>
            <div class="flex items-end gap-3">
                <h3 class="text-5xl font-black text-white tracking-tighter">{{ $totalLapangan }}</h3>
                <span class="text-xs font-bold text-blue-400 mb-2 uppercase">Unit</span>
            </div>
        </div>

        <div class="glass-card rounded-[2.5rem] p-8 group hover:border-orange-500 transition-all duration-500 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-500/5 rounded-full blur-2xl group-hover:bg-orange-500/20 transition-all duration-500"></div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Total Booking</p>
            <div class="flex items-end gap-3">
                <h3 class="text-5xl font-black text-white tracking-tighter">{{ $totalBooking }}</h3>
                <span class="text-xs font-bold text-orange-400 mb-2 uppercase">Sesi</span>
            </div>
        </div>

        <div class="glass-card rounded-[2.5rem] p-8 group hover:border-emerald-400 transition-all duration-500 relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-emerald-400/5 rounded-full blur-2xl group-hover:bg-emerald-400/20 transition-all duration-500"></div>
            <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4">Total Pendapatan</p>
            <div class="flex flex-col">
                <span class="text-[10px] font-bold text-emerald-400 uppercase mb-1">Bulan Ini</span>
                <h3 class="text-2xl font-black text-white tracking-tight italic">Rp{{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- DAILY MONITOR -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-10">
        <div class="glass-card rounded-[3rem] p-10 relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-10 text-8xl opacity-[0.03] group-hover:opacity-10 transition-opacity duration-700">⚽</div>
            <h4 class="text-[10px] font-black text-emerald-500 uppercase tracking-[0.4em] mb-6">Booking Hari Ini</h4>
            <div class="flex items-center gap-6">
                <div class="text-7xl font-black text-white tracking-tighter italic">{{ $bookingHariIni }}</div>
                <div class="h-16 w-[1px] bg-white/10"></div>
                <div>
                    <p class="text-sm font-bold text-slate-400">Pertandingan terjadwal</p>
                    <p class="text-xs text-slate-500 mt-1 uppercase tracking-widest font-black">Ready to play</p>
                </div>
            </div>
        </div>

        <div class="glass-card rounded-[3rem] p-10 relative overflow-hidden group">
            <div class="absolute right-0 top-0 p-10 text-8xl opacity-[0.03] group-hover:opacity-10 transition-opacity duration-700">⏳</div>
            <h4 class="text-[10px] font-black text-orange-500 uppercase tracking-[0.4em] mb-6">Menunggu Validasi</h4>
            <div class="flex items-center gap-6">
                <div class="text-7xl font-black text-white tracking-tighter italic">{{ $bookingPending }}</div>
                <div class="h-16 w-[1px] bg-white/10"></div>
                <div>
                    <p class="text-sm font-bold text-slate-400">Pemesanan perlu dicek</p>
                    <p class="text-xs text-slate-500 mt-1 uppercase tracking-widest font-black italic">Action required</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <div class="glass-card rounded-[3rem] p-10">
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-sm font-black text-white uppercase tracking-[0.3em]">Grafik Aktivitas</h3>
                <div class="flex gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase">Per Bulan</span>
                </div>
            </div>
            <div class="h-[350px]">
                <canvas id="bookingChart"></canvas>
            </div>
        </div>

        <div class="glass-card rounded-[3rem] p-10 text-emerald-400">
            <div class="flex items-center justify-between mb-10">
                <h3 class="text-sm font-black text-white uppercase tracking-[0.3em]">Laporan Keuangan</h3>
                <div class="flex gap-2">
                    <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                    <span class="text-[10px] font-bold text-slate-500 uppercase">Omzet</span>
                </div>
            </div>
            <div class="h-[350px]">
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

const commonOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: { display: false }
    },
    scales: {
        y: { 
            grid: { color: 'rgba(255, 255, 255, 0.05)' },
            ticks: { color: '#64748b', font: { size: 10, weight: 'bold' } }
        },
        x: { 
            grid: { display: false },
            ticks: { color: '#64748b', font: { size: 10, weight: 'bold' } }
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
            borderRadius: 12,
            barThickness: 25
        }]
    },
    options: commonOptions
});

new Chart(document.getElementById('pendapatanChart'), {
    type: 'line',
    data: {
        labels: bulanLabels,
        datasets: [{
            label: 'Pendapatan',
            data: pendapatanData,
            borderColor: '#10b981',
            backgroundColor: 'rgba(16, 185, 129, 0.05)',
            borderWidth: 4,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#fff',
            pointRadius: 4,
            pointHoverRadius: 6
        }]
    },
    options: {
        ...commonOptions,
        scales: {
            ...commonOptions.scales,
            y: {
                ...commonOptions.scales.y,
                ticks: {
                    ...commonOptions.scales.y.ticks,
                    callback: v => 'Rp' + Number(v).toLocaleString('id-ID')
                }
            }
        },
        plugins: {
            ...commonOptions.plugins,
            tooltip: {
                callbacks: {
                    label: c => ' Rp' + Number(c.raw).toLocaleString('id-ID')
                }
            }
        }
    }
});
</script>
@endpush