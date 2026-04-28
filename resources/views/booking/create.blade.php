@extends('layouts.user')

@section('content')
<<<<<<< HEAD
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <div class="bg-gradient-to-r from-green-600 to-green-500 rounded-3xl p-8 text-white shadow-lg">
            <h1 class="text-3xl font-extrabold">Form Booking Lapangan</h1>
            <p class="mt-2 text-green-100">
                Isi data booking dan pembayaran untuk melanjutkan pemesanan.
            </p>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-4 rounded-2xl bg-red-100 border border-red-200 px-4 py-3 text-red-700">
            <ul class="list-disc list-inside text-sm">
=======
<div class="max-w-4xl mx-auto">
    <!-- Header Section -->
    <div class="mb-10 text-center">
        <h1 class="text-4xl font-black text-white tracking-tighter uppercase italic">Reservasi <span class="text-emerald-500 text-5xl">Arena</span></h1>
        <p class="text-slate-400 mt-2 font-bold uppercase tracking-[0.2em] text-xs">Pastikan jadwal tersedia sebelum melakukan pembayaran</p>
    </div>

    @if($errors->any())
        <div class="mb-8 rounded-3xl bg-red-500/10 border border-red-500/20 p-6 text-red-500 animate-pulse">
            <div class="flex items-center gap-3 mb-3">
                <span class="text-xl">⚠️</span>
                <p class="font-black uppercase tracking-widest text-xs">Terjadi Kesalahan</p>
            </div>
            <ul class="list-disc list-inside text-xs font-bold space-y-1">
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

<<<<<<< HEAD
    <div class="bg-white rounded-3xl shadow-sm border border-green-100 p-6 md:p-8">
        <form action="{{ route('booking.store', $current_team) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            {{-- Pilih Lapangan --}}
            <div>
                <label for="lapangan_id" class="mb-2 block text-sm font-semibold text-gray-700">
                    Pilih Lapangan
                </label>
                <select name="lapangan_id" id="lapangan_id"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring focus:ring-green-200"
                        required>
                    <option value="">-- Pilih Lapangan --</option>
                    @foreach($lapangans as $lapangan)
                        <option value="{{ $lapangan->id }}"
                            data-harga="{{ $lapangan->harga }}"
                            {{ old('lapangan_id', $selectedLapangan->id ?? '') == $lapangan->id ? 'selected' : '' }}>
                            {{ $lapangan->nama }} - Rp {{ number_format($lapangan->harga, 0, ',', '.') }}/jam
                        </option>
                    @endforeach
                </select>
                @error('lapangan_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nama Pemesan --}}
            <div>
                <label for="nama_pemesan" class="mb-2 block text-sm font-semibold text-gray-700">
                    Nama Pemesan
                </label>
                <input type="text"
                       name="nama_pemesan"
                       id="nama_pemesan"
                       value="{{ old('nama_pemesan', auth()->user()->name) }}"
                       class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring focus:ring-green-200"
                       required>
                @error('nama_pemesan')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tanggal --}}
            <div>
                <label for="tanggal" class="mb-2 block text-sm font-semibold text-gray-700">
                    Tanggal Booking
                </label>
                <input type="date"
                       name="tanggal"
                       id="tanggal"
                       value="{{ old('tanggal') }}"
                       class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring focus:ring-green-200"
                       required>
                @error('tanggal')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Jam --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label for="jam_mulai" class="mb-2 block text-sm font-semibold text-gray-700">
                        Jam Mulai
                    </label>
                    <input type="time"
                           name="jam_mulai"
                           id="jam_mulai"
                           value="{{ old('jam_mulai') }}"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring focus:ring-green-200"
                           required>
                    @error('jam_mulai')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jam_selesai" class="mb-2 block text-sm font-semibold text-gray-700">
                        Jam Selesai
                    </label>
                    <input type="time"
                           name="jam_selesai"
                           id="jam_selesai"
                           value="{{ old('jam_selesai') }}"
                           class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring focus:ring-green-200"
                           required>
                    @error('jam_selesai')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Total Harga --}}
            <div>
                <label for="total_harga" class="mb-2 block text-sm font-semibold text-gray-700">
                    Total Harga
                </label>
                <input type="number"
                       name="total_harga"
                       id="total_harga"
                       value="{{ old('total_harga', 0) }}"
                       class="w-full rounded-xl border border-gray-300 px-4 py-3 bg-gray-50"
                       readonly>
                <p class="mt-1 text-xs text-gray-500">
                    Total akan dihitung otomatis dari jam mulai dan jam selesai.
                </p>
            </div>

            <input type="hidden" name="status" value="pending">

            {{-- Metode Pembayaran --}}
            <div>
                <label for="metode_pembayaran" class="mb-2 block text-sm font-semibold text-gray-700">
                    Metode Pembayaran
                </label>
                <select name="metode_pembayaran"
                        id="metode_pembayaran"
                        class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring focus:ring-green-200"
                        required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="Transfer Bank" {{ old('metode_pembayaran') == 'Transfer Bank' ? 'selected' : '' }}>Transfer Bank</option>
                    <option value="QRIS" {{ old('metode_pembayaran') == 'QRIS' ? 'selected' : '' }}>QRIS</option>
                    <option value="Tunai" {{ old('metode_pembayaran') == 'Tunai' ? 'selected' : '' }}>Tunai</option>
                </select>
                @error('metode_pembayaran')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Catatan Pembayaran --}}
            <div>
                <label for="catatan_pembayaran" class="mb-2 block text-sm font-semibold text-gray-700">
                    Catatan Pembayaran
                </label>
                <textarea name="catatan_pembayaran"
                          id="catatan_pembayaran"
                          rows="4"
                          class="w-full rounded-xl border border-gray-300 px-4 py-3 focus:border-green-500 focus:ring focus:ring-green-200"
                          placeholder="Tambahkan catatan jika diperlukan">{{ old('catatan_pembayaran') }}</textarea>
                @error('catatan_pembayaran')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Bukti Pembayaran --}}
            <div>
                <label for="bukti_pembayaran" class="mb-2 block text-sm font-semibold text-gray-700">
                    Upload Bukti Pembayaran
                </label>
                <input type="file"
                       name="bukti_pembayaran"
                       id="bukti_pembayaran"
                       class="w-full rounded-xl border border-gray-300 px-4 py-3 file:mr-4 file:rounded-lg file:border-0 file:bg-green-600 file:px-4 file:py-2 file:text-white hover:file:bg-green-700"
                       required>
                @error('bukti_pembayaran')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <button type="submit"
                        class="bg-green-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-green-700 transition">
                    Simpan Booking
                </button>

                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="bg-gray-100 text-gray-700 px-6 py-3 rounded-xl font-semibold hover:bg-gray-200 transition text-center">
                    Kembali
=======
    <div class="glass-card rounded-[3.5rem] p-10 md:p-16 border-white/10 shadow-2xl relative overflow-hidden">
        <div class="absolute -right-20 -top-20 w-64 h-64 bg-emerald-500/10 rounded-full blur-3xl"></div>
        
        <form action="{{ route('booking.store', $current_team) }}" method="POST" enctype="multipart/form-data" class="space-y-10 relative z-10">
            @csrf

            <!-- Arena Selection -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="space-y-4">
                    <label for="lapangan_id" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">Pilih Arena</label>
                    <select name="lapangan_id" id="lapangan_id"
                            class="w-full bg-white/5 border border-white/10 text-white font-black uppercase tracking-widest px-8 py-5 rounded-[2rem] focus:outline-none focus:border-emerald-500 transition appearance-none cursor-pointer"
                            required>
                        <option value="" class="bg-slate-900">-- Pilih Lapangan --</option>
                        @foreach($lapangans as $lapangan)
                            <option value="{{ $lapangan->id }}"
                                class="bg-slate-900"
                                data-harga="{{ $lapangan->harga }}"
                                {{ old('lapangan_id', $selectedLapangan->id ?? '') == $lapangan->id ? 'selected' : '' }}>
                                {{ $lapangan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-4">
                    <label for="nama_pemesan" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">Nama Pemesan</label>
                    <input type="text" name="nama_pemesan" id="nama_pemesan"
                           value="{{ old('nama_pemesan', auth()->user()->name) }}"
                           class="w-full bg-white/5 border border-white/10 text-white font-black uppercase tracking-widest px-8 py-5 rounded-[2rem] focus:outline-none focus:border-emerald-500 transition"
                           required>
                </div>
            </div>

            <!-- Schedule -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-4">
                    <label for="tanggal" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">Tanggal Main</label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}"
                           class="w-full bg-white/5 border border-white/10 text-white font-black uppercase tracking-widest px-6 py-5 rounded-[2rem] focus:outline-none focus:border-emerald-500 transition cursor-pointer"
                           required>
                </div>

                <div class="space-y-4">
                    <label for="jam_mulai" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">Jam Mulai</label>
                    <input type="time" name="jam_mulai" id="jam_mulai" value="{{ old('jam_mulai') }}"
                           class="w-full bg-white/5 border border-white/10 text-white font-black uppercase tracking-widest px-6 py-5 rounded-[2rem] focus:outline-none focus:border-emerald-500 transition cursor-pointer"
                           required>
                </div>

                <div class="space-y-4">
                    <label for="jam_selesai" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">Jam Selesai</label>
                    <input type="time" name="jam_selesai" id="jam_selesai" value="{{ old('jam_selesai') }}"
                           class="w-full bg-white/5 border border-white/10 text-white font-black uppercase tracking-widest px-6 py-5 rounded-[2rem] focus:outline-none focus:border-emerald-500 transition cursor-pointer"
                           required>
                </div>
            </div>

            <!-- Payment Info -->
            <div class="p-10 bg-emerald-500/5 rounded-[3rem] border border-emerald-500/10">
                <div class="flex flex-col md:flex-row items-center justify-between gap-8">
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-2">Estimasi Pembayaran</p>
                        <div class="flex items-baseline gap-2">
                            <span class="text-white font-black italic text-5xl tracking-tighter" id="display_total">Rp0</span>
                            <span class="text-emerald-500 font-bold uppercase text-[10px]">Net</span>
                        </div>
                        <input type="hidden" name="total_harga" id="total_harga" value="0">
                    </div>

                    <div class="w-full md:w-64 space-y-4">
                        <label for="metode_pembayaran" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">Metode Bayar</label>
                        <select name="metode_pembayaran" id="metode_pembayaran"
                                class="w-full bg-white/10 border border-white/20 text-white font-black uppercase tracking-widest px-6 py-4 rounded-2xl focus:outline-none focus:border-emerald-500 transition appearance-none cursor-pointer"
                                required>
                            <option value="" class="bg-slate-900">-- Pilih Metode --</option>
                            <option value="Transfer Bank" class="bg-slate-900">Transfer Bank</option>
                            <option value="QRIS" class="bg-slate-900">QRIS</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Catatan -->
            <div class="space-y-4">
                <label for="catatan_pembayaran" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4">Catatan (Opsional)</label>
                <textarea name="catatan_pembayaran" id="catatan_pembayaran" rows="3"
                          class="w-full bg-white/5 border border-white/10 text-white font-bold px-8 py-5 rounded-[2rem] focus:outline-none focus:border-emerald-500 transition"
                          placeholder="Contoh: Titip rompi atau air minum">{{ old('catatan_pembayaran') }}</textarea>
            </div>

            <!-- Bukti Pembayaran -->
            <div class="space-y-4">
                <label for="bukti_pembayaran" class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] ml-4 text-emerald-400">Bukti Pembayaran (Wajib)</label>
                <div class="relative group">
                    <input type="file" name="bukti_pembayaran" id="bukti_pembayaran"
                           class="hidden" required onchange="updateFileName(this)">
                    <label for="bukti_pembayaran" 
                           class="w-full bg-emerald-500/5 hover:bg-emerald-500/10 border-2 border-dashed border-emerald-500/20 text-white p-10 rounded-[2.5rem] flex flex-col items-center justify-center cursor-pointer transition-all">
                        <span class="text-3xl mb-3">📸</span>
                        <span class="font-black uppercase tracking-widest text-xs" id="file_name_display">Klik untuk Upload Screenshot Bukti</span>
                        <span class="text-[9px] text-slate-500 mt-2">Format: JPG, PNG, WEBP (Max 2MB)</span>
                    </label>
                </div>
            </div>

            <!-- Footer Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 pt-6">
                <button type="submit"
                        class="flex-1 bg-emerald-500 hover:bg-emerald-400 text-slate-950 font-black py-6 rounded-[2rem] transition-all shadow-2xl shadow-emerald-500/30 uppercase tracking-widest text-sm italic">
                    Konfirmasi Booking & Bayar
                </button>

                <a href="{{ route('user.lapangan.index', $current_team) }}"
                   class="bg-white/5 hover:bg-white/10 text-white font-black px-10 py-6 rounded-[2rem] transition-all uppercase tracking-widest text-xs flex items-center justify-center">
                    Batal
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const lapanganSelect = document.getElementById('lapangan_id');
    const jamMulaiInput = document.getElementById('jam_mulai');
    const jamSelesaiInput = document.getElementById('jam_selesai');
    const totalHargaInput = document.getElementById('total_harga');
<<<<<<< HEAD
=======
    const displayTotal = document.getElementById('display_total');
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d

    function hitungTotalHarga() {
        const selectedOption = lapanganSelect.options[lapanganSelect.selectedIndex];
        const hargaPerJam = parseInt(selectedOption?.dataset?.harga || 0);
<<<<<<< HEAD

=======
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
        const jamMulai = jamMulaiInput.value;
        const jamSelesai = jamSelesaiInput.value;

        if (!hargaPerJam || !jamMulai || !jamSelesai) {
<<<<<<< HEAD
=======
            displayTotal.innerText = 'Rp0';
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
            totalHargaInput.value = 0;
            return;
        }

        const mulai = new Date('2000-01-01T' + jamMulai);
        const selesai = new Date('2000-01-01T' + jamSelesai);
<<<<<<< HEAD

        const selisihMs = selesai - mulai;

        if (selisihMs <= 0) {
=======
        const selisihMs = selesai - mulai;

        if (selisihMs <= 0) {
            displayTotal.innerText = 'Rp0';
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
            totalHargaInput.value = 0;
            return;
        }

        const durasiJam = selisihMs / (1000 * 60 * 60);
<<<<<<< HEAD
        totalHargaInput.value = Math.round(durasiJam * hargaPerJam);
=======
        const total = Math.round(durasiJam * hargaPerJam);
        displayTotal.innerText = 'Rp' + total.toLocaleString('id-ID');
        totalHargaInput.value = total;
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
    }

    lapanganSelect.addEventListener('change', hitungTotalHarga);
    jamMulaiInput.addEventListener('input', hitungTotalHarga);
    jamSelesaiInput.addEventListener('input', hitungTotalHarga);
<<<<<<< HEAD

    hitungTotalHarga();
});
=======
});

function updateFileName(input) {
    const fileNameDisplay = document.getElementById('file_name_display');
    if (input.files && input.files.length > 0) {
        fileNameDisplay.innerText = "✅ " + input.files[0].name;
    }
}
>>>>>>> 00721e68acd6bbb36b9bc4947622351e08c82e7d
</script>
@endsection