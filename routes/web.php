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
        };

        if (is_null($redirectRoute)) {
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses');
        }

        return redirect($redirectRoute);
    });

    Route::post('logout', [AuthenticatedController::class, 'destroy'])->name('logout');


    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'indexAdmin'])->name('admin.root');

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
            'destroy' => 'manajemen-pengguna.destroy',
        ]);

        Route::resource('kategori', KategoriController::class)->names([
            'index' => 'manajemen-kategori.index',
            'create' => 'manajemen-kategori.create',
            'store' => 'manajemen-kategori.store',
            'edit' => 'manajemen-kategori.edit',
            'update' => 'manajemen-kategori.update',
            'destroy' => 'manajemen-kategori.destroy',
        ]);

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
            'edit' => 'manajemen-target-penjualan.edit',
            'update' => 'manajemen-target-penjualan.update',
            'destroy' => 'manajemen-target-penjualan.destroy',
        ]);

        Route::resource('transaksi-pengeluaran', TransaksiPengeluaranController::class)->names([
            'index' => 'manajemen-transaksi-pengeluaran.index',
            'create' => 'manajemen-transaksi-pengeluaran.create',
            'store' => 'manajemen-transaksi-pengeluaran.store',
            'edit' => 'manajemen-transaksi-pengeluaran.edit',
            'update' => 'manajemen-transaksi-pengeluaran.update',
            'destroy' => 'manajemen-transaksi-pengeluaran.destroy',
        ]);
    });

    Route::middleware(['role:manajer'])->group(function () {
        Route::get('/manajer/dashboard', [DashboardController::class, 'indexManajer'])->name('manajer.root');
    });

    Route::middleware(['role:akuntan'])->group(function () {
        Route::get('/akuntan/dashboard', [DashboardController::class, 'indexAkuntan'])->name('akuntan.root');
    });

    Route::middleware(['role:staff'])->group(function () {
        Route::get('/staff/dashboard', [DashboardController::class, 'indexStaff'])->name('staff.root');

    });

});
