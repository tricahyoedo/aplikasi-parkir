<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group Admin
Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        $totalUser = App\Models\User::count();
        $totalArea = App\Models\AreaParkir::count();
        $totalKendaraan = App\Models\Kendaraan::count();
        $totalLog = App\Models\LogAktivitas::count();
        return view('admin.dashboard', compact('totalUser', 'totalArea', 'totalKendaraan', 'totalLog'));
    })->name('dashboard');
    Route::resource('user', App\Http\Controllers\Admin\UserController::class)->except(['create', 'edit', 'show']);
    Route::resource('tarif', App\Http\Controllers\Admin\TarifController::class)->except(['create', 'edit', 'show']);
    
    Route::resource('area', App\Http\Controllers\Admin\AreaParkirController::class)->except(['create', 'edit', 'show']);
    Route::resource('kendaraan', App\Http\Controllers\Admin\KendaraanController::class)->except(['create', 'edit', 'show']);
    Route::get('/log', [App\Http\Controllers\Admin\LogAktivitasController::class, 'index'])->name('log.index');
});

// Group Petugas
Route::middleware(['role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', function () { 
        $kendaraanMasuk = App\Models\Transaksi::whereDate('waktu_masuk', now()->toDateString())->count();
        $transaksiSelesai = App\Models\Transaksi::whereNotNull('waktu_keluar')->whereDate('waktu_keluar', now()->toDateString())->count();
        return view('petugas.dashboard', compact('kendaraanMasuk', 'transaksiSelesai')); 
    })->name('dashboard');
    Route::get('/transaksi', [App\Http\Controllers\Petugas\TransaksiController::class, 'index'])->name('transaksi.index');
    Route::post('/transaksi/masuk', [App\Http\Controllers\Petugas\TransaksiController::class, 'masuk'])->name('transaksi.masuk');
    Route::post('/transaksi/{id_parkir}/keluar', [App\Http\Controllers\Petugas\TransaksiController::class, 'keluar'])->name('transaksi.keluar');
});

// Group Owner
Route::middleware(['role:owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', function () { 
        $totalPendapatan = App\Models\Transaksi::whereMonth('waktu_keluar', now()->month)
                                               ->whereYear('waktu_keluar', now()->year)
                                               ->sum('biaya_total');
        return view('owner.dashboard', compact('totalPendapatan')); 
    })->name('dashboard');
    Route::get('/rekap', function (Illuminate\Http\Request $request) {
        $query = App\Models\Transaksi::with(['kendaraan', 'areaParkir'])->whereNotNull('waktu_keluar');
        
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereDate('waktu_keluar', '>=', $request->start_date)
                  ->whereDate('waktu_keluar', '<=', $request->end_date);
        } else {
            // Default: tampilkan bulan ini jika tidak ada filter
            $query->whereMonth('waktu_keluar', now()->month)->whereYear('waktu_keluar', now()->year);
        }
        
        $transaksis = $query->orderByDesc('waktu_keluar')->get();
        $totalPendapatan = $transaksis->sum('biaya_total');
        
        return view('owner.rekap', compact('transaksis', 'totalPendapatan'));
    })->name('rekap.index');
});
