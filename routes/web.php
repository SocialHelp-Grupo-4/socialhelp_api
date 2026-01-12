<?php

use App\Http\Controllers\Dashboard\FamilyController;
use App\Http\Controllers\Dashboard\InstitutionCategoryController;
use App\Http\Controllers\Dashboard\InstitutionController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\LocationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::resource('users', UserController::class)->names('users');

    Route::middleware(['auth', 'verified'])->group(function () {

    Route::prefix('institution')->group(function () {
        Route::resource(
            'category',
            InstitutionCategoryController::class
        )->names('category');

        Route::resource(
            '',
            InstitutionController::class
        )->names('institution');
    });
    
    Route::resource('location', LocationController::class)->names('location');
    Route::resource('family', FamilyController::class)->names('family');
});

require __DIR__ . '/settings.php';
