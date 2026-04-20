<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request, $current_team)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $status = $request->status;

        $bookings = Booking::with('lapangan')
            ->when($dari, function ($query) use ($dari) {
                $query->whereDate('tanggal', '>=', $dari);
            })
            ->when($sampai, function ($query) use ($sampai) {
                $query->whereDate('tanggal', '<=', $sampai);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $totalPendapatan = Booking::when($dari, function ($query) use ($dari) {
                $query->whereDate('tanggal', '>=', $dari);
            })
            ->when($sampai, function ($query) use ($sampai) {
                $query->whereDate('tanggal', '<=', $sampai);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->where('status', 'lunas')
            ->sum('total_harga');

        return view('admin.laporan.index', compact(
            'bookings',
            'totalPendapatan',
            'dari',
            'sampai',
            'status',
            'current_team'
        ));
    }

    public function pdf(Request $request, $current_team)
    {
        $dari = $request->dari;
        $sampai = $request->sampai;
        $status = $request->status;

        $bookings = Booking::with('lapangan')
            ->when($dari, function ($query) use ($dari) {
                $query->whereDate('tanggal', '>=', $dari);
            })
            ->when($sampai, function ($query) use ($sampai) {
                $query->whereDate('tanggal', '<=', $sampai);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->latest()
            ->get();

        $totalPendapatan = Booking::when($dari, function ($query) use ($dari) {
                $query->whereDate('tanggal', '>=', $dari);
            })
            ->when($sampai, function ($query) use ($sampai) {
                $query->whereDate('tanggal', '<=', $sampai);
            })
            ->when($status, function ($query) use ($status) {
                $query->where('status', $status);
            })
            ->where('status', 'lunas')
            ->sum('total_harga');

        $pdf = Pdf::loadView('admin.laporan.pdf', compact(
            'bookings',
            'totalPendapatan',
            'dari',
            'sampai',
            'status',
            'current_team'
        ))->setPaper('a4', 'portrait');

        return $pdf->stream('laporan-booking.pdf');
    }
}