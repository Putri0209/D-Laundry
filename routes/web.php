<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BelajarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PerhitunganController;
use App\Http\Controllers\PesertaPelatihanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolumeLimasController;
use Illuminate\Support\Facades\Route;



Route::get('navbar', function () {
    return view('inc.navbar');
});

Route::get('perhitungan', function () {
    return view('perhitungan.index');
})->name('perhitungan.index');

Route::post('perhitungan', [PerhitunganController::class,'store'])->name('perhitungan.store');

Route::get('kubus', [PerhitunganController::class,'index'])->name('kubus.index');

Route::post('kubus', [PerhitunganController::class,'storeKubus'])->name('kubus.store');

// volume kubus
Route::get('vkubus', function () {
    return view('kubus.vkubus');
})->name('vkubus.index');
Route::post('vkubus', [PerhitunganController::class,'storeVKubus'])->name('vkubus.store');

// luas permukaan tabung
Route::get('lptabung', function () {
    return view('tabung.lptabung');
})->name('lptabung.index');

Route::post('lptabung', [PerhitunganController::class,'storetabung'])->name('lptabung.store');

Route::get('vtabung', function () {
    return view('tabung.vtabung');
})->name('vtabung.index');

Route::post('vtabung', [PerhitunganController::class,'storevtabung'])->name('vtabung.store');

// Route::get('vlimas', [VolumeLimasController::class,'index'])->name('vlimas.index');

// Route::get('vlimas/create',[VolumeLimasController::class,'create'])->name('vlimas.create');
// Route::post('vlimas/store',[VolumeLimasController::class,'store'])->name('vlimas.store');
// Route::get('vlimas/edit/{id}',[VolumeLimasController::class,'edit'])->name('vlimas.edit');
// Route::put('vlimas/update/{id}',[VolumeLimasController::class,'update'])->name('vlimas.update');
// Route::delete('vlimas/delete/{id}',[VolumeLimasController::class,'destroy'])->name('vlimas.destroy');

// get = melihat data atau menampilkannya
// post = mengirim data
// put/patch = edit data
// delete = menghapus data

Route::resource('vlimas', VolumeLimasController::class);

Route::resource('pesertapelatihan', PesertaPelatihanController::class);

Route::get('belajar-laravel', [BelajarController::class, 'index']);
Route::get('siswa', [BelajarController::class, 'getSiswa']);
Route::get('create', [BelajarController::class, 'create'])->name('siswa.create');
Route::post('store', [BelajarController::class, 'store'])->name('siswa.store');

Route::get('/', [LoginController::class, 'index']);
Route::post('action-login', [LoginController::class, 'actionLogin'])->name('action-login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('dashboard', [DashboardController::class, 'index']);

Route::resource('user', UserController::class);
Route::resource('role', RoleController::class);
Route::resource('student', StudentController::class);
Route::resource('attendance', AttendanceController::class);
