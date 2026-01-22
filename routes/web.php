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





Route::middleware(['auth', 'verified'])->group(function () {
    // Institution Selection
    Route::get('institution/select', [\App\Http\Controllers\Dashboard\InstitutionSelectionController::class, 'index'])->name('institution.select');
    Route::post('institution/select', [\App\Http\Controllers\Dashboard\InstitutionSelectionController::class, 'store'])->name('institution.select.store');

    // Admin / System Management
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('approvals', [\App\Http\Controllers\Dashboard\InstitutionApprovalController::class, 'index'])->name('approvals.index');
        Route::post('approvals/{institution}/approve', [\App\Http\Controllers\Dashboard\InstitutionApprovalController::class, 'approve'])->name('approvals.approve');
        Route::post('approvals/{institution}/reject', [\App\Http\Controllers\Dashboard\InstitutionApprovalController::class, 'reject'])->name('approvals.reject');
    });

    // Route::middleware(['institution.check'])->group(function () {
    Route::resource('users', UserController::class)->names('users');
    Route::prefix('institution')->group(function () {
        Route::resource('', InstitutionController::class)->names('institution');

        Route::resource('category', InstitutionCategoryController::class)->names('category');

        // Members & Invitations
        Route::get('members', [\App\Http\Controllers\Dashboard\InstitutionMembersController::class, 'index'])->name('institution.members.index');
        Route::put('members/{user}', [\App\Http\Controllers\Dashboard\InstitutionMembersController::class, 'update'])->name('institution.members.update');
        Route::delete('members/{user}', [\App\Http\Controllers\Dashboard\InstitutionMembersController::class, 'destroy'])->name('institution.members.destroy');

        Route::get('invitations', [\App\Http\Controllers\Dashboard\InstitutionInvitationController::class, 'index'])->name('institution.invitations.index');
        Route::post('invitations', [\App\Http\Controllers\Dashboard\InstitutionInvitationController::class, 'store'])->name('institution.invitations.store');
        Route::delete('invitations/{id}', [\App\Http\Controllers\Dashboard\InstitutionInvitationController::class, 'destroy'])->name('institution.invitations.destroy');
    });

    Route::resource('location', LocationController::class)->names('location');
    Route::resource('family', FamilyController::class)->names('family');

    Route::resource('project', \App\Http\Controllers\Dashboard\ProjectController::class)->names('project');
    Route::resource('problem_area', \App\Http\Controllers\Dashboard\ProblemAreaController::class)->names('problem_area');
    Route::resource('socioeconomic_data_type', \App\Http\Controllers\Dashboard\SocioeconomicDataTypeController::class)->names('socioeconomic_data_type');
    // });
});

require __DIR__ . '/settings.php';
