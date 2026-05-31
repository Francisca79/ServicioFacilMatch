<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClientePanelController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfesionalController;
use App\Http\Controllers\ProfesionalPanelController;
use App\Http\Controllers\RegistroClienteController;
use App\Http\Controllers\ResenaController;
use Illuminate\Support\Facades\Route;

// Público
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');
Route::get('/registro', [ProfesionalController::class, 'registro']);
Route::post('/registro', [ProfesionalController::class, 'store']);
Route::get('/registro-cliente', [RegistroClienteController::class, 'create']);
Route::post('/registro-cliente', [RegistroClienteController::class, 'store']);

Route::get('/profesionales', [ProfesionalController::class, 'index'])->name('profesionales.publico');
Route::get('/profesionales/{id}', [ProfesionalController::class, 'show'])->whereNumber('id');
Route::get('/categorias', [CategoriaController::class, 'index']);
Route::get('/resenas', [ResenaController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::delete('/profesionales/{id}', [ProfesionalController::class, 'destroy'])->whereNumber('id');
    });

    Route::prefix('panel/admin')->middleware('role:admin')->group(function () {
        Route::get('/', [AdminPanelController::class, 'index']);
        Route::get('/profesionales', [AdminPanelController::class, 'profesionales']);
        Route::get('/profesionales/{id}', [AdminPanelController::class, 'showProfesional'])->whereNumber('id');
        Route::get('/categorias', [AdminPanelController::class, 'categorias']);
        Route::get('/resenas', [AdminPanelController::class, 'resenas']);
        Route::get('/usuarios', [AdminPanelController::class, 'usuarios']);
        Route::get('/contactos', [AdminPanelController::class, 'contactos']);
        Route::get('/mensajes', [AdminPanelController::class, 'mensajes']);
        Route::post('/advertencia', [AdminPanelController::class, 'enviarAdvertencia']);
        Route::post('/verificar-servicio', [AdminPanelController::class, 'verificarServicio']);
        Route::delete('/servicios/{id}', [AdminPanelController::class, 'revocarServicio'])->whereNumber('id');
        Route::delete('/usuarios/{id}', [AdminPanelController::class, 'destroyUsuario'])->whereNumber('id');
        Route::delete('/profesionales/{id}', [AdminPanelController::class, 'destroyProfesional'])->whereNumber('id');
        Route::delete('/resenas/{id}', [AdminPanelController::class, 'destroyResena'])->whereNumber('id');
        Route::get('/perfil', [AdminPanelController::class, 'perfil']);
        Route::put('/perfil', [AdminPanelController::class, 'updatePerfil']);
    });

    Route::prefix('panel/cliente')->middleware('role:cliente')->group(function () {
        Route::get('/', [ClientePanelController::class, 'index']);
        Route::get('/profesionales', [ClientePanelController::class, 'profesionales']);
        Route::get('/categorias', [ClientePanelController::class, 'categorias']);
        Route::get('/contacto', [ClientePanelController::class, 'contacto']);
        Route::get('/resenas', [ClientePanelController::class, 'resenas']);
        Route::post('/resenas', [ClientePanelController::class, 'storeResena']);
        Route::delete('/resenas/{id}', [ClientePanelController::class, 'destroyResena'])->whereNumber('id');
        Route::get('/mensajes', [ClientePanelController::class, 'mensajes']);
        Route::post('/mensajes', [ClientePanelController::class, 'storeMensaje']);
        Route::delete('/mensajes/{id}', [ClientePanelController::class, 'destroyMensaje'])->whereNumber('id');
        Route::get('/perfil', [ClientePanelController::class, 'perfil']);
        Route::put('/perfil', [ClientePanelController::class, 'updatePerfil']);
    });

    Route::prefix('panel/profesional')->middleware('role:profesional')->group(function () {
        Route::get('/', [ProfesionalPanelController::class, 'index']);
        Route::get('/directorio', [ProfesionalPanelController::class, 'directorio']);
        Route::get('/resenas', [ProfesionalPanelController::class, 'resenasSistema']);
        Route::get('/resenas-clientes', [ProfesionalPanelController::class, 'resenasClientes']);
        Route::post('/resenas-clientes', [ProfesionalPanelController::class, 'storeResenaCliente']);
        Route::get('/mensajes', [ProfesionalPanelController::class, 'mensajes']);
        Route::post('/mensajes', [ProfesionalPanelController::class, 'storeMensaje']);
        Route::delete('/mensajes/{id}', [ProfesionalPanelController::class, 'destroyMensaje'])->whereNumber('id');
        Route::get('/crear', [ProfesionalPanelController::class, 'edit']);
        Route::get('/editar', [ProfesionalPanelController::class, 'edit']);
        Route::put('/editar', [ProfesionalPanelController::class, 'update']);
    });
});
