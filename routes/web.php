<?php

use App\Http\Controllers\AdminManagementController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Middleware\EnsureTeamMembership;
use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::view('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.login');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');
});

/*
|--------------------------------------------------------------------------
| Auth Routes (shared for user & admin)
|--------------------------------------------------------------------------
*/
Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {

    
        // Dashboard User
       Route::get('/dashboard', function ($current_team) {
    if (auth()->user()?->role === 'admin') {
        return redirect()->route('admin.dashboard', [
            'current_team' => $current_team,
        ]);
    }

    $myBookings = Booking::where('nama_pemesan', auth()->user()->name);

    $totalBookingSaya = (clone $myBookings)->count();
    $bookingPending = (clone $myBookings)->where('status', 'pending')->count();
    $bookingLunas = (clone $myBookings)->where('status', 'lunas')->count();
    $bookingSelesai = (clone $myBookings)->where('status', 'selesai')->count();

    $bookingTerbaru = Booking::with('lapangan')
        ->where('nama_pemesan', auth()->user()->name)
        ->latest()
        ->take(5)
        ->get();

    return view('user.dashboard', compact(
        'current_team',
        'totalBookingSaya',
        'bookingPending',
        'bookingLunas',
        'bookingSelesai',
        'bookingTerbaru'
    ));
})->name('dashboard');

        // 2FA
      Route::view('/security/otp', 'auth.two-factor-settings')->name('2fa.settings');

        // User lihat lapangan
        Route::get('/lapangan-user', [LapanganController::class, 'userIndex'])->name('user.lapangan.index');
        Route::get('/lapangan-user/{lapangan}', [LapanganController::class, 'userShow'])->name('user.lapangan.show');

        // Booking User
        Route::get('/booking-saya', [BookingController::class, 'userIndex'])->name('user.booking.index');
        Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
    });

/*
|--------------------------------------------------------------------------
| Admin Only Routes
|--------------------------------------------------------------------------
*/
Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class, 'admin'])
    ->group(function () {

        // Dashboard Admin
        Route::get('/admin', function ($current_team) {
            $totalUser = User::count();
            $totalLapangan = Lapangan::count();
            $totalBooking = Booking::count();
            $totalPendapatan = Booking::where('status', 'lunas')->sum('total_harga');

            $bookingHariIni = Booking::whereDate('tanggal', Carbon::today())->count();
            $bookingPending = Booking::where('status', 'pending')->count();

            $driver = DB::getDriverName();

            if ($driver === 'sqlite') {
                $bookingBulanan = Booking::selectRaw("strftime('%m', tanggal) as bulan, COUNT(*) as total")
                    ->whereYear('tanggal', Carbon::now()->year)
                    ->groupBy('bulan')
                    ->orderBy('bulan')
                    ->get();

                $pendapatanBulanan = Booking::selectRaw("strftime('%m', tanggal) as bulan, SUM(total_harga) as total")
                    ->where('status', 'lunas')
                    ->whereYear('tanggal', Carbon::now()->year)
                    ->groupBy('bulan')
                    ->orderBy('bulan')
                    ->get();
            } else {
                $bookingBulanan = Booking::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
                    ->whereYear('tanggal', Carbon::now()->year)
                    ->groupBy('bulan')
                    ->orderBy('bulan')
                    ->get();

                $pendapatanBulanan = Booking::selectRaw('MONTH(tanggal) as bulan, SUM(total_harga) as total')
                    ->where('status', 'lunas')
                    ->whereYear('tanggal', Carbon::now()->year)
                    ->groupBy('bulan')
                    ->orderBy('bulan')
                    ->get();
            }

            $namaBulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

            $bookingChartData = array_fill(0, 12, 0);
            $pendapatanChartData = array_fill(0, 12, 0);

            foreach ($bookingBulanan as $item) {
                $index = (int) $item->bulan - 1;
                if ($index >= 0 && $index < 12) {
                    $bookingChartData[$index] = (int) $item->total;
                }
            }

            foreach ($pendapatanBulanan as $item) {
                $index = (int) $item->bulan - 1;
                if ($index >= 0 && $index < 12) {
                    $pendapatanChartData[$index] = (int) $item->total;
                }
            }

            return view('admin.dashboard', compact(
                'totalUser',
                'totalLapangan',
                'totalBooking',
                'totalPendapatan',
                'bookingHariIni',
                'bookingPending',
                'bookingChartData',
                'pendapatanChartData',
                'namaBulan',
                'current_team'
            ));
        })->name('admin.dashboard');

        // Data User
        Route::get('/users', function (Request $request, $current_team) {
            $search = $request->search;

            $users = User::where('role', 'user')
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
                })
                ->latest()
                ->paginate(10)
                ->withQueryString();

            return view('admin.users.index', compact('users', 'current_team'));
        })->name('users.index');

        // Data Admin
        Route::get('/admins', [AdminManagementController::class, 'index'])->name('admins.index');
        Route::get('/admins/create', [AdminManagementController::class, 'create'])->name('admins.create');
        Route::post('/admins', [AdminManagementController::class, 'store'])->name('admins.store');

        // Update Role User
        Route::put('/users/{user}/role', function ($current_team, User $user) {
            $validated = request()->validate([
                'role' => 'required|in:user,admin',
            ]);

            if ($user->id === auth()->id()) {
                return back()->withErrors([
                    'role' => 'Tidak bisa mengubah role akun sendiri.',
                ]);
            }

            $user->update([
                'role' => $validated['role'],
            ]);

            return back()->with('success', 'Role berhasil diupdate');
        })->name('users.updateRole');

        // CRUD Lapangan
        Route::get('/lapangan', [LapanganController::class, 'index'])->name('lapangan.index');
        Route::get('/lapangan/create', [LapanganController::class, 'create'])->name('lapangan.create');
        Route::post('/lapangan', [LapanganController::class, 'store'])->name('lapangan.store');
        Route::get('/lapangan/{lapangan}/edit', [LapanganController::class, 'edit'])->name('lapangan.edit');
        Route::put('/lapangan/{lapangan}', [LapanganController::class, 'update'])->name('lapangan.update');
        Route::delete('/lapangan/{lapangan}', [LapanganController::class, 'destroy'])->name('lapangan.destroy');

        // Booking Admin
        Route::get('/admin/booking', [BookingController::class, 'adminIndex'])->name('admin.booking.index');
        Route::get('/admin/booking/{booking}/edit', [BookingController::class, 'edit'])->name('admin.booking.edit');
        Route::put('/admin/booking/{booking}', [BookingController::class, 'update'])->name('admin.booking.update');
        Route::delete('/admin/booking/{booking}', [BookingController::class, 'destroy'])->name('admin.booking.destroy');

        Route::get('/admin/validasi-booking', [BookingController::class, 'formValidasi'])->name('admin.booking.validasi.form');
        Route::post('/admin/validasi-booking', [BookingController::class, 'prosesValidasi'])->name('admin.booking.validasi.proses');

        Route::post('/admin/booking/{booking}/checkin', [BookingController::class, 'checkin'])->name('admin.booking.checkin');
        Route::put('/admin/booking/{booking}/status', [BookingController::class, 'updateStatus'])->name('admin.booking.updateStatus');
        Route::put('/admin/booking/{booking}/approve', [BookingController::class, 'approve'])->name('admin.booking.approve');
        Route::put('/admin/booking/{booking}/reject', [BookingController::class, 'reject'])->name('admin.booking.reject');

        // Kalender booking admin
        Route::get('/admin/kalender-booking', [BookingController::class, 'kalender'])->name('admin.booking.kalender');

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/pdf', [LaporanController::class, 'pdf'])->name('laporan.pdf');
    });

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout');

/*
|--------------------------------------------------------------------------
| Team Invitation
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::livewire('invitations/{invitation}/accept', 'pages::teams.accept-invitation')
        ->name('invitations.accept');
});



Route::get('/user/confirm-password', function () {
    return redirect()->route('dashboard');
});

require __DIR__ . '/settings.php';
Route::get('/fix-storage', function() {
    try {
        Artisan::call('storage:link');
        return "Storage link successfully created!";
    } catch (\Exception $e) {
        return $e->getMessage();
    }
});
