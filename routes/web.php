<?php

use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Farmasi\ComparePriceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VendorPriceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| REDIRECT SETELAH LOGIN BERDASARKAN ROLE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/redirect', function () {

    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->hasRole('farmasi')) {
        return redirect()->route('farmasi.dashboard');
    }

    if (auth()->user()->hasRole('vendor')) {
        return redirect()->route('vendor.dashboard');
    }

    if (auth()->user()->hasRole('manajemen')) {
        return redirect()->route('manajemen.dashboard');
    }

});

/*
|--------------------------------------------------------------------------
| SEMUA ROUTE YANG PERLU LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | PROFILE
    |--------------------------------------------------------------------------
    */

    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->middleware('role:admin')
        ->name('admin.')
        ->group(function () {

            Route::view('/dashboard', 'admin.dashboard')
                ->name('dashboard');

            /*
            |--------------------------------------------------------------------------
            | USER MANAGEMENT
            |--------------------------------------------------------------------------
            */

            Route::prefix('users')->name('users.')->group(function () {

                Route::get('/', [UserController::class, 'index'])
                    ->name('index');

                Route::get('/create', [UserController::class, 'create'])
                    ->name('create');

                Route::post('/', [UserController::class, 'store'])
                    ->name('store');

                Route::get('/{id}/edit', [UserController::class, 'edit'])
                    ->name('edit');

                Route::put('/{id}', [UserController::class, 'update'])
                    ->name('update');

                Route::delete('/{user}', [UserController::class, 'destroy'])
                    ->name('destroy');
            });

            /*
            |--------------------------------------------------------------------------
            | VENDOR MANAGEMENT
            |--------------------------------------------------------------------------
            */

            Route::prefix('vendors')->name('vendors.')->group(function () {

                Route::get('/', [VendorController::class, 'index'])
                    ->name('index');

                Route::get('/create', [VendorController::class, 'create'])
                    ->name('create');

                Route::post('/', [VendorController::class, 'store'])
                    ->name('store');

                Route::get('/{id}/edit', [VendorController::class, 'edit'])
                    ->name('edit');

                Route::put('/{id}', [VendorController::class, 'update'])
                    ->name('update');

                Route::put('/{id}/nonaktif', [VendorController::class, 'nonaktif'])
                    ->name('nonaktif');

                Route::put('/{id}/aktifkan', [VendorController::class, 'aktifkan'])
                    ->name('aktifkan');
                Route::delete('/{id}', [VendorController::class, 'destroy'])
                    ->name('destroy');
            });

            /*
            |--------------------------------------------------------------------------
            | MASTER OBAT (sementara view dulu)
            |--------------------------------------------------------------------------
            */

            Route::prefix('medicines')->name('medicines.')->group(function () {

                Route::get('/', [MedicineController::class, 'index'])
                    ->name('index');

                Route::get('/create', [MedicineController::class, 'create'])
                    ->name('create');

                Route::post('/', [MedicineController::class, 'store'])
                    ->name('store');

                Route::get('/{id}/edit', [MedicineController::class, 'edit'])
                    ->name('edit');

                Route::put('/{id}', [MedicineController::class, 'update'])
                    ->name('update');

                Route::delete('/{id}', [MedicineController::class, 'destroy'])
                    ->name('destroy');

                Route::get('/template/download', [MedicineController::class, 'downloadTemplate'])
                    ->name('template');

                // upload
                Route::get('/upload', [MedicineController::class, 'uploadForm'])
                    ->name('upload.form');

                Route::post('/upload', [MedicineController::class, 'upload'])
                    ->name('upload');
            });

        });

    /*
    |--------------------------------------------------------------------------
    | FARMASI ROUTES
    |--------------------------------------------------------------------------
    */

    Route::prefix('farmasi')
        ->middleware(['auth', 'role:farmasi'])
        ->name('farmasi.')
        ->group(function () {

            Route::view('/dashboard', 'farmasi.dashboard')
                ->name('dashboard');

            Route::get('/compare', [ComparePriceController::class, 'index'])
                ->name('compare.index');

            Route::get('/compare/{medicine}', [ComparePriceController::class, 'show'])
                ->name('compare.show');
        });

    /*
|--------------------------------------------------------------------------
| VENDOR PANEL
|--------------------------------------------------------------------------
*/

    Route::prefix('vendor')
        ->middleware(['auth', 'role:vendor'])
        ->name('vendor.')
        ->group(function () {

            /*
            |--------------------------------------------------------------------------
            | DASHBOARD
            |--------------------------------------------------------------------------
            */

            Route::view('/dashboard', 'vendor.dashboard')
                ->name('dashboard');

            /*
            |--------------------------------------------------------------------------
            | HARGA OBAT
            |--------------------------------------------------------------------------
            */

            Route::prefix('prices')->name('prices.')->group(function () {

                // list harga vendor sendiri
                Route::get('/', [VendorPriceController::class, 'index'])
                    ->name('index');

                // download template (auto generate semua obat aktif)
                Route::get('/template', [VendorPriceController::class, 'downloadTemplate'])
                    ->name('template');

                // upload form (optional kalau mau halaman khusus)
                Route::get('/upload', [VendorPriceController::class, 'uploadForm'])
                    ->name('upload.form');

                // proses upload
                Route::post('/upload', [VendorPriceController::class, 'upload'])
                    ->name('upload');

                // hapus harga (opsional)
                Route::delete('/{id}', [VendorPriceController::class, 'destroy'])
                    ->name('destroy');
            });

        });

});

require __DIR__.'/auth.php';
