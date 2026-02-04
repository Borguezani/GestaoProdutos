<?php

use App\Http\Controllers\Api\ProdutoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Rotas públicas da API
Route::prefix('produtos')->group(function () {
    Route::get('/', [ProdutoController::class, 'index']);
});

Route::prefix('usuarios')->group(function () {
    Route::get('/{usuario}/produtos', [ProdutoController::class, 'usuarioProdutos']);
});

Route::prefix('produtos')->group(function () {
    Route::patch('/{produto}/remover', [ProdutoController::class, 'remover']);
});
