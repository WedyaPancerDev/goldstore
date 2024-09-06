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

    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [DashboardController::class, 'indexAdmin'])->name('admin.root');
    });

    Route::middleware(['role:manajer'])->group(function () {
        Route::get('/manajer', [DashboardController::class, 'indexmanajer'])->name('manajer.root');
    });

    Route::middleware(['role:akuntan'])->group(function () {
        Route::get('/akuntan', [DashboardController::class, 'indexAkuntan'])->name('akuntan.root');
    });

    Route::middleware(['role:staff'])->group(function () {
        Route::get('/staff', [DashboardController::class, 'indexStaff'])->name('staff.root');
    });

   
});
