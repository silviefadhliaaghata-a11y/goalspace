@extends('layouts.admin')

@section('title', 'Edit Booking')
@section('page_heading', 'Edit Booking')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 md:p-8">

        <form action="{{ route('admin.booking.update', [$current_team, $booking->id]) }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- LAPANGAN --}}
                <div class="md:col-span-2">
                    <label class="block mb-1 font-medium">Lapangan</label>
                    <select name="lapangan_id" class="w-full border rounded-lg px-4 py-2">
                        @foreach($lapangans as $lapangan)
                            <option value="{{ $lapangan->id }}"
                                {{ old('lapangan_id', $booking->lapangan_id) == $lapangan->id ? 'selected' : '' }}>
                                {{ $lapangan->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- NAMA --}}
                <div class="md:col-span-2">
                    <label class="block mb-1 font-medium">Nama Pemesan</label>
                    <input type="text"
                           name="nama_pemesan"
                           value="{{ old('nama_pemesan', $booking->nama_pemesan) }}"
                           class="w-full border rounded-lg px-4 py-2">
                </div>

                {{-- TANGGAL --}}
                <div>
                    <label class="block mb-1 font-medium">Tanggal</label>
                    <input type="date"
                           name="tanggal"
                           value="{{ old('tanggal', \Carbon\Carbon::parse($booking->tanggal)->format('Y-m-d')) }}"
                           class="w-full border rounded-lg px-4 py-2">
                </div>

                {{-- STATUS --}}
                <div>
                    <label class="block mb-1 font-medium">Status</label>
                    <select name="status" class="w-full border rounded-lg px-4 py-2" required>
                        <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="lunas" {{ old('status', $booking->status) == 'lunas' ? 'selected' : '' }}>Lunas</option>
                        <option value="selesai" {{ old('status', $booking->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="batal" {{ old('status', $booking->status) == 'batal' ? 'selected' : '' }}>Batal</option>
                    </select>
                </div>

                {{-- JAM MULAI --}}
                <div>
                    <label class="block mb-1 font-medium">Jam Mulai</label>
                    <input type="time"
                           name="jam_mulai"
                           value="{{ old('jam_mulai', \Carbon\Carbon::parse($booking->jam_mulai)->format('H:i')) }}"
                           class="w-full border rounded-lg px-4 py-2">
                </div>

                {{-- JAM SELESAI --}}
                <div>
                    <label class="block mb-1 font-medium">Jam Selesai</label>
                    <input type="time"
                           name="jam_selesai"
                           value="{{ old('jam_selesai', \Carbon\Carbon::parse($booking->jam_selesai)->format('H:i')) }}"
                           class="w-full border rounded-lg px-4 py-2">
                </div>

                {{-- METODE --}}
                <div class="md:col-span-2">
                    <label class="block mb-1 font-medium">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="w-full border rounded-lg px-4 py-2">
                        <option value="">Pilih Metode</option>
                        <option value="transfer" {{ old('metode_pembayaran', $booking->metode_pembayaran) == 'transfer' ? 'selected' : '' }}>Transfer</option>
                        <option value="cash" {{ old('metode_pembayaran', $booking->metode_pembayaran) == 'cash' ? 'selected' : '' }}>Cash</option>
                        <option value="qris" {{ old('metode_pembayaran', $booking->metode_pembayaran) == 'qris' ? 'selected' : '' }}>QRIS</option>
                    </select>
                </div>

                {{-- BUKTI --}}
                <div class="md:col-span-2">
                    <label class="block mb-1 font-medium">Bukti Pembayaran</label>
                    <input type="file"
                           name="bukti_pembayaran"
                           class="w-full border rounded-lg px-4 py-2 bg-white">

                    @if($booking->bukti_pembayaran)
                        <div class="mt-3">
                            <img src="{{ asset('storage/'.$booking->bukti_pembayaran) }}"
                                 class="w-32 rounded shadow">
                        </div>
                    @endif
                </div>

                {{-- CATATAN --}}
                <div class="md:col-span-2">
                    <label class="block mb-1 font-medium">Catatan Pembayaran</label>
                    <textarea name="catatan_pembayaran"
                              class="w-full border rounded-lg px-4 py-2"
                              rows="4">{{ old('catatan_pembayaran', $booking->catatan_pembayaran) }}</textarea>
                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex gap-3 mt-4">
                <a href="{{ route('admin.booking.index', $current_team) }}"
                   class="bg-gray-300 px-5 py-2 rounded-lg">
                    Kembali
                </a>

                <button type="submit"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg">
                    Update Booking
                </button>
            </div>

        </form>
    </div>
</div>
@endsection