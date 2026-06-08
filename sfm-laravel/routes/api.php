<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoriaController as ApiCategoriaController;
use App\Http\Controllers\Api\ContactoController as ApiContactoController;
use App\Http\Controllers\Api\ProfesionalController as ApiProfesionalController;
use App\Http\Controllers\Api\ResenaController as ApiResenaController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/categorias', [ApiCategoriaController::class, 'index']);
Route::get('/profesionales', [ApiProfesionalController::class, 'index']);
Route::get('/resenas', [ApiResenaController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/resenas', [ApiResenaController::class, 'store']);
    Route::post('/contactos', [ApiContactoController::class, 'store']);
    Route::delete('/profesionales/{id}', [ApiProfesionalController::class, 'destroy'])->whereNumber('id');
});
