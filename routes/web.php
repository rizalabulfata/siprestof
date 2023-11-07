<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::middleware('guest')->name('auth.')->group(function () {
//     Route::get('login', [AuthController::class, 'index'])->name('login');
// });

// Route::middleware('auth')->group(function () {
//     Route::get('dashboard', [DashboardController::class, 'index']);
// });

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ResetPassword;
use App\Http\Controllers\ChangePassword;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\PrestasiController;
use App\Http\Controllers\VerifikasiController;

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

Route::get('/testview/{name}', function ($name) {
    return view('pages.' . $name);
});

Route::group(['middleware' => 'auth'], function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('mahasiswa', MahasiswaController::class);
    Route::resource('portofolio', PortofolioController::class);
    Route::resource('prestasi', PrestasiController::class);
    Route::resource('verifikasi', VerifikasiController::class);
    // Route::prefix('verifikasi')->as('verifikasi.')->group(function () {
    //     Route::get('/', [VerifikasiController::class, 'index'])->name('index');

    //     // kompetisi
    //     Route::get('kompetisi', [VerifikasiController::class, 'kompetisiCreate'])->name('kompetisi.crete');
    //     Route::get('kompetisi/{id}', [VerifikasiController::class, 'kompetisiShow'])->name('kompetisi.show');
    //     Route::post('kompetisi/{id}', [VerifikasiController::class, 'kompetisiStore'])->name('kompetisi.store');
    //     Route::get('kompetisi/{id}/edit', [VerifikasiController::class, 'kompetisiEdit'])->name('kompetisi.edit');
    //     Route::post('kompetisi/{id}/approve', [VerifikasiController::class, 'kompetisiApprove'])->name('kompetisi.approve');

    //     // penghargaan
    //     Route::get('_/{id}', [VerifikasiController::class, 'kompetisiShow'])->name('penghargaan.show');
    //     Route::get('_1/{id}', [VerifikasiController::class, 'kompetisiShow'])->name('aplikom.show');
    //     Route::get('_2/{id}', [VerifikasiController::class, 'kompetisiShow'])->name('artikel.show');
    //     Route::get('_3/{id}', [VerifikasiController::class, 'kompetisiShow'])->name('buku.show');
    //     Route::get('_4/{id}', [VerifikasiController::class, 'kompetisiShow'])->name('desain_produk.show');
    //     Route::get('_5/{id}', [VerifikasiController::class, 'kompetisiShow'])->name('film.show');
    // });



    // Route::get('/virtual-reality', [PageController::class, 'vr'])->name('virtual-reality');
    // Route::get('/rtl', [PageController::class, 'rtl'])->name('rtl');
    // Route::get('/profile', [UserProfileController::class, 'show'])->name('profile');
    // Route::post('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    // Route::get('/profile-static', [PageController::class, 'profile'])->name('profile-static');
    // Route::get('/sign-in-static', [PageController::class, 'signin'])->name('sign-in-static');
    // Route::get('/sign-up-static', [PageController::class, 'signup'])->name('sign-up-static');
    // Route::get('/{page}', [PageController::class, 'index'])->name('page');
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::get('/register', [RegisterController::class, 'create'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store'])->middleware('guest')->name('register.perform');
Route::get('/login', [LoginController::class, 'show'])->middleware('guest')->name('login');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest')->name('login.perform');
Route::get('/reset-password', [ResetPassword::class, 'show'])->middleware('guest')->name('reset-password');
Route::post('/reset-password', [ResetPassword::class, 'send'])->middleware('guest')->name('reset.perform');
Route::get('/change-password', [ChangePassword::class, 'show'])->middleware('guest')->name('change-password');
Route::post('/change-password', [ChangePassword::class, 'update'])->middleware('guest')->name('change.perform');
