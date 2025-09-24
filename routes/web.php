<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('verified')
        ->name('dashboard');

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
        Route::post('/avatar/update', [ProfileController::class, 'updateAvatar'])->name('avatar.update');
        Route::delete('/avatar/delete', [ProfileController::class, 'deleteAvatar'])->name('avatar.delete');
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::prefix('products')->group(function () {
        Route::get('/trash', [ProductController::class, 'trash'])->name('products.trash');

        Route::patch('/{product}/restore', [ProductController::class, 'restore'])->name('products.restore');
        Route::delete('/{product}/force-delete', [ProductController::class, 'forceDelete'])->name('products.force-delete');

        Route::delete('/mass-force-delete', [ProductController::class, 'massForceDelete'])->name('products.mass-force-delete');
        Route::patch('/mass-restore', [ProductController::class, 'massRestore'])->name('products.mass-restore');

        Route::get('/export-excel', [ProductController::class, 'exportExcel'])->name('products.exportExcel');
        Route::post('/import-excel', [ProductController::class, 'importExcel'])->name('products.importExcel');
    });

    Route::resources([
        'users'             => UserController::class,
        'suppliers'         => SupplierController::class,
        'products'          => ProductController::class,  
        'categories'        => CategoryController::class,
        'purchase_orders'   => PurchaseOrderController::class,
        'salesorders'       => SalesOrderController::class,
        'stockmovements'    => StockMovementController::class,
    ]);

    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    Route::get('/activity-logs/export', [ActivityLogController::class, 'export'])->name('activities.export');
});

require __DIR__.'/auth.php';