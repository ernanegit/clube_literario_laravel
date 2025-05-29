<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReuniaoPublicController;
use App\Http\Controllers\InscricaoPublicController;
use Illuminate\Support\Facades\Route;

// Páginas públicas
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/reunioes', [ReuniaoPublicController::class, 'index'])->name('reunioes.index');
Route::get('/reunioes/{meeting}', [ReuniaoPublicController::class, 'show'])->name('reunioes.show');

// Rotas que precisam de autenticação
Route::middleware('auth')->group(function () {
    Route::post('/reunioes/{meeting}/inscrever', [InscricaoPublicController::class, 'store'])->name('inscricoes.store');
    Route::get('/minhas-inscricoes', [InscricaoPublicController::class, 'minhas'])->name('inscricoes.minhas');
});

// Rotas de autenticação do Laravel Breeze
require __DIR__.'/auth.php';