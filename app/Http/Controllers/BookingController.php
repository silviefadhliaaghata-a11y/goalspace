<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Lapangan;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str; 

class BookingController extends Controller
{
   public function userIndex(Request $request, $current_team)
{
    $search = $request->search;

    $bookings = Booking::with('lapangan')
        ->where('nama_pemesan', auth()->user()->name)
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('tanggal', 'like', '%' . $search . '%')
                    ->orWhereHas('lapangan', function ($lapanganQuery) use ($search) {
                        $lapanganQuery->where('nama', 'like', '%' . $search . '%');
                    });
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('user.booking.index', compact('bookings', 'current_team'));
}

public function adminIndex(Request $request, $current_team)
{
    if (auth()->user()?->role !== 'admin') {
        abort(403, 'Akses ditolak!');
    }

    $search = $request->search;

    $bookings = Booking::with('lapangan')
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_pemesan', 'like', '%' . $search . '%')
                    ->orWhere('tanggal', 'like', '%' . $search . '%')
                    ->orWhereHas('lapangan', function ($lapanganQuery) use ($search) {
                        $lapanganQuery->where('nama', 'like', '%' . $search . '%');
                    });
            });
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('admin.booking.index', compact('bookings', 'current_team'));
}

    public function create(Request $request, $current_team)
{
    $lapangans = Lapangan::orderBy('nama')->get();

    $selectedLapangan = null;

    if ($request->filled('lapangan_id')) {
        $selectedLapangan = Lapangan::find($request->lapangan_id);
    }

    return view('booking.create', compact('lapangans', 'selectedLapangan', 'current_team'));
}

    public function store(Request $request, $current_team)
    {
        $messages = [
    'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
    'metode_pembayaran.required' => 'Metode pembayaran wajib dipilih.',
    'bukti_pembayaran.required' => 'Bukti pembayaran wajib diupload.',
];

        $validated = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'nama_pemesan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'metode_pembayaran' => 'required|in:Transfer Bank,QRIS,Tunai',
            'catatan_pembayaran' => 'nullable|string',
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], $messages);

        // Jika status tidak dikirim (oleh user), default ke 'pending'
        $validated['status'] = $request->status ?? 'pending';

        $bentrok = Booking::where('lapangan_id', $validated['lapangan_id'])
            ->where('tanggal', $validated['tanggal'])
            ->where(function ($query) use ($validated) {
                $query->where('jam_mulai', '<', $validated['jam_selesai'])
                    ->where('jam_selesai', '>', $validated['jam_mulai']);
            })
            ->exists();

        if ($bentrok) {
            return back()
                ->withErrors(['jam_mulai' => 'Jadwal bentrok dengan booking lain.'])
                ->withInput();
        }

        $lapangan = Lapangan::findOrFail($validated['lapangan_id']);

        $mulai = Carbon::parse($validated['jam_mulai']);
        $selesai = Carbon::parse($validated['jam_selesai']);

        $durasiJam = max(0, $mulai->diffInMinutes($selesai) / 60);
        $validated['total_harga'] = (int) round($durasiJam * $lapangan->harga);

        if ($request->hasFile('bukti_pembayaran')) {
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $targetFolder = (file_exists(base_path('public_html')) ? base_path('public_html/uploads/bukti-pembayaran') : public_path('uploads/bukti-pembayaran'));
            
            if (!file_exists($targetFolder)) {
                mkdir($targetFolder, 0777, true);
            }
            
            $file->move($targetFolder, $filename);
            $validated['bukti_pembayaran'] = 'bukti-pembayaran/' . $filename;
        }

        $validated['kode_booking'] = 'BOOK-' . now()->format('YmdHis') . '-' . strtoupper(Str::random(4));

        $booking = Booking::create($validated);

        return redirect()
            ->route('user.booking.index', $current_team)
            ->with('success', 'Booking berhasil ditambahkan.');
    }

    public function edit($current_team, Booking $booking)
    {
        $lapangans = Lapangan::orderBy('nama')->get();

        return view('admin.booking.edit', compact('booking', 'lapangans', 'current_team'));
    }

    public function update(Request $request, $current_team, Booking $booking)
    {
        $messages = [
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
        ];

        $validated = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'nama_pemesan' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'status' => 'required|in:pending,lunas,selesai,batal',
            'metode_pembayaran' => 'nullable|string|max:100',
            'catatan_pembayaran' => 'nullable|string',
            'bukti_pembayaran' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], $messages);

        $bentrok = Booking::where('lapangan_id', $validated['lapangan_id'])
            ->where('tanggal', $validated['tanggal'])
            ->where('id', '!=', $booking->id)
            ->where(function ($query) use ($validated) {
                $query->where('jam_mulai', '<', $validated['jam_selesai'])
                    ->where('jam_selesai', '>', $validated['jam_mulai']);
            })
            ->exists();

        if ($bentrok) {
            return back()
                ->withErrors(['jam_mulai' => 'Jadwal bentrok dengan booking lain.'])
                ->withInput();
        }

        $lapangan = Lapangan::findOrFail($validated['lapangan_id']);

        $mulai = Carbon::parse($validated['jam_mulai']);
        $selesai = Carbon::parse($validated['jam_selesai']);

        $durasiJam = max(0, $mulai->diffInMinutes($selesai) / 60);
        $validated['total_harga'] = (int) round($durasiJam * $lapangan->harga);

        if ($request->hasFile('bukti_pembayaran')) {
            if ($booking->bukti_pembayaran && Storage::disk('public')->exists($booking->bukti_pembayaran)) {
                Storage::disk('public')->delete($booking->bukti_pembayaran);
            }

            $validated['bukti_pembayaran'] = $request->file('bukti_pembayaran')
                ->store('bukti-pembayaran', 'public');
        }

        $booking->update($validated);

        return redirect()
            ->route('admin.booking.index', $current_team)
            ->with('success', 'Booking berhasil diupdate.');
    }

    public function destroy($current_team, Booking $booking)
    {
        if ($booking->bukti_pembayaran && Storage::disk('public')->exists($booking->bukti_pembayaran)) {
            Storage::disk('public')->delete($booking->bukti_pembayaran);
        }

        $booking->delete();

        return redirect()
            ->route('admin.booking.index', $current_team)
            ->with('success', 'Booking berhasil dihapus.');
    }

    public function laporan(Request $request, $current_team)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $status = $request->status;

        $query = Booking::with('lapangan');

        if ($dari && $sampai) {
            $query->whereBetween('tanggal', [$dari, $sampai]);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->latest()->paginate(10)->withQueryString();

        $laporanQuery = Booking::query();

        if ($dari && $sampai) {
            $laporanQuery->whereBetween('tanggal', [$dari, $sampai]);
        }

        if ($status) {
            $laporanQuery->where('status', $status);
        }

        $totalPendapatan = $laporanQuery->where('status', 'lunas')->sum('total_harga');

        return view('admin.laporan.index', compact(
            'bookings',
            'totalPendapatan',
            'current_team',
            'dari',
            'sampai',
            'status'
        ));
    }

    public function exportPdf(Request $request, $current_team)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $status = $request->status;

        $query = Booking::with('lapangan');

        if ($dari && $sampai) {
            $query->whereBetween('tanggal', [$dari, $sampai]);
        }

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->latest()->get();

        $laporanQuery = Booking::query();

        if ($dari && $sampai) {
            $laporanQuery->whereBetween('tanggal', [$dari, $sampai]);
        }

        if ($status) {
            $laporanQuery->where('status', $status);
        }

        $totalPendapatan = $laporanQuery->where('status', 'lunas')->sum('total_harga');

        $pdf = Pdf::loadView('admin.laporan.pdf', compact(
            'bookings',
            'totalPendapatan',
            'dari',
            'sampai',
            'status'
        ));

        return $pdf->download('laporan-booking.pdf');
    }

    public function updateStatus(Request $request, $current_team, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,lunas,selesai,batal'
        ]);

        $booking->update([
            'status' => $request->status
        ]);

        return back()->with('success', 'Status booking berhasil diupdate.');
    }

    public function kalender(Request $request, $current_team)
    {
        $tanggal = $request->tanggal ?? now()->toDateString();

        $lapangans = Lapangan::orderBy('nama')->get();

        $bookings = Booking::whereDate('tanggal', $tanggal)
            ->get()
            ->groupBy('lapangan_id');

        return view('admin.booking.kalender', compact(
            'lapangans',
            'bookings',
            'tanggal',
            'current_team'
        ));
    }

    public function approve($current_team, Booking $booking)
    {
        $booking->update([
            'status' => 'lunas'
        ]);

        return back()->with('success', 'Pembayaran berhasil di-approve.');
    }

    public function reject($current_team, Booking $booking)
    {
        $booking->update([
            'status' => 'batal'
        ]);

        return back()->with('success', 'Pembayaran ditolak.');
    }
 public function formValidasi(Request $request, $current_team)
{
    if (auth()->user()?->role !== 'admin') {
        abort(403, 'Akses ditolak!');
    }

    $booking = null;

    if ($request->filled('kode')) {
        $booking = Booking::with('lapangan')
            ->where('kode_booking', $request->kode)
            ->first();
    }

    return view('admin.booking.validasi', compact('booking', 'current_team'));
}

public function prosesValidasi(Request $request, $current_team)
{
    if (auth()->user()?->role !== 'admin') {
        abort(403, 'Akses ditolak!');
    }

    $request->validate([
        'kode_booking' => 'required'
    ]);

    $booking = Booking::with('lapangan')
        ->where('kode_booking', $request->kode_booking)
        ->first();

    if (! $booking) {
        return back()->with('error', 'Kode booking tidak ditemukan.');
    }

    return view('admin.booking.validasi', compact('booking', 'current_team'));
}

public function checkin($current_team, Booking $booking)
{
    if (auth()->user()?->role !== 'admin') {
        abort(403, 'Akses ditolak!');
    }

    $booking->update([
        'checked_in_at' => now(),
        'status' => 'selesai',
    ]);

    return redirect()
        ->route('admin.booking.validasi.form', $current_team)
        ->with('success', 'Booking berhasil divalidasi.');
}   
}