<?php


use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransOrderController;
use App\Http\Controllers\TypeOfServiceController;
use App\Http\Controllers\UserController;

use Illuminate\Support\Facades\Route;



Route::get('navbar', function () {
    return view('inc.navbar');
});

Route::get('/', [LoginController::class, 'index']);
Route::post('action-login', [LoginController::class, 'actionLogin'])->name('action-login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

Route::resource('user', UserController::class);
Route::resource('level', LevelController::class);
Route::resource('customer', CustomerController::class);
Route::resource('service', TypeOfServiceController::class);
Route::resource('transaction', TransOrderController::class);