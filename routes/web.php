<?php

use App\Http\Controllers\MarkaJalanController;
use App\Http\Controllers\KecamatanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => ['auth']], function (){

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // data user
    Route::resource('data-user', UserController::class);

    Route::resource('data-kecamatan', KecamatanController::class);

    // data marka-jalan
    Route::resource('/data-marka-jalan', MarkaJalanController::class);
    Route::get('/peta-marka-jalan', [MarkaJalanController::class, 'showMap'])->name('data-marka-jalan.peta');
    Route::post('/marka-jalan/{id}/upload-fotos', [MarkaJalanController::class, 'uploadPhotoDetail'])->name('data-marka-jalan.uploadFotos');
    Route::post('/marka-jalan/kondisi/{id}', [MarkaJalanController::class, 'storeKondisiMarka'])->name('data-marka-jalan.storeKondisi');
    
});
