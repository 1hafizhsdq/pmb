<?php

use App\Http\Controllers\PendaftaranController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [PendaftaranController::class, 'index']);
    
    // pendaftaran
    Route::resource('pendaftaran', PendaftaranController::class);;
    Route::get('/pengumuman', [PendaftaranController::class, 'pengumuman']);
    Route::post('/herregistrasi', [PendaftaranController::class, 'storeherregistrasi']);
    Route::get('/kota/{provinsiid}', [PendaftaranController::class, 'kota']);
    Route::get('/kecamatan/{kotaid}', [PendaftaranController::class, 'kecamatan']);
    Route::get('/kelurahan/{kecamatanid}', [PendaftaranController::class, 'kelurahan']);
    Route::get('/kodepos/{kelurahanid}', [PendaftaranController::class, 'kodepos']);
});