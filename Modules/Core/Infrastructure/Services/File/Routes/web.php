<?php

use Illuminate\Support\Facades\Route;
use Modules\Core\Infrastructure\Services\File\Controllers\AttachmentController;

Route::middleware('web')->group(function () {
    Route::prefix('attachments')->name('attachments.')->group(function () {
        Route::post('/', [AttachmentController::class, 'store'])->name('store');
        Route::delete('/{id}', [AttachmentController::class, 'destroy'])->name('destroy');
    });
});
