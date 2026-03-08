<?php

use Illuminate\Support\Facades\Route;
use Modules\Collaborator\Infrastructure\Controllers\CollaboratorController;

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::prefix('collaborator')->group(function () {
        Route::get('/', [CollaboratorController::class, 'index'])->name('collaborator.index');
        Route::get('/create', [CollaboratorController::class, 'create'])->name('collaborator.create');
        Route::post('/', [CollaboratorController::class, 'store'])->name('collaborator.store');
        Route::get('/{id}', [CollaboratorController::class, 'get'])->name('collaborator.show');
        Route::put('/{id}', [CollaboratorController::class, 'update'])->name('collaborator.update');
        Route::delete('/{id}', [CollaboratorController::class, 'delete'])->name('collaborator.destroy');
    });
});
