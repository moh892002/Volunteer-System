<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkplacesController;

Route::middleware(['auth'])->group(function () {
    Route::get('/workplaces', [WorkplacesController::class, 'index'])->name('workplaces.index');
    Route::get('/workplaces/create', [WorkplacesController::class, 'create'])->name('workplaces.create');
    Route::post('/workplaces', [WorkplacesController::class, 'store'])->name('workplaces.store');
    Route::delete('/workplaces/{id}', [WorkplacesController::class, 'destroy'])->name('workplaces.destroy');
    Route::get('/workplaces/{id}/edit', [WorkplacesController::class, 'edit'])->name('workplaces.edit');
    Route::match(['put', 'patch'], '/workplaces/{id}', [WorkplacesController::class, 'update'])->name('workplaces.update');
    Route::patch('/workplaces/{id}/restore', [WorkplacesController::class, 'restore'])->name('workplaces.restore');
    Route::get('/workplaces/export', [WorkplacesController::class, 'export'])->name('workplaces.export');
});
