<?php

use Illuminate\Support\Facades\Route;
use Modules\Record\Infrastructure\Controllers\RecordController;
use Modules\Record\Infrastructure\Controllers\RecordCategoryController;
use Modules\Record\Infrastructure\Controllers\RecordStatusController;

Route::middleware(['auth', 'role:admin|funcionario'])->prefix('admin')->group(function () {

    Route::prefix('record')->group(function () {
        Route::get('/', [RecordController::class, 'index'])->name('record.index');
        Route::get('/create', [RecordController::class, 'create'])->name('record.create');
        Route::post('/', [RecordController::class, 'store'])->name('record.store');
        Route::get('/{id}', [RecordController::class, 'get'])->name('record.show');
        Route::put('/{id}', [RecordController::class, 'update'])->name('record.update');
        Route::delete('/{id}', [RecordController::class, 'delete'])->name('record.destroy');
    });

    Route::prefix('record-categories')->group(function () {
        Route::get('/', [RecordCategoryController::class, 'index'])->name('record-category.index');
        Route::post('/', [RecordCategoryController::class, 'store'])->name('record-category.store');
        Route::delete('/{id}', [RecordCategoryController::class, 'destroy'])->name('record-category.destroy');
    });

    Route::prefix('status-categories')->group(function () {
        Route::get('/', [RecordStatusController::class, 'index'])->name('record-status.index');
        Route::post('/', [RecordStatusController::class, 'store'])->name('record-status.store');
        Route::delete('/{id}', [RecordStatusController::class, 'destroy'])->name('record-status.destroy');
    });
});
