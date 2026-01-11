<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TasksController;

Route::middleware(['auth'])->group(function () {
    Route::get('/tasks', [TasksController::class, 'index'])->name('tasks.index');
    Route::get('/tasks/create', [TasksController::class, 'create'])->name('tasks.create');
    Route::post('/tasks', [TasksController::class, 'store'])->name('tasks.store');
    Route::delete('/tasks/{id}', [TasksController::class, 'destroy'])->name('tasks.destroy');
    Route::get('/tasks/{id}/edit', [TasksController::class, 'edit'])->name('tasks.edit');
    Route::match(['put', 'patch'], '/tasks/{id}', [TasksController::class, 'update'])->name('tasks.update');
});
