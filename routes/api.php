<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::post('/register', [App\Http\Controllers\Api\V1\AuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\Api\V1\AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [App\Http\Controllers\Api\V1\AuthController::class, 'logout']);
        Route::post('/refresh', [App\Http\Controllers\Api\V1\AuthController::class, 'refresh']);
        Route::get('/user', [App\Http\Controllers\Api\V1\AuthController::class, 'user']);

        Route::apiResource('areas', App\Http\Controllers\Api\V1\AreaProblemaController::class);
        Route::apiResource('localidades', App\Http\Controllers\Api\V1\LocalidadeController::class);
        Route::apiResource('categorias-instituicao', App\Http\Controllers\Api\V1\CategoriaInstituicaoController::class);
        Route::apiResource('instituicao', App\Http\Controllers\Api\V1\InstituicaoController::class);
        Route::apiResource('familia', App\Http\Controllers\Api\V1\FamiliaController::class);


        Route::prefix('projeto-social')->group(function () {

        });
    });
});
