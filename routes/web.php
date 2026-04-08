<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('todos.index');
});

Route::get('/dashboard', function () {
    return redirect()->route('todos.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes (kept from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Todo routes (custom routes BEFORE resource to prevent route conflicts)
    Route::get('/todos/search', [TodoController::class, 'search'])->name('todos.search');
    Route::get('/todos/priority/{priority}', [TodoController::class, 'filterByPriority'])->name('todos.priority');
    Route::get('/todos/due/today', [TodoController::class, 'dueToday'])->name('todos.due.today');
    Route::resource('todos', TodoController::class)->parameters([
    'todos' => 'task'
]);
});

require __DIR__.'/auth.php';
