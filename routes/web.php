<?php

use App\Http\Controllers\Dashboard\InstitutionCategoryController;
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



Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('institution')->group(function () {
        Route::resource(
            'category',
            InstitutionCategoryController::class
        )->names('category');
    });
})->name('institution.');

require __DIR__ . '/settings.php';
