<?php

use App\Http\Controllers\Admin\MedicineController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\DashboardController;
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
| REDIRECT SETELAH LOGIN
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/redirect', [DashboardController::class, 'redirect'])
    ->name('redirect');

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

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->middleware('role:admin')
        ->name('admin.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'admin'])
                ->name('dashboard');

            /*
            | USER MANAGEMENT
            */

            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('/create', [UserController::class, 'create'])->name('create');
                Route::post('/', [UserController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
                Route::put('/{id}', [UserController::class, 'update'])->name('update');
                Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
            });

            /*
            | VENDOR MANAGEMENT
            */

            Route::prefix('vendors')->name('vendors.')->group(function () {
                Route::get('/', [VendorController::class, 'index'])->name('index');
                Route::get('/create', [VendorController::class, 'create'])->name('create');
                Route::post('/', [VendorController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [VendorController::class, 'edit'])->name('edit');
                Route::put('/{id}', [VendorController::class, 'update'])->name('update');
                Route::put('/{id}/nonaktif', [VendorController::class, 'nonaktif'])->name('nonaktif');
                Route::put('/{id}/aktifkan', [VendorController::class, 'aktifkan'])->name('aktifkan');
                Route::delete('/{id}', [VendorController::class, 'destroy'])->name('destroy');
            });

            /*
            | MASTER OBAT
            */

            Route::prefix('medicines')->name('medicines.')->group(function () {
                Route::get('/', [MedicineController::class, 'index'])->name('index');
                Route::get('/create', [MedicineController::class, 'create'])->name('create');
                Route::post('/', [MedicineController::class, 'store'])->name('store');
                Route::get('/{id}/edit', [MedicineController::class, 'edit'])->name('edit');
                Route::put('/{id}', [MedicineController::class, 'update'])->name('update');
                Route::delete('/{id}', [MedicineController::class, 'destroy'])->name('destroy');

                Route::get('/template/download', [MedicineController::class, 'downloadTemplate'])
                    ->name('template');

                Route::get('/upload', [MedicineController::class, 'uploadForm'])
                    ->name('upload.form');

                Route::post('/upload', [MedicineController::class, 'upload'])
                    ->name('upload');
            });
        });

    /*
    |--------------------------------------------------------------------------
    | FARMASI
    |--------------------------------------------------------------------------
    */

    Route::prefix('farmasi')
        ->middleware('role:farmasi')
        ->name('farmasi.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'farmasi'])
                ->name('dashboard');

            Route::get('/compare', [ComparePriceController::class, 'index'])
                ->name('compare.index');
                
            Route::get('/compare/export', [ComparePriceController::class, 'export'])
                    ->name('compare.export');
                    
            Route::get('/compare/{medicine}', [ComparePriceController::class, 'show'])
                ->name('compare.show');

        });

    /*
    |--------------------------------------------------------------------------
    | VENDOR
    |--------------------------------------------------------------------------
    */

    Route::prefix('vendor')
        ->middleware('role:vendor')
        ->name('vendor.')
        ->group(function () {

            Route::get('/dashboard', [DashboardController::class, 'vendor'])
                ->name('dashboard');

            Route::prefix('prices')->name('prices.')->group(function () {
                Route::get('/', [VendorPriceController::class, 'index'])->name('index');
                Route::get('/template', [VendorPriceController::class, 'downloadTemplate'])->name('template');
                Route::get('/upload', [VendorPriceController::class, 'uploadForm'])->name('upload.form');
                Route::post('/upload', [VendorPriceController::class, 'upload'])->name('upload');
                Route::delete('/{id}', [VendorPriceController::class, 'destroy'])->name('destroy');
            });
        });

});

require __DIR__.'/auth.php';
