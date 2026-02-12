<?php

use Illuminate\Support\Facades\Route;
use Modules\Record\Infrastructure\Controllers\RecordController;

Route::middleware(['auth', 'role:admin'])->prefix('record')->group(function () {

    Route::get('/', [RecordController::class, 'index'])->name('record.index');
});
