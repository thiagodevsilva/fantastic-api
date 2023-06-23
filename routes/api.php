<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\API\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Rotas são carregadas pelo RouteServiceProvider dentro de um grupo
| que é atribuído ao grupo de middleware "api".
|
*/

// Grupo de rotas protegidas por autenticação JWT
Route::middleware('auth:api')->group(function () {

    // Rota para o endpoint da listagem de produtos
    Route::get('/produtos', [ProductController::class, 'showAll'])->name('produtos.showAll');

    // Rota para o endpoint que busca um produto pelo ID
    Route::get('/produtos/{id}', [ProductController::class, 'show'])->name('produtos.show');

    // Rota para o endpoint de logout
    Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Rota para o endpoint de login
Route::post('/login', [AuthController::class, 'login'])->name('login');
