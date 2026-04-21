@extends('layouts.admin')

@section('title','Lapangan')
@section('page_heading','Database Lapangan')

@section('content')

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6 mb-8">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 bg-emerald-500/10 text-emerald-500 rounded-2xl flex items-center justify-center text-xl">🏟️</div>
        <div>
            <h2 class="text-xl font-black text-white tracking-tight uppercase tracking-widest">List Lapangan</h2>
            <p class="text-xs text-slate-500 font-bold uppercase tracking-widest mt-1">Total: {{ $lapangans->total() }} Arena</p>
        </div>
    </div>

    <a href="{{ route('lapangan.create', $current_team) }}"
       class="bg-emerald-500 hover:bg-emerald-400 text-slate-950 px-8 py-4 rounded-2xl font-black transition shadow-lg shadow-emerald-500/20 uppercase tracking-widest text-xs flex items-center gap-2">
        <span>+</span> Tambah Arena Baru
    </a>
</div>

<div class="glass-card rounded-[2.5rem] overflow-hidden border-white/5 shadow-2xl">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-white/5 text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] border-b border-white/5">
                    <th class="px-8 py-6 text-left">Visual</th>
                    <th class="px-8 py-6 text-left">Detail Arena</th>
                    <th class="px-8 py-6 text-left">Kategori</th>
                    <th class="px-8 py-6 text-left">Harga Sewa</th>
                    <th class="px-8 py-6 text-center">Status Operasional</th>
                    <th class="px-8 py-6 text-right">Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-white/5">
                @forelse($lapangans as $lapangan)
                    <tr class="hover:bg-white/5 transition duration-300 group">
                        <td class="px-8 py-6">
                            @if(!empty($lapangan->gambar))
                                <img
                                    src="{{ asset('uploads/' . $lapangan->gambar) }}"
                                    alt="{{ $lapangan->nama }}"
                                    class="w-24 h-16 object-cover rounded-2xl border border-white/10 group-hover:scale-105 transition-transform duration-500"
                                >
                            @else
                                <div class="w-24 h-16 flex items-center justify-center rounded-2xl border border-dashed border-white/10 bg-white/5 text-slate-500 text-[10px] font-black uppercase tracking-widest">
                                    No Image
                                </div>
                            @endif
                        </td>

                        <td class="px-8 py-6">
                            <p class="font-black text-white tracking-tight uppercase tracking-widest text-sm">{{ $lapangan->nama }}</p>
                            <p class="text-[10px] text-slate-500 font-bold uppercase mt-1">ID: #ARENA-{{ $lapangan->id }}</p>
                        </td>

                        <td class="px-8 py-6">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest bg-white/5 px-3 py-1.5 rounded-lg border border-white/5">
                                {{ $lapangan->jenis ?: 'REGULAR' }}
                            </span>
                        </td>

                        <td class="px-8 py-6">
                            <p class="font-black text-emerald-400 italic">Rp{{ number_format($lapangan->harga, 0, ',', '.') }}</p>
                            <p class="text-[9px] text-slate-500 font-bold uppercase mt-0.5">/ Pertandingan</p>
                        </td>

                        <td class="px-8 py-6 text-center">
                            @php $status = strtolower(trim($lapangan->status)); @endphp

                            @if($status == 'tersedia')
                                <span class="px-4 py-2 text-[9px] rounded-xl bg-emerald-500/10 text-emerald-400 font-black uppercase tracking-[0.2em] border border-emerald-500/20">
                                    Tersedia
                                </span>
                            @elseif($status == 'perbaikan')
                                <span class="px-4 py-2 text-[9px] rounded-xl bg-orange-500/10 text-orange-400 font-black uppercase tracking-[0.2em] border border-orange-500/20 text-center">
                                    Maintenance
                                </span>
                            @else
                                <span class="px-4 py-2 text-[9px] rounded-xl bg-red-500/10 text-red-400 font-black uppercase tracking-[0.2em] border border-red-500/20 text-center text-center">
                                    Closed
                                </span>
                            @endif
                        </td>

                        <td class="px-8 py-6 text-right">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('lapangan.edit', [$current_team, $lapangan->id]) }}"
                                   class="bg-white/5 hover:bg-white/10 text-slate-300 p-3 rounded-xl transition border border-white/5 group-hover:border-white/20">
                                    ⚙️
                                </a>

                                <button
                                    type="button"
                                    onclick="openDeleteModal('{{ route('lapangan.destroy', [$current_team, $lapangan->id]) }}')"
                                    class="bg-red-500/10 hover:bg-red-500 text-red-500 hover:text-white p-3 rounded-xl transition border border-red-500/20">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-8 py-24 text-center">
                            <div class="text-4xl mb-4 opacity-20">🏟️</div>
                            <p class="text-sm font-black text-slate-500 uppercase tracking-[0.2em]">Belum ada arena futsal yang terdaftar.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-8">
    {{ $lapangans->links() }}
</div>

</div>

@push('modals')
<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-[9999] hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity bg-slate-950/80 backdrop-blur-sm" onclick="closeDeleteModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
        
        <div class="inline-block align-bottom glass-card rounded-[2.5rem] text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border-white/10">
            <div class="p-10">
                <div class="flex flex-col items-center text-center">
                    <div class="w-20 h-20 bg-red-500/10 rounded-full flex items-center justify-center text-3xl mb-6 border border-red-500/20 animate-pulse">
                        ⚠️
                    </div>
                    <h3 class="text-2xl font-black text-white uppercase italic tracking-tighter mb-2">Hapus Arena?</h3>
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-[10px] leading-relaxed">Tindakan ini tidak dapat dibatalkan. Seluruh data lapangan akan terhapus permanen.</p>
                </div>
            </div>
            <div class="px-10 py-8 bg-white/5 flex gap-4">
                <button onclick="closeDeleteModal()" class="flex-1 bg-white/5 hover:bg-white/10 text-white font-black py-4 rounded-2xl uppercase tracking-widest text-[10px] transition-all">
                    Batal
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-500 text-white font-black py-4 rounded-2xl uppercase tracking-widest text-[10px] transition-all italic shadow-lg shadow-red-600/20">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
    function openDeleteModal(url) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endpush
@endsection
