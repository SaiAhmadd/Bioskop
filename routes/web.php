<?php

use App\Http\Controllers\BioskopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BioskopController::class, 'index'])->name('home');
Route::get('/film/{id}', [BioskopController::class, 'show'])->name('film.show');
Route::get('/film/{id}/pesan', [BioskopController::class, 'pesan'])->name('film.pesan');
Route::post('/film/{id}/pesan', [BioskopController::class, 'simpan'])->name('film.simpan');
Route::get('/tiket', [BioskopController::class, 'tiket'])->name('tiket');
