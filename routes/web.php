<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;
use App\Models\Category;
use App\Models\Task;

Route::get('/', function () {
    return redirect(route('login'));
});

Route::get('/dashboard', function () {
    $categories = Category::all();
    $tasks = Task::all();
    return view('dashboard', compact('categories', 'tasks'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', CategoryController::class);
    Route::resource('tasks', TaskController::class);
    Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
    Route::delete('/multiDelete', [TaskController::class, 'multiDelete'])->name('tasks.multiDelete');
    Route::get('/task/search', [TaskController::class, 'search'])->name('tasks.search');
    Route::get('/task/filter', [TaskController::class, 'filter'])->name('tasks.filter');
    Route::get('/task/export', [TaskController::class, 'export'])->name('tasks.export');
});

require __DIR__ . '/auth.php';
