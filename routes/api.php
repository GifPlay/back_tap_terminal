<?php

use App\Http\Controllers\ProductoController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

//Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/recuperar-password', [AuthController::class, 'recuperarPassword']);


    //Usuarios
    Route::get('/usuarios', [UsuarioController::class, 'index']);
    Route::get('/usuarios/{id}', [UsuarioController::class, 'show']);
    Route::post('/usuarios', [UsuarioController::class, 'store']);
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update']);
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy']);
    //Productos
    Route::get('/productos', [ProductoController::class, 'index']);
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

    Route::post('/logout', [AuthController::class, 'logout']);


