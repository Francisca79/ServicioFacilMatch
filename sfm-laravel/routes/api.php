<?php

use App\Http\Controllers\Api\CategoriaController as ApiCategoriaController;
use App\Http\Controllers\Api\ContactoController as ApiContactoController;
use App\Http\Controllers\Api\ProfesionalController as ApiProfesionalController;
use App\Http\Controllers\Api\ResenaController as ApiResenaController;
use App\Http\Controllers\Api\SaludoController;
use Illuminate\Support\Facades\Route;

Route::get('/saludo', [SaludoController::class, 'index']);
Route::get('/categorias', [ApiCategoriaController::class, 'index']);
Route::get('/profesionales', [ApiProfesionalController::class, 'index']);
Route::delete('/profesionales/{id}', [ApiProfesionalController::class, 'destroy']);
Route::get('/resenas', [ApiResenaController::class, 'index']);
Route::post('/resenas', [ApiResenaController::class, 'store']);
Route::post('/contactos', [ApiContactoController::class, 'store']);
