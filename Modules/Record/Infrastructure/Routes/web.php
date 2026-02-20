<?php

use Illuminate\Support\Facades\Route;
use Modules\Record\Infrastructure\Controllers\RecordController;
use Modules\Record\Infrastructure\Controllers\RecordCategoryController;

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
        Route::get('/create', [RecordCategoryController::class, 'create'])->name('record-category.create');
        Route::post('/', [RecordCategoryController::class, 'store'])->name('record-category.store');
        Route::get('/{id}/edit', [RecordCategoryController::class, 'edit'])->name('record-category.edit');
        Route::put('/{id}', [RecordCategoryController::class, 'update'])->name('record-category.update');
        Route::delete('/{id}', [RecordCategoryController::class, 'destroy'])->name('record-category.destroy');
    });
});
