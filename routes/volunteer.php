<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VolunteersController;
use App\Http\Controllers\WorkplacesController;

Route::middleware(['auth'])->group(function () {
    Route::get('/volunteers', [VolunteersController::class, 'index'])->name('volunteers.index');
    Route::get('/workplaces', [WorkplacesController::class, 'index'])->name('workplaces.index');

    Route::get('/volunteers/create', [VolunteersController::class, 'create'])->name('volunteers.create');
    Route::post('/volunteers', [VolunteersController::class, 'store'])->name('volunteers.store');
    Route::delete('/volunteers/{id}', [VolunteersController::class, 'destroy'])->name('volunteers.destroy');
    Route::get('/volunteers/{id}/edit', [VolunteersController::class, 'edit'])->name('volunteers.edit');
    Route::match(['put', 'patch'], 'volunteers/{id}', [VolunteersController::class, 'update'])->name('volunteers.update');
});
