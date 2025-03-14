<?php

use App\Http\Controllers\ColumnController;
use App\Http\Controllers\KanbanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome', [
    'canLogin' => Route::has('login'),
    'canRegister' => Route::has('register'),
    'laravelVersion' => Application::VERSION,
    'phpVersion' => PHP_VERSION,
]);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('/dashboard', 'Dashboard')
        ->name('dashboard');

    Route::get('/kanban', KanbanController::class)
        ->name('kanban');

    Route::controller(ColumnController::class)
        ->name('columns.')
        ->prefix('columns')
        ->group(function () {
            Route::post('/create', 'store')->name('store');
            Route::delete('/{column}', 'destroy')->name('delete');
            Route::patch('/{column}/update', 'update')->name('update');
            Route::patch('/{column}/reorder', 'reorder')->name('reorder');
        });

    Route::controller(TaskController::class)
        ->name('tasks.')
        ->prefix('tasks')
        ->group(function () {
            Route::post('/create', 'store')->name('store');
            Route::patch('/{task}', 'complete')->name('complete');
            Route::delete('/{task}', 'destroy')->name('delete');
            Route::patch('/{task}/reorder', 'reorder')->name('reorder');
        });
});

Route::controller(ProfileController::class)
    ->middleware('auth')
    ->prefix('profile')
    ->name('profile.')
    ->group(function () {
        Route::get('/', 'edit')->name('edit');
        Route::patch('/', 'update')->name('update');
        Route::delete('/', 'destroy')->name('destroy');
    });

require __DIR__.'/auth.php';
