<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkplacesController;

Route::middleware(['auth'])->group(function () {
    Route::get('/workplace', [WorkplacesController::class, 'index'])->name('workplaces.index');
    Route::get('/workplace/create', [WorkplacesController::class, 'create'])->name('workplace.create');
    Route::post('/workplace', [WorkplacesController::class, 'store'])->name('workplace.store');
    Route::delete('/workplace/{id}', [WorkplacesController::class, 'destroy'])->name('workplace.destroy');
    Route::get('/workplace/{id}/edit', [WorkplacesController::class, 'edit'])->name('workplace.edit');
    Route::match(['put', 'patch'], '/workplace/{id}', [WorkplacesController::class, 'update'])->name('workplace.update');
});
