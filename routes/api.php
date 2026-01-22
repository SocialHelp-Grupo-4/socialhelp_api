<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function () {
    Route::post('/register', [App\Http\Controllers\Api\V1\AuthController::class, 'register']);
    Route::post('/login', [App\Http\Controllers\Api\V1\AuthController::class, 'login']);

    // Public / User Portal Routes
    Route::prefix('public')->group(function () {
        Route::get('projects', [\App\Http\Controllers\Api\V1\Public\ProjectController::class, 'index']);
        Route::get('projects/{id}', [\App\Http\Controllers\Api\V1\Public\ProjectController::class, 'show']);
        Route::get('institution-categories', [\App\Http\Controllers\Api\V1\InstitutionCategoryController::class, 'index']);
    });

    Route::middleware('auth:api')->group(function () {
        Route::post('/logout', [App\Http\Controllers\Api\V1\AuthController::class, 'logout']);
        Route::post('/refresh', [App\Http\Controllers\Api\V1\AuthController::class, 'refresh']);
        Route::get('/user', [App\Http\Controllers\Api\V1\AuthController::class, 'user']);

        // User Portal / Beneficiary Actions
        Route::prefix('public')->group(function () {
            Route::post('projects/{id}/register', [\App\Http\Controllers\Api\V1\Public\ProjectController::class, 'register']);
            Route::get('my-family', [\App\Http\Controllers\Api\V1\Public\FamilyController::class, 'show']);
            Route::post('my-family', [\App\Http\Controllers\Api\V1\Public\FamilyController::class, 'store']);
            Route::put('my-family', [\App\Http\Controllers\Api\V1\Public\FamilyController::class, 'update']);

            // Institution Registration
            Route::post('institutions/register', [\App\Http\Controllers\Api\V1\Public\InstitutionRegistrationController::class, 'store']);
            Route::get('my-institutions-status', [\App\Http\Controllers\Api\V1\Public\InstitutionRegistrationController::class, 'status']);
        });

        // Institution Context
        Route::get('/institutions', [\App\Http\Controllers\Api\V1\InstitutionContextController::class, 'index']);
        Route::post('/institutions/switch', [\App\Http\Controllers\Api\V1\InstitutionContextController::class, 'store']);
        Route::get('/institutions/current', [\App\Http\Controllers\Api\V1\InstitutionContextController::class, 'current']);


        Route::prefix('projeto-social')->group(function () {
            Route::apiResource('families', \App\Http\Controllers\Api\V1\FamilyController::class);
        });
    });
});
