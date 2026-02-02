<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Infrastructure\Controllers\UserController;


Route::middleware(['auth', 'role:admin'])->prefix('user')->group(function () {

    Route::get('/', [UserController::class, 'index'])->name('user.index');

    Route::get('/create', [UserController::class, 'create'])->name('user.create');

    Route::get('/{id}', [UserController::class, 'get'])->name('user.show');

    Route::post('/', [UserController::class, 'store'])->name('user.store');

    Route::put('/{id}', [UserController::class, 'update'])->name('user.update');

    Route::delete('/{id}', [UserController::class, 'delete'])->name('user.destroy');
});
