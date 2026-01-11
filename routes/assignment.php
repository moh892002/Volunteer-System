<?php

use App\Http\Controllers\AssignmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Authenticate;

Route::middleware(['auth'])->group(function () {
    Route::get('assignments', [AssignmentController::class, 'index'])->name('assignment.index');
    Route::get('assignments/create', [AssignmentController::class, 'create'])->name('assignment.create');
    Route::post('assignments', [AssignmentController::class, 'store'])->name('assignment.store');
    Route::delete('/assignments/{id}', [AssignmentController::class, 'destroy'])->name('assignment.destroy');
    Route::get('/assignments/{id}/edit', [AssignmentController::class, 'edit'])->name('assignment.edit');
    Route::match(['put', 'patch'], 'assignments/{id}', [AssignmentController::class, 'update'])->name('assignment.update');
    Route::patch('/assignments/{id}/status', [AssignmentController::class, 'updateStatus'])->name('assignment.update-status');
});
