<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ComunidadeController;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [UserController::class, 'store'])->name('users.store');

    Route::group(['middleware' => ['apiJwt']], function () {
        Route::prefix('users')->name('.users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('.index');
            Route::get('/{id}', [UserController::class, 'show'])->name('.show');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('.destroy');
            Route::post('/{id}/subscribe', [UserController::class, 'subscribeToCommunity'])->name('.subscribe');
        });

        Route::prefix('comunidades')->name('.comunidades')->group(function () {
            Route::get('/', [ComunidadeController::class, 'index'])->name('.index');
            Route::get('/{id}', [ComunidadeController::class, 'show'])->name('.show');
            Route::post('/', [ComunidadeController::class, 'store'])->name('.store');
            Route::delete('/{id}', [ComunidadeController::class, 'destroy'])->name('.destroy');
        });

        Route::prefix('cursos')->name('.cursos')->group(function () {
            Route::post('/{cursoId}/inscrever', [CursoController::class, 'inscreverUsuario'])->name('.purchase');
            Route::post('/', [CursoController::class, 'cadastrarCurso'])->name('.store');
            Route::put('/{id}', [CursoController::class, 'atualizarCurso'])->name('.update');
            Route::delete('/{id}', [CursoController::class, 'excluirCurso'])->name('.destroy');
            Route::get('cursos', [CursoController::class, 'listarCursos'])->name('.index');
        });

        Route::prefix('perfis')->name('.perfis')->group(function () {
            Route::post('/', [PerfilController::class, 'store'])->name('.store');
            Route::get('/{userId}', [PerfilController::class, 'show'])->name('.show');
            Route::put('/{userId}', [PerfilController::class, 'update'])->name('.update');
            Route::delete('/{userId}', [PerfilController::class, 'destroy'])->name('.destroy');
        });
    });
});
