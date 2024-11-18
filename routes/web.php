<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\SumberController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

Route::get('login', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::get('register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('register', [RegisteredUserController::class, 'store']);

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('dashboard', function () {
    return view('welcome');
})->middleware('auth')->name('welcome');


//login route
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//auth route
Route::middleware(['auth'])->group(function () {
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi', [TransaksiController::class, 'transaksiPage'])->name('transaksi.index');
    
    Route::get('/', [TransaksiController::class, 'index'])->name('home');
    Route::get('/filter-by-blth', [TransaksiController::class, 'filterByBlt'])->name('filter.by.blth');
    Route::get('/download-pdf/{blth}', [TransaksiController::class, 'downloadPdf'])->name('download.pdf');
    Route::get('/download-excel/{blth}', [TransaksiController::class, 'downloadExcel'])->name('download.excel');
    Route::get('/transaksi/{transaksi}/edit', [TransaksiController::class, 'edit'])->name('transaksi.edit');
    Route::put('/transaksi/{transaksi}', [TransaksiController::class, 'update'])->name('transaksi.update');
    Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])->name('transaksi.destroy');
    Route::get('/get-sumber-by-blth', [TransaksiController::class, 'getSumberByBlth'])->name('getSumberByBlth');

    Route::get('/sumber', [SumberController::class, 'index'])->name('sumber.index'); // List sumber
    Route::get('/sumber/create', [SumberController::class, 'create'])->name('sumber.create'); // Show form to add sumber
    Route::post('/sumber', [SumberController::class, 'store'])->name('sumber.store'); // Store new sumber
    Route::get('/sumber/{id}/edit', [SumberController::class, 'edit'])->name('sumber.edit'); // Show form to edit sumber
    Route::put('/sumber/{id}', [SumberController::class, 'update'])->name('sumber.update'); // Update sumber
    Route::patch('/sumber/{id}/status', [SumberController::class, 'changeStatus'])->name('sumber.changeStatus'); // Change status
    Route::delete('/sumber/{id}', [SumberController::class, 'destroy'])->name('sumber.destroy'); // Delete sumber
    Route::get('/sumber/{sumber}', [SumberController::class, 'show'])->name('sumber.show');
});

