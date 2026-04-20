@extends('layouts.admin')

@section('title', 'Tambah Booking')
@section('page_heading', 'Tambah Booking')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">
        <form action="{{ route('booking.store', $current_team) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Lapangan --}}
                <div class="md:col-span-2">
                    <label for="lapangan_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Lapangan
                    </label>
                    <select name="lapangan_id"
                            id="lapangan_id"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Lapangan</option>
                        @foreach($lapangans as $lapangan)
                            <option value="{{ $lapangan->id }}"
                                {{ old('lapangan_id', $selectedLapangan ?? '') == $lapangan->id ? 'selected' : '' }}>
                                {{ $lapangan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Nama Pemesan --}}
                <div class="md:col-span-2">
                    <label for="nama_pemesan" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Pemesan
                    </label>
                    <input type="text"
                           name="nama_pemesan"
                           id="nama_pemesan"
                           value="{{ old('nama_pemesan') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal
                    </label>
                    <input type="date"
                           name="tanggal"
                           id="tanggal"
                           value="{{ old('tanggal', $selectedTanggal ?? '') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Status --}}
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status
                    </label>
                    <select name="status"
                            id="status"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="lunas" {{ old('status') == 'lunas' ? 'selected' : '' }}>
                            Lunas
                        </option>
                        <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="batal" {{ old('status') == 'batal' ? 'selected' : '' }}>
                            Batal
                        </option>
                    </select>
                </div>

                {{-- Jam Mulai --}}
                <div>
                    <label for="jam_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                        Jam Mulai
                    </label>
                    <input type="time"
                           name="jam_mulai"
                           id="jam_mulai"
                           value="{{ old('jam_mulai', $selectedMulai ?? '') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Jam Selesai --}}
                <div>
                    <label for="jam_selesai" class="block text-sm font-medium text-gray-700 mb-2">
                        Jam Selesai
                    </label>
                    <input type="time"
                           name="jam_selesai"
                           id="jam_selesai"
                           value="{{ old('jam_selesai', $selectedSelesai ?? '') }}"
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Metode Pembayaran --}}
                <div class="md:col-span-2">
                    <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                        Metode Pembayaran
                    </label>
                    <select name="metode_pembayaran"
                            id="metode_pembayaran"
                            class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">Pilih Metode</option>
                        <option value="transfer" {{ old('metode_pembayaran') == 'transfer' ? 'selected' : '' }}>
                            Transfer
                        </option>
                        <option value="cash" {{ old('metode_pembayaran') == 'cash' ? 'selected' : '' }}>
                            Cash
                        </option>
                        <option value="qris" {{ old('metode_pembayaran') == 'qris' ? 'selected' : '' }}>
                            QRIS
                        </option>
                    </select>
                </div>

                {{-- Bukti Pembayaran --}}
                <div class="md:col-span-2">
                    <label for="bukti_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                        Bukti Pembayaran
                    </label>
                    <input type="file"
                           name="bukti_pembayaran"
                           id="bukti_pembayaran"
                           class="w-full rounded-lg border border-gray-300 px-4 py-3 bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
    <label class="block mb-1 font-medium">Status</label>
    <select name="status" class="w-full border rounded-lg px-4 py-2" required>
        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="lunas" {{ old('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
    </select>
    @error('status')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>

                {{-- Catatan Pembayaran --}}
                <div class="md:col-span-2">
                    <label for="catatan_pembayaran" class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan Pembayaran
                    </label>
                    <textarea name="catatan_pembayaran"
                              id="catatan_pembayaran"
                              rows="4"
                              class="w-full rounded-lg border border-gray-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('catatan_pembayaran') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <a href="{{ route('booking.index', $current_team) }}"
                   class="bg-gray-200 text-gray-700 px-5 py-3 rounded-lg hover:bg-gray-300">
                    Kembali
                </a>

                <button type="submit"
                        class="bg-blue-600 text-white px-5 py-3 rounded-lg hover:bg-blue-700">
                    Simpan Booking
                </button>
            </div>
        </form>
    </div>
</div>
@endsection