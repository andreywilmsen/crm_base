<?php

use Illuminate\Support\Facades\Route;
use Modules\Record\Infrastructure\Controllers\RecordController;

Route::middleware(['auth', 'role:admin|funcionario'])->prefix('record')->group(function () {

    Route::get('/', [RecordController::class, 'index'])->name('record.index');

    Route::get('/create', [RecordController::class, 'create'])->name('record.create');

    Route::post('/', [RecordController::class, 'store'])->name('record.store');

    Route::get('/{id}', [RecordController::class, 'get'])->name('record.show');

    Route::put('/{id}', [RecordController::class, 'update'])->name('record.update');

    Route::delete('/{id}', [RecordController::class, 'delete'])->name('record.destroy');
});
