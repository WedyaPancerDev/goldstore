<?php

use App\Http\Controllers\AssignBonusController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MasterBonusController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\TargetPenjualanController;
use App\Http\Controllers\TransaksiPengeluaranController;
use App\Models\AssignBonus;
use App\Models\MasterBonus;
use Illuminate\Support\Facades\Auth;

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
            default => null
        };

        if (is_null($redirectRoute)) {
            Auth::logout();

            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses');
        }

        return redirect($redirectRoute);
    });

    Route::post('logout', [AuthenticatedController::class, 'destroy'])->name('logout');


    Route::middleware(['role:admin|akuntan|manajer|staff'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'indexAdmin'])->name('admin.root');
        Route::get('/staff-chart-data', [DashboardController::class, 'getStaffChartData'])->name('staff.chart.data');

        Route::resource('produk', ProdukController::class)->names([
            'index' => 'manajemen-produk.index',
            'create' => 'manajemen-produk.create',
            'store' => 'manajemen-produk.store',
            'edit' => 'manajemen-produk.edit',
            'update' => 'manajemen-produk.update',
            'destroy' => 'manajemen-produk.destroy',
        ]);


        Route::resource('pengguna', PenggunaController::class)->names([
            'index' => 'manajemen-pengguna.index',
            'store' => 'manajemen-pengguna.store',
            'edit' => 'manajemen-pengguna.edit',
            'update' => 'manajemen-pengguna.update',
        ]);

        Route::delete("/admin/manajemen-pengguna/{id}/delete", [PenggunaController::class, 'destroy'])->name("admin.manajemen-pengguna.destroy");
        Route::patch("/admin/manajemen-pengguna/{id}/restore", [PenggunaController::class, 'restore'])->name("admin.manajemen-pengguna.restore");

        Route::resource('kategori', KategoriController::class)->names([
            'index' => 'manajemen-kategori.index',
            'create' => 'manajemen-kategori.create',
            'store' => 'manajemen-kategori.store',
            'edit' => 'manajemen-kategori.edit',
            'update' => 'manajemen-kategori.update',
            'destroy' => 'manajemen-kategori.destroy',
        ]);

        Route::put('manajemen-kategori/restore/{id}', [KategoriController::class, 'restore'])->name('manajemen-kategori.restore');


        Route::resource('master-bonus', MasterBonusController::class)->names([
            'index' => 'manajemen-master-bonus.index',
            'create' => 'manajemen-master-bonus.create',
            'store' => 'manajemen-master-bonus.store',
            'edit' => 'manajemen-master-bonus.edit',
            'update' => 'manajemen-master-bonus.update',
            'destroy' => 'manajemen-master-bonus.destroy',
        ]);

        Route::resource('assign-bonus', AssignBonusController::class)->names([
            'index' => 'manajemen-assign-bonus.index',
            'create' => 'manajemen-assign-bonus.create',
            'store' => 'manajemen-assign-bonus.store',
            'edit' => 'manajemen-assign-bonus.edit',
            'update' => 'manajemen-assign-bonus.update',
            'destroy' => 'manajemen-assign-bonus.destroy',
        ]);

        Route::resource('target-penjualan', TargetPenjualanController::class)->names([
            'index' => 'manajemen-target-penjualan.index',
            'create' => 'manajemen-target-penjualan.create',
            'store' => 'manajemen-target-penjualan.store',

        ]);

        Route::get('/get-total-by-month', [TargetPenjualanController::class, 'getTotalByMonth'])->name('getTotalByMonth');
        Route::get('/laporan/penjualan/pdf', [TargetPenjualanController::class, 'exportMonthlyPDF'])->name('exportMonthlyPDF');
        Route::get('/export-yearly-target-penjualan', [TargetPenjualanController::class, 'exportYearlyPDF'])->name('exportYearlyTargetPenjualan');
        Route::get('/export-monthly-excel', [TargetPenjualanController::class, 'exportMonthlyExcel'])->name('export.monthly.excel');
        Route::get('/export-yearly-excel', [TargetPenjualanController::class, 'exportYearlyExcel'])->name('export.yearly.excel');



        Route::delete('manajemen-target-penjualan/{id}', [TargetPenjualanController::class, 'destroy'])->name('manajemen-target-penjualan.destroy');
        Route::patch('manajemen-target-penjualan/{id}/restore', [TargetPenjualanController::class, 'restore'])->name('manajemen-target-penjualan.restore');
        Route::get('manajemen-target-penjualan/detail/{userId}', [TargetPenjualanController::class, 'detail'])->name('manajemen-target-penjualan.detail');
        Route::get('manajemen-target-penjualan/details/{userId}', [TargetPenjualanController::class, 'details'])->name('manajemen-target-penjualan.details');
        Route::get('manajemen-target-penjualan/edit/{userId}', [TargetPenjualanController::class, 'edit'])->name('manajemen-target-penjualan.edit');
        Route::get('manajemen-target-penjualan/edits/{userId}', [TargetPenjualanController::class, 'edits'])->name('manajemen-target-penjualan.edits');
        Route::patch('manajemen-target-penjualan/update/{userId}', [TargetPenjualanController::class, 'update'])->name('manajemen-target-penjualan.update');



        Route::resource('transaksi-pengeluaran', TransaksiPengeluaranController::class)->names([
            'index' => 'manajemen-transaksi-pengeluaran.index',
            'create' => 'manajemen-transaksi-pengeluaran.create',
            'store' => 'manajemen-transaksi-pengeluaran.store',
            'edit' => 'manajemen-transaksi-pengeluaran.edit',
            'update' => 'manajemen-transaksi-pengeluaran.update',
            'destroy' => 'manajemen-transaksi-pengeluaran.destroy',
        ]);

        Route::get('/check-stock', [TransaksiPengeluaranController::class, 'checkStock'])->name('check-stock');
    });


    Route::middleware(['role:akuntan'])->group(function () {
        Route::get('/akuntan/dashboard', [DashboardController::class, 'indexAkuntan'])->name('akuntan.root');
        Route::get('/getAllTransaksiandTarget', [DashboardController::class, 'getAllTransaksiandTarget'])->name('getAllTransaksiandTarget');
    });

    Route::middleware(['role:manajer'])->group(function () {
        Route::get('/manajer/dashboard', [DashboardController::class, 'indexManajer'])->name('manajer.root');
    });

    Route::middleware(['role:staff'])->group(function () {
        Route::get('/staff/dashboard', [DashboardController::class, 'indexStaff'])->name('staff.root');
        Route::get('/getTargetAndTransaksi', [DashboardController::class, 'getTargetAndTransaksi'])->name('getTargetAndTransaksi');
    });
});
