<?php

use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

// ---------- Website portofolio (publik) ----------
Route::get('/', [PortfolioController::class, 'index'])->name('home');
Route::post('/', [PortfolioController::class, 'kirimPesan'])->name('pesan.kirim');

// Rute admin ada di file terpisah supaya rapi.
require __DIR__ . '/admin.php';
