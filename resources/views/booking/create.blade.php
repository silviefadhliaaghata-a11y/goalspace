@extends('layouts.user')

@section('content')
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
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

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

    function hitungTotalHarga() {
        const selectedOption = lapanganSelect.options[lapanganSelect.selectedIndex];
        const hargaPerJam = parseInt(selectedOption?.dataset?.harga || 0);

        const jamMulai = jamMulaiInput.value;
        const jamSelesai = jamSelesaiInput.value;

        if (!hargaPerJam || !jamMulai || !jamSelesai) {
            totalHargaInput.value = 0;
            return;
        }

        const mulai = new Date('2000-01-01T' + jamMulai);
        const selesai = new Date('2000-01-01T' + jamSelesai);

        const selisihMs = selesai - mulai;

        if (selisihMs <= 0) {
            totalHargaInput.value = 0;
            return;
        }

        const durasiJam = selisihMs / (1000 * 60 * 60);
        totalHargaInput.value = Math.round(durasiJam * hargaPerJam);
    }

    lapanganSelect.addEventListener('change', hitungTotalHarga);
    jamMulaiInput.addEventListener('input', hitungTotalHarga);
    jamSelesaiInput.addEventListener('input', hitungTotalHarga);

    hitungTotalHarga();
});
</script>
@endsection