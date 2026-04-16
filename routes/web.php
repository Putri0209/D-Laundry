<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransLaundryPickupController;
use App\Http\Controllers\TypeOfServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// ================= LOGIN =================
Route::get('/', [LoginController::class, 'index']);
Route::post('action-login', [LoginController::class, 'actionLogin'])->name('action-login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


// admin
Route::middleware(['level:administrator'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::resource('user', UserController::class);
    Route::resource('level', LevelController::class);
    Route::resource('customer', CustomerController::class);
    Route::resource('service', TypeOfServiceController::class);
    Route::resource('transaction', TransactionController::class);

    Route::post('/transaction/{id}/update-status', [TransactionController::class, 'updateStatus'])
        ->name('transaction.updateStatus');
        Route::post('/transaction/{id}/pay', [TransactionController::class, 'pay'])
    ->name('transaction.pay');
          Route::get('pickup', [TransLaundryPickupController::class, 'index'])->name('pickup.index');
          Route::get('pickup/{id}', [TransLaundryPickupController::class, 'show'])->name('pickup.show');
          Route::post('/pickup/{id}/update-status', [TransLaundryPickupController::class, 'updateStatus'])
        ->name('pickup.updateStatus');
});


// operator
Route::middleware(['level:operator'])->group(function () {

    Route::resource('customer', CustomerController::class);
    Route::resource('transaction', TransactionController::class);

    Route::post('/transaction/{id}/update-status', [TransactionController::class, 'updateStatus'])
        ->name('transaction.updateStatus');
        Route::post('/transaction/{id}/pay', [TransactionController::class, 'pay'])
    ->name('transaction.pay');
    Route::post('/pickup/{id}/update-status', [TransLaundryPickupController::class, 'updateStatus'])
        ->name('pickup.updateStatus');
          Route::get('pickup', [TransLaundryPickupController::class, 'index'])->name('pickup.index');
          Route::get('pickup/{id}', [TransLaundryPickupController::class, 'show'])->name('pickup.show');
});


// pimpinan
Route::middleware(['level:pimpinan'])->group(function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/pdf', [ReportController::class, 'exportPdf'])->name('report.pdf');
});
