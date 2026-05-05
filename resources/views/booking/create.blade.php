@extends('layouts.user')

@section('content')
<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black text-white-800 tracking-tighter uppercase italic">
            Reservasi <span class="text-emerald-500 text-5xl">Arena</span>
        </h1>
        <p class="text-slate-500 mt-2 font-bold uppercase tracking-[0.2em] text-xs">
            Pilih jadwal kosong terlebih dahulu sebelum melakukan pembayaran
        </p>
    </div>

    @if($errors->any())
        <div class="mb-8 rounded-3xl bg-red-100 border border-red-300 p-6 text-red-600">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-xl">⚠️</span>
                <p class="font-black uppercase tracking-widest text-xs">Terjadi Kesalahan</p>
            </div>
            <ul class="list-disc list-inside text-xs font-bold space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('booking.store', $current_team) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
        @csrf

        <!-- USER INFO -->
        <div class="glass-card rounded-[3rem] p-10 bg-white border border-gray-200 shadow-xl">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                <div class="space-y-4">
                    <label class="text-[15px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">
                        Nama Pemesan
                    </label>
                    <input type="text" name="nama_pemesan"
                           value="{{ old('nama_pemesan', auth()->user()->name) }}"
                           class="w-full bg-white border border-gray-300 text-gray-800 font-bold px-8 py-5 rounded-[2rem] focus:outline-none focus:border-emerald-500"
                           required>
                </div>

                <div class="space-y-4">
                    <label class="text-[15px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">
                        Pilih Tanggal
                    </label>
                    <input type="date" name="tanggal" id="tanggal"
                           value="{{ old('tanggal') }}"
                           class="w-full bg-white border border-gray-300 text-gray-800 font-bold px-8 py-5 rounded-[2rem] focus:outline-none focus:border-emerald-500"
                           required>
                </div>

            </div>
        </div>

        <!-- LIVE SCHEDULER -->
        <div class="glass-card rounded-[3rem] p-10 bg-white border border-gray-200 shadow-2xl">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 gap-4">
                <div>
                    <h2 class="text-3xl font-black uppercase italic text-white-800 tracking-tight">
                        Live <span class="text-emerald-500">Scheduler</span>
                    </h2>
                    <p class="text-slate-500 text-xs font-bold uppercase tracking-[0.2em] mt-2">
                        Pilih slot hijau yang tersedia
                    </p>
                </div>

                <div class="flex gap-4 text-xs font-black uppercase">
                    <span class="flex items-center gap-2 text-emerald-500">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span> Tersedia
                    </span>
                    <span class="flex items-center gap-2 text-red-500">
                        <span class="w-3 h-3 rounded-full bg-red-500"></span> Terisi
                    </span>
                </div>
            </div>

            <!-- LAPANGAN SCHEDULER -->
            <div class="space-y-8">

                @foreach($lapangans as $lapangan)
                    <div class="border border-gray-200 rounded-[2rem] p-6 bg-gray-50">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
                            <div>
                                <h3 class="text-lg font-black text-gray-800 uppercase tracking-wider">
                                    {{ $lapangan->nama }}
                                </h3>
                                <p class="text-emerald-500 font-bold text-xs uppercase tracking-widest">
                                    Rp{{ number_format($lapangan->harga, 0, ',', '.') }}/Jam
                                </p>
                            </div>
                        </div>

                        <!-- SLOT -->
                        <div class="grid grid-cols-2 md:grid-cols-5 lg:grid-cols-7 gap-3">

                            @for($i=8; $i<=22; $i++)
                                <button type="button"
                                        class="slot-btn bg-emerald-50 hover:bg-emerald-500 hover:text-white border border-emerald-300 text-emerald-600 font-black py-4 rounded-2xl transition-all"
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
        </div>

        <!-- SLOT TERPILIH -->
        <div class="glass-card rounded-[3rem] p-10 bg-emerald-50 border border-emerald-200 shadow-xl">
            <h3 class="text-sm font-black text-white uppercase tracking-[0.3em] mb-4">
                Jadwal Dipilih
            </h3>

            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div>
                    <h2 class="text-4xl font-black italic text-white tracking-tight" id="selected_slot">
                        Belum memilih jadwal
                    </h2>
                    <p class="text-slate-500 font-bold mt-2" id="selected_lapangan">
                        Pilih slot tersedia di atas
                    </p>
                </div>

                <div class="text-right">
                    <p class="text-[15px] font-black text-slate-500 uppercase tracking-[0.3em]">
                        Total Harga
                    </p>
                    <h2 class="text-4xl font-black text-emerald-500 italic" id="display_total">
                        Rp0
                    </h2>
                </div>
            </div>

            <!-- HIDDEN INPUT -->
            <input type="hidden" name="lapangan_id" id="lapangan_id">
            <input type="hidden" name="jam_mulai" id="jam_mulai">
            <input type="hidden" name="jam_selesai" id="jam_selesai">
            <input type="hidden" name="total_harga" id="total_harga">
        </div>

        <!-- PAYMENT -->
        <div class="glass-card rounded-[3rem] p-10 bg-white border border-gray-200 shadow-xl space-y-8">

            <div class="space-y-4">
                <label class="text-[15px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">
                    Metode Pembayaran
                </label>
                <select name="metode_pembayaran"
                        class="w-full bg-white border border-gray-300 text-gray-800 font-bold px-8 py-5 rounded-[2rem] focus:outline-none focus:border-emerald-500"
                        required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="QRIS">QRIS</option>
                </select>
            </div>

            <div class="space-y-4">
                <label class="text-[15px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">
                    Catatan (Opsional)
                </label>
                <textarea name="catatan_pembayaran" rows="3"
                          class="w-full bg-white border border-gray-300 text-gray-800 font-bold px-8 py-5 rounded-[2rem] focus:outline-none focus:border-emerald-500"></textarea>
            </div>

            <div class="space-y-4">
                <label class="text-[12px] font-black text-emerald-500 uppercase tracking-[0.3em] ml-4">
                    Upload Bukti Pembayaran
                </label>

                <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" class="hidden" required onchange="updateFileName(this)">

                <label for="bukti_pembayaran"
                       class="w-full bg-emerald-50 hover:bg-emerald-100 border-2 border-dashed border-emerald-300 text-white-800 p-10 rounded-[2.5rem] flex flex-col items-center justify-center cursor-pointer transition-all">
                    <span class="text-3xl mb-3">📸</span>
                    <span class="font-black uppercase tracking-widest text-xs" id="file_name_display">
                        Klik untuk Upload Bukti
                    </span>
                </label>
            </div>

            <!-- BUTTON -->
            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                <button type="submit"
                        class="flex-1 bg-emerald-500 hover:bg-emerald-400 text-white font-black py-6 rounded-[2rem] uppercase tracking-widest text-sm">
                    Konfirmasi Booking
                </button>

                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-black px-10 py-6 rounded-[2rem] uppercase tracking-widest text-xs flex items-center justify-center">
                    Batal
                </a>
            </div>

        </div>
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
            btn.classList.remove('bg-emerald-500', 'text-white');
            btn.classList.add('bg-emerald-50', 'text-emerald-600');
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

    slotButtons.forEach(btn => {
        btn.disabled = false;
        btn.classList.remove(
            'bg-red-500',
            'text-white',
            'border-red-500',
            'cursor-not-allowed',
            'opacity-70'
        );
        btn.classList.add(
            'bg-emerald-50',
            'text-emerald-600',
            'border-emerald-300'
        );
    });

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
                                'bg-emerald-50',
                                'text-emerald-600',
                                'border-emerald-300',
                                'hover:bg-emerald-500'
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

        const durasi = sortedSlots.length;
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

    slotButtons.forEach(button => {
        button.addEventListener('click', function () {
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

            // Jika pilih lapangan berbeda → reset
            if (selectedLapangan && selectedLapangan.id !== lapanganId) {
                alert('Pilih slot pada lapangan yang sama.');
                return;
            }

            // Jika slot sudah dipilih → unselect
            const existingIndex = selectedSlots.findIndex(
                slot => slot.startHour === startHour && slot.lapanganId === lapanganId
            );

            if (existingIndex !== -1) {
                selectedSlots.splice(existingIndex, 1);
                this.classList.remove('bg-emerald-500', 'text-white');
                this.classList.add('bg-emerald-50', 'text-emerald-600');

                if (selectedSlots.length === 0) {
                    resetSelection();
                    return;
                }

                updateDisplay();
                return;
            }

            // Validasi slot harus berurutan
            if (!isSequential(slotData)) {
                alert('Slot harus berurutan tanpa jeda.');
                return;
            }

            // Simpan data lapangan pertama
            if (!selectedLapangan) {
                selectedLapangan = {
                    id: lapanganId,
                    nama: lapanganNama
                };
                hargaPerJam = harga;
            }

            selectedSlots.push(slotData);

            this.classList.remove('bg-emerald-50', 'text-emerald-600');
            this.classList.add('bg-emerald-500', 'text-white');

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
```
