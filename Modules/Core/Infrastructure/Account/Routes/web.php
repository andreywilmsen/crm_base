<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Infrastructure\Account\Controllers\AccountController;

Route::middleware(['auth', 'role:admin|funcionario'])->prefix('account')->group(function () {

    Route::get('/', [AccountController::class, 'index'])->name('account.index');

    Route::put('/update', [AccountController::class, 'update'])->name('account.update');
});
