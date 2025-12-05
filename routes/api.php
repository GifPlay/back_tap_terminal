<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordController;

//Auth
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('me', [AuthController::class, 'me']);


Route::middleware(['auth:api'])->get('/usuarios', [UsuarioController::class, 'index']);
Route::middleware(['auth:api'])->get('/productos', [ProductoController::class, 'index']);


Route::middleware(['auth:api'])->group(function () {
    //Export
    Route::get('/export/productos/excel', [ProductoController::class, 'exportProductosExcel']);
    Route::get('/export/productos/pdf', [ProductoController::class, 'exportProductosPdf']);

    Route::get('/export/usuarios/excel', [UsuarioController::class, 'exportUsuariosExcel']);
    Route::get('/export/usuarios/pdf', [UsuarioController::class, 'exportUsuariosPdf']);

    Route::get('/export/perfiles/excel', [PerfilController::class, 'exportPerfilExcel']);
    Route::get('/export/perfiles/pdf', [PerfilController::class, 'exportPerfilPdf']);

//Usuarios
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
    Route::post('/usuarios', [UsuarioController::class, 'store']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);
    Route::post('/foto/usuarios/{id}', [UsuarioController::class, 'uploadFoto']);

//Productos
    Route::get('/productos/{id}', [ProductoController::class, 'show']);
    Route::post('/productos', [ProductoController::class, 'store']);
    Route::put('/productos/{id}', [ProductoController::class, 'update']);
    Route::delete('/productos/{id}', [ProductoController::class, 'destroy']);

//Perfiles
    Route::get('/perfiles', [PerfilController::class, 'index']);
    Route::get('/perfiles/{id}', [PerfilController::class, 'show']);
    Route::post('/perfiles', [PerfilController::class, 'store']);
    Route::put('/perfiles/{id}', [PerfilController::class, 'update']);
    Route::delete('/perfiles/{id}', [PerfilController::class, 'destroy']);
});


Route::post('/forgot-password', [PasswordController::class, 'forgotPassword']);
Route::post('/reset-password', [PasswordController::class, 'resetPassword']);




