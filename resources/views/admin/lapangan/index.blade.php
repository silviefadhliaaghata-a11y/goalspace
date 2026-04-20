@extends('layouts.admin')

@section('title','Lapangan')
@section('page_heading','Data Lapangan')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
    <a href="{{ route('lapangan.create', $current_team) }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition w-fit">
        + Lapangan
    </a>
</div>

@if(session('success'))
    <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-3">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-3">
        <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="bg-white rounded-xl shadow overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3 text-left">Gambar</th>
                    <th class="p-3 text-left">Nama</th>
                    <th class="p-3 text-left">Jenis</th>
                    <th class="p-3 text-left">Harga</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($lapangans as $lapangan)
                    <tr class="border-t hover:bg-gray-50 transition">
                        <td class="p-3">
                            @if(!empty($lapangan->gambar))
                                <img
                                    src="{{ asset('storage/' . $lapangan->gambar) }}"
                                    alt="{{ $lapangan->nama }}"
                                    class="w-20 h-14 object-cover rounded-lg border"
                                >
                            @else
                                <div class="w-20 h-14 flex items-center justify-center rounded-lg border bg-gray-100 text-gray-400 text-xs">
                                    No Image
                                </div>
                            @endif
                        </td>

                        <td class="p-3 font-medium text-gray-800">
                            {{ $lapangan->nama }}
                        </td>

                        <td class="p-3 text-gray-600">
                            {{ $lapangan->jenis ?: '-' }}
                        </td>

                        <td class="p-3 text-green-600 font-bold whitespace-nowrap">
                            Rp{{ number_format($lapangan->harga, 0, ',', '.') }}
                        </td>

                        <td class="p-3">
                            @php
                                $status = strtolower(trim($lapangan->status));
                            @endphp

                            @if($status == 'tersedia')
                                <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                    Tersedia
                                </span>
                            @elseif($status == 'perbaikan')
                                <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-700 font-medium">
                                    Perbaikan
                                </span>
                            @else
                                <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-medium">
                                    Tidak Tersedia
                                </span>
                            @endif
                        </td>

                        <td class="p-3">
                            <div class="flex flex-wrap gap-2">
                                <a href="{{ route('lapangan.edit', [$current_team, $lapangan->id]) }}"
                                   class="bg-yellow-500 text-white px-3 py-1 rounded text-xs hover:bg-yellow-600 transition">
                                    Edit
                                </a>

                                <button
                                    type="button"
                                    onclick="openDeleteModal('{{ route('lapangan.destroy', [$current_team, $lapangan->id]) }}')"
                                    class="bg-red-600 text-white px-3 py-1 rounded text-xs hover:bg-red-700 transition">
                                    Hapus
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-gray-500">
                            Belum ada data lapangan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-4">
    {{ $lapangans->links() }}
</div>

@endsection

