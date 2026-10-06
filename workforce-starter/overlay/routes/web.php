<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Reviewer\ReviewController;
use App\Http\Controllers\Worker\ProjectController;
use App\Http\Controllers\Worker\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('welcome'));

Route::get('/dashboard', DashboardController::class)
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Worker area. Permissions come from spatie/laravel-permission (registered as Gates, so `can:` works).
Route::middleware(['auth', 'verified', 'throttle:60,1'])->prefix('worker')->name('worker.')->group(function () {
    Route::get('projects', [ProjectController::class, 'index'])->middleware('can:apply_to_projects')->name('projects');
    Route::post('projects/{project}/apply', [ProjectController::class, 'apply'])->middleware('can:apply_to_projects')->name('projects.apply');

    Route::get('tasks', [TaskController::class, 'index'])->middleware('can:work_on_tasks')->name('tasks');
    Route::post('projects/{project}/claim', [TaskController::class, 'claim'])->middleware('can:work_on_tasks')->name('tasks.claim');
    Route::get('tasks/{task}', [TaskController::class, 'show'])->middleware('can:work_on_tasks')->name('tasks.show');
    Route::post('tasks/{task}/submit', [TaskController::class, 'submit'])->middleware('can:work_on_tasks')->name('tasks.submit');
});

// Reviewer area
Route::middleware(['auth', 'verified', 'can:review_submissions'])->prefix('reviewer')->name('reviewer.')->group(function () {
    Route::get('queue', [ReviewController::class, 'queue'])->name('queue');
    Route::get('submissions/{submission}', [ReviewController::class, 'show'])->name('review.show');
    Route::post('submissions/{submission}', [ReviewController::class, 'store'])->name('review.store');
});

require __DIR__.'/auth.php';
