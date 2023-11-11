<?php

use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\PrestasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/prestasi/detail', [PrestasiController::class, 'detail'])->name('api.prestasi.detail');
Route::post('/kodifikasi-type', [PortofolioController::class, 'getKodifikasi'])->name('api.kodifikasi');
