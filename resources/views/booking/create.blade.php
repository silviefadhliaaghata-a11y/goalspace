@extends('layouts.user')

@section('content')
<div class="max-w-7xl mx-auto space-y-8 text-slate-800">

    <!-- HERO -->
    <section class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 md:p-12 relative overflow-hidden">

        <!-- BACKGROUND -->
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=1600&q=80"
                 alt="Futsal Field"
                 class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-white/80"></div>
        </div>

        <!-- CONTENT -->
        <div class="relative z-10 flex flex-col lg:flex-row justify-between items-center gap-10">

            <div class="max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.3em] text-blue-600 mb-4">
                    Booking Arena
                </p>

                <h1 class="text-4xl md:text-6xl font-black leading-tight text-slate-900">
                    Reservasi Arena,<br>
                    <span class="text-blue-600">Lebih Cepat & Praktis.</span>
                </h1>

                <p class="mt-5 text-slate-700 text-lg leading-relaxed max-w-2xl">
                    Pilih jadwal kosong terlebih dahulu, tentukan slot terbaik, lalu selesaikan booking dengan sistem modern.
                </p>
            </div>

            <!-- SUMMARY -->
            <<div class="bg-white/90 backdrop-blur-sm rounded-3xl p-8 border border-slate-200 shadow-sm w-full max-w-md">
    <p class="text-xs uppercase font-bold tracking-widest text-white mb-3">
        Panduan Cepat
    </p>

    <ul class="space-y-3 text-sm font-semibold text-white">
        <li>✔ Pilih tanggal bermain</li>
        <li>✔ Pilih slot hijau tersedia</li>
        <li>✔ Upload bukti pembayaran</li>
        <li>✔ Konfirmasi booking</li>
    </ul>
</div>

        </div>
    </section>

    @if($errors->any())
        <div class="rounded-3xl bg-red-50 border border-red-200 p-6 text-red-700">
            <h3 class="font-black uppercase tracking-widest text-sm mb-4">
                Terjadi Kesalahan
            </h3>

            <ul class="space-y-2 text-sm">
                @foreach($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('booking.store', $current_team) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <!-- USER INFO -->
        <section class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest text-slate-500 mb-3">
                        Nama Pemesan
                    </label>

                    <input type="text"
                           name="nama_pemesan"
                           value="{{ old('nama_pemesan', auth()->user()->name) }}"
                           class="w-full border border-slate-300 rounded-2xl px-6 py-4 font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none"
                           required>
                </div>

                <div>
                    <label class="block text-sm font-bold uppercase tracking-widest text-slate-500 mb-3">
                        Pilih Tanggal
                    </label>

                    <input type="date"
                           name="tanggal"
                           id="tanggal"
                           value="{{ old('tanggal', $tanggal ?? '') }}"
                           class="w-full border border-slate-300 rounded-2xl px-6 py-4 font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none"
                           required>
                </div>

            </div>
        </section>

        <!-- LIVE SCHEDULER -->
        <section class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8">

            <div class="flex flex-col lg:flex-row justify-between items-center gap-6 mb-10">

                <div>
                    <h2 class="text-3xl font-black text-slate-900">
                        Live Scheduler
                    </h2>

                    <p class="text-slate-500 mt-2">
                        Pilih slot hijau yang tersedia
                    </p>
                </div>

                <div class="flex gap-6 text-sm font-bold">
                    <span class="flex items-center gap-2 text-blue-600">
                        <span class="w-3 h-3 rounded-full bg-blue-600"></span> Tersedia
                    </span>

                    <span class="flex items-center gap-2 text-red-500">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span> Terisi
                    </span>
                </div>

            </div>

            <div class="space-y-8">

                @foreach($lapangans as $lapangan)
                    <div class="border border-slate-200 rounded-3xl p-6 bg-slate-50">

                        <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                            <div>
                                <h3 class="text-xl font-black text-slate-900">
                                    {{ $lapangan->nama }}
                                </h3>

                                <p class="text-blue-600 font-bold text-sm mt-2">
                                    Rp{{ number_format($lapangan->harga, 0, ',', '.') }}/Jam
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 md:grid-cols-4 xl:grid-cols-5 gap-3">

                            @for($i=8; $i<=22; $i++)
                                <button type="button"
                                        class="slot-btn bg-blue-50 hover:bg-blue-600 hover:text-white border border-blue-200 text-blue-600 font-bold py-4 rounded-2xl transition-all"
                                        data-lapangan="{{ $lapangan->id }}"
                                        data-lapangan-nama="{{ $lapangan->nama }}"
                                        data-harga="{{ $lapangan->harga }}"
                                        data-jam-mulai="{{ sprintf('%02d:00', $i) }}"
                                        data-jam-selesai="{{ sprintf('%02d:00', $i+1) }}">
                                    {{ sprintf('%02d:00', $i) }} - {{ sprintf('%02d:00', $i+1) }}
                                </button>
                            @endfor

                        </div>

                    </div>
                @endforeach

            </div>

        </section>

        <!-- SELECTED SLOT -->
        <section class="bg-blue-50 rounded-3xl border border-blue-200 shadow-sm p-8">

            <div class="flex flex-col lg:flex-row justify-between items-center gap-8">

                <div>
                    <p class="text-xs uppercase font-bold tracking-widest text-blue-600 mb-3">
                        Jadwal Dipilih
                    </p>

                    <h2 class="text-4xl font-black text-slate-900" id="selected_slot">
                        Belum memilih jadwal
                    </h2>

                    <p class="text-slate-600 mt-2 font-semibold" id="selected_lapangan">
                        Pilih slot tersedia di atas
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-xs uppercase font-bold tracking-widest text-slate-500 mb-3">
                        Total Harga
                    </p>

                    <h2 class="text-4xl font-black text-blue-600" id="display_total">
                        Rp0
                    </h2>
                </div>

            </div>

            <input type="hidden" name="lapangan_id" id="lapangan_id">
            <input type="hidden" name="jam_mulai" id="jam_mulai">
            <input type="hidden" name="jam_selesai" id="jam_selesai">
            <input type="hidden" name="total_harga" id="total_harga">

        </section>
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-6 mb-8">
    <h3 class="font-black text-blue-700 uppercase mb-4">
        Informasi Pembayaran
    </h3>

    <p class="font-semibold text-slate-700">
        Transfer Bank BCA
    </p>

    <p class="text-2xl font-black text-slate-900 mt-2">
        1234567890
    </p>

    <p class="text-sm text-slate-500 mt-2">
        a.n GoalSpace Arena
    </p>

    <p class="mt-4 text-sm text-slate-500">
        Atau scan QRIS:
    </p>

    <img src="{{ asset('images/qris-goalspace.png') }}"
         alt="QRIS"
         class="w-48 mt-4 rounded-2xl border border-slate-200">
</div>

        <!-- PAYMENT -->
        <section class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 space-y-8">

            <div>
                <label class="block text-sm font-bold uppercase tracking-widest text-slate-500 mb-3">
                    Metode Pembayaran
                </label>

                <select name="metode_pembayaran"
                        class="w-full border border-slate-300 rounded-2xl px-6 py-4 font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none"
                        required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="QRIS">QRIS</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold uppercase tracking-widest text-slate-500 mb-3">
                    Catatan (Opsional)
                </label>

                <textarea name="catatan_pembayaran"
                          rows="3"
                          class="w-full border border-slate-300 rounded-2xl px-6 py-4 font-semibold focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none"></textarea>
            </div>

            <div>
                <label class="block text-sm font-bold uppercase tracking-widest text-blue-600 mb-4">
                    Upload Bukti Pembayaran
                </label>

                <input type="file"
                       name="bukti_pembayaran"
                       id="bukti_pembayaran"
                       class="hidden"
                       required
                       onchange="updateFileName(this)">

                <label for="bukti_pembayaran"
                       class="w-full bg-blue-50 hover:bg-blue-100 border-2 border-dashed border-blue-300 rounded-3xl p-10 flex flex-col items-center justify-center cursor-pointer transition-all">
                    <span class="text-4xl mb-4">📸</span>

                    <span class="font-bold text-slate-700 uppercase tracking-widest text-sm" id="file_name_display">
                        Klik untuk Upload Bukti
                    </span>
                </label>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 pt-4">

                <button type="submit"
                        class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-5 rounded-2xl uppercase tracking-wide transition-all">
                    Konfirmasi Booking
                </button>

                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="bg-slate-100 hover:bg-slate-200 text-slate-800 font-bold px-10 py-5 rounded-2xl uppercase tracking-wide flex items-center justify-center transition-all">
                    Batal
                </a>

            </div>

        </section>

    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slotButtons = document.querySelectorAll('.slot-btn');
    const tanggalInput = document.getElementById('tanggal');
    const currentTeam = "{{ $current_team }}";

    let selectedSlots = [];
    let selectedLapangan = null;
    let hargaPerJam = 0;

    function resetSelection() {
        selectedSlots = [];
        selectedLapangan = null;
        hargaPerJam = 0;

        slotButtons.forEach(btn => {
            btn.disabled = false;

            btn.classList.remove(
                'bg-red-500',
                'text-white',
                'border-red-500',
                'cursor-not-allowed',
                'opacity-70',
                'bg-blue-600'
            );

            btn.classList.add(
                'bg-blue-50',
                'text-blue-600',
                'border-blue-200'
            );
        });

        document.getElementById('lapangan_id').value = '';
        document.getElementById('jam_mulai').value = '';
        document.getElementById('jam_selesai').value = '';
        document.getElementById('total_harga').value = 0;

        document.getElementById('selected_slot').innerText = 'Belum memilih jadwal';
        document.getElementById('selected_lapangan').innerText = 'Pilih slot tersedia di atas';
        document.getElementById('display_total').innerText = 'Rp0';
    }

    function formatHour(hour) {
        return hour.toString().padStart(2, '0') + ':00';
    }

    async function loadSchedule() {
        const tanggal = tanggalInput.value;

        if (!tanggal) return;

        resetSelection();

        try {
            const response = await fetch(`/${currentTeam}/booking/check-schedule?tanggal=${tanggal}`);
            const data = await response.json();

            Object.entries(data.bookings).forEach(([lapanganId, bookings]) => {
                bookings.forEach(booking => {
                    const bookedStart = parseInt(booking.jam_mulai.split(':')[0]);
                    const bookedEnd = parseInt(booking.jam_selesai.split(':')[0]);

                    slotButtons.forEach(btn => {
                        if (btn.dataset.lapangan === lapanganId) {
                            const slotStart = parseInt(btn.dataset.jamMulai.split(':')[0]);

                            if (slotStart >= bookedStart && slotStart < bookedEnd) {
                                btn.disabled = true;

                                btn.classList.remove(
                                    'bg-blue-50',
                                    'text-blue-600',
                                    'border-blue-200'
                                );

                                btn.classList.add(
                                    'bg-red-500',
                                    'text-white',
                                    'border-red-500',
                                    'cursor-not-allowed',
                                    'opacity-70'
                                );
                            }
                        }
                    });
                });
            });

        } catch (error) {
            console.error('Gagal load schedule:', error);
        }
    }

    function updateDisplay() {
        if (selectedSlots.length === 0) {
            resetSelection();
            return;
        }

        const sortedSlots = selectedSlots.sort((a, b) => a.startHour - b.startHour);

        const jamMulai = formatHour(sortedSlots[0].startHour);
        const jamSelesai = formatHour(sortedSlots[sortedSlots.length - 1].endHour);

        const durasi = selectedSlots.length;
        const total = durasi * hargaPerJam;

        document.getElementById('lapangan_id').value = selectedLapangan.id;
        document.getElementById('jam_mulai').value = jamMulai;
        document.getElementById('jam_selesai').value = jamSelesai;
        document.getElementById('total_harga').value = total;

        document.getElementById('selected_slot').innerText = jamMulai + ' - ' + jamSelesai;
        document.getElementById('selected_lapangan').innerText =
            selectedLapangan.nama + ' • ' + durasi + ' Jam';

        document.getElementById('display_total').innerText =
            'Rp' + total.toLocaleString('id-ID');
    }

    function isSequential(newSlot) {
        if (selectedSlots.length === 0) return true;

        const hours = selectedSlots.map(slot => slot.startHour).sort((a, b) => a - b);

        const minHour = hours[0];
        const maxHour = selectedSlots.map(slot => slot.endHour).sort((a, b) => a - b).slice(-1)[0];

        return (
            newSlot.startHour === maxHour ||
            newSlot.endHour === minHour
        );
    }

    tanggalInput.addEventListener('change', loadSchedule);

    if (tanggalInput.value) {
        loadSchedule();
    }

    setInterval(loadSchedule, 30000);

    slotButtons.forEach(button => {
        button.addEventListener('click', function () {
            if (this.disabled) return;

            const lapanganId = this.dataset.lapangan;
            const lapanganNama = this.dataset.lapanganNama;
            const harga = parseInt(this.dataset.harga);
            const jamMulai = this.dataset.jamMulai;
            const jamSelesai = this.dataset.jamSelesai;

            const startHour = parseInt(jamMulai.split(':')[0]);
            const endHour = parseInt(jamSelesai.split(':')[0]);

            const slotData = {
                button: this,
                lapanganId,
                lapanganNama,
                harga,
                startHour,
                endHour
            };

            if (selectedLapangan && selectedLapangan.id !== lapanganId) {
                alert('Pilih slot pada lapangan yang sama.');
                return;
            }

            const existingIndex = selectedSlots.findIndex(
                slot => slot.startHour === startHour && slot.lapanganId === lapanganId
            );

            if (existingIndex !== -1) {
                selectedSlots.splice(existingIndex, 1);

                this.classList.remove('bg-blue-600', 'text-white');
                this.classList.add('bg-blue-50', 'text-blue-600');

                if (selectedSlots.length === 0) {
                    resetSelection();
                    return;
                }

                updateDisplay();
                return;
            }

            if (!isSequential(slotData)) {
                alert('Slot harus berurutan tanpa jeda.');
                return;
            }

            if (!selectedLapangan) {
                selectedLapangan = {
                    id: lapanganId,
                    nama: lapanganNama
                };

                hargaPerJam = harga;
            }

            selectedSlots.push(slotData);

            this.classList.remove('bg-blue-50', 'text-blue-600');
            this.classList.add('bg-blue-600', 'text-white');

            updateDisplay();
        });
    });
});

function updateFileName(input) {
    const display = document.getElementById('file_name_display');

    if (input.files.length > 0) {
        display.innerText = '✅ ' + input.files[0].name;
    }
}
</script>
@endsection