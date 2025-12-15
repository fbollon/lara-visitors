<?php

use Illuminate\Support\Facades\Route;
use Fbollon\LaraVisitors\Http\Controllers\VisitorController;

Route::prefix('laravisitors')
    ->middleware(config('laravisitors.access_middleware'))
    ->group(function () {
        Route::get('/dashboard', [VisitorController::class, 'dashboard'])->name('laravisitors.dashboard');
        Route::get('/export', [VisitorController::class, 'export'])->name('laravisitors.export');
    });