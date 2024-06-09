<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ToolController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\ComunidadeController;

Route::prefix('v1')->group(function () {
    Route::post('login', [AuthController::class, 'login']);

    Route::group(['middleware' => ['apiJwt']], function () {
        Route::prefix('users')->name('.users')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('.index');
            Route::post('/', [UserController::class, 'store'])->name('.store');
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

        Route::prefix('tools')->name('.tools')->group(function () {
            Route::get('tools', [ToolController::class, 'getTools']);

            Route::post('tools', [ToolController::class, 'createTool']);

            Route::delete('tools/{id}', [ToolController::class, 'deleteTool']);
        });
    });
});
