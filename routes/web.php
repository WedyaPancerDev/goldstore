<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\DashboardController;

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthenticatedController::class, 'index'])->name('ui.login');
    Route::post('/login', [AuthenticatedController::class, 'store'])->name('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        $user = auth()->user();

        $redirectRoute = match ($user->role) {
            'admin' => route('admin.root'),
            'manajer' => route('manajer.root'),
            'akuntan' => route('akuntan.root'),
            'staff' => route('staff.root'),
            default => null,
        };

        if (is_null($redirectRoute)) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses');
        }

        return redirect($redirectRoute);
    });

    Route::post('logout', [AuthenticatedController::class, 'destroy'])->name('logout');


    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [DashboardController::class, 'indexAdmin'])->name('admin.root');

        // pengguna
        Route::get("/admin/pengguna", [DashboardController::class,""])->name("admin.manajement-pengguna.index");
        // produk
        Route::get('/admin/produk', [DashboardController::class,''])->name('admin.manajement-produk.index');

        // kategori
        Route::get('/admin/kategori', [DashboardController::class,''])->name("admin.manajement-kategori.index");

        // master bonus
        Route::get("/admin/master-bonus", [DashboardController::class,""])->name("admin.manajemen-master-bonus.index");

        // asign bonnus
        Route::get("/admin/asign-bonus", [DashboardController::class,""])->name("admin.manajement-asign-bonus.index");

        // penjualan
        Route::get("/admin/penjualan", [DashboardController::class,""])->name("admin.manajement-penjualan.index");

        // transaksi pengeluaran
        Route::get("/admin/transaksi-pengeluaran", [DashboardController::class,""])->name("admin.manajement-asign-bonus.index");

        
    });

    Route::middleware(['role:manajer'])->group(function () {
        Route::get('/manajer', [DashboardController::class, 'indexmanajer'])->name('manajer.root');

          // pengguna
          Route::get("/manajement/pengguna", [DashboardController::class,""])->name("manajement.manajement-pengguna.index");
          // produk
          Route::get('/manajement/produk', [DashboardController::class,''])->name('manajement.manajement-produk.index');
  
          // kategori
          Route::get('/manajement/kategori', [DashboardController::class,''])->name("manajement.manajement-kategori.index");
  
          // master bonus
          Route::get("/manajement/master-bonus", [DashboardController::class,""])->name("manajement.manajemen-master-bonus.index");
  
          // asign bonnus
          Route::get("/manajement/asign-bonus", [DashboardController::class,""])->name("manajement.manajement-asign-bonus.index");
  
          // penjualan
          Route::get("/manajement/penjualan", [DashboardController::class,""])->name("manajement.manajement-penjualan.index");
  
          // transaksi pengeluaran
          Route::get("/manajement/transaksi-pengeluaran", [DashboardController::class,""])->name("manajement.manajement-asign-bonus.index");
    });

    Route::middleware(['role:akuntan'])->group(function () {
        Route::get('/akuntan', [DashboardController::class, 'indexAkuntan'])->name('akuntan.root');

          // pengguna
          Route::get("/akuntan/pengguna", [DashboardController::class,""])->name("akuntan.manajement-pengguna.index");
          // produk
          Route::get('/akuntan/produk', [DashboardController::class,''])->name('akuntan.manajement-produk.index');
  
          // kategori
          Route::get('/akuntan/kategori', [DashboardController::class,''])->name("akuntan.manajement-kategori.index");
  
          // master bonus
          Route::get("/akuntan/master-bonus", [DashboardController::class,""])->name("akuntan.manajemen-master-bonus.index");
  
          // asign bonnus
          Route::get("/akuntan/asign-bonus", [DashboardController::class,""])->name("akuntan.manajement-asign-bonus.index");
  
          // penjualan
          Route::get("/akuntan/penjualan", [DashboardController::class,""])->name("akuntan.manajement-penjualan.index");
  
          // transaksi pengeluaran
          Route::get("/akuntan/transaksi-pengeluaran", [DashboardController::class,""])->name("akuntan.manajement-asign-bonus.index");
    });

    Route::middleware(['role:staff'])->group(function () {
        Route::get('/staff', [DashboardController::class, 'indexStaff'])->name('staff.root');

          // pengguna
          Route::get("/staff/pengguna", [DashboardController::class,""])->name("staff.manajement-pengguna.index");
         
          // master bonus
          Route::get("/staff/master-bonus", [DashboardController::class,""])->name("staff.manajemen-master-bonus.index");
  
          // asign bonnus
          Route::get("/staff/asign-bonus", [DashboardController::class,""])->name("staff.manajement-asign-bonus.index");
  
          // penjualan
          Route::get("/staff/penjualan", [DashboardController::class,""])->name("staff.manajement-penjualan.index");
  
          // transaksi pengeluaran
          Route::get("/staff/transaksi-pengeluaran", [DashboardController::class,""])->name("staff.manajement-asign-bonus.index");
    });

   
});
