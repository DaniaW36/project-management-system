<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/projects', [\App\Http\Controllers\ProjectController::class, 'index'])->name('projects.index');
Route::get('/projects/create', [\App\Http\Controllers\ProjectController::class, 'create'])->name('projects.create');
Route::get('/projects/{id}', [\App\Http\Controllers\ProjectController::class, 'show'])->name('projects.show');
Route::post('/projects', [\App\Http\Controllers\ProjectController::class, 'store'])->name('projects.store');
Route::get('/projects/{id}/edit', [\App\Http\Controllers\ProjectController::class, 'edit'])->name('projects.edit');
Route::put('/projects/{id}', [\App\Http\Controllers\ProjectController::class, 'update'])->name('projects.update');
Route::delete('/projects/{id}', [\App\Http\Controllers\ProjectController::class, 'destroy'])->name('projects.destroy');

Route::post('/projects/{project}/attachments/{index}/delete', [\App\Http\Controllers\ProjectController::class, 'deleteAttachment'])->name('projects.delete-attachment');


// Route for viewing all tasks (optional, if you still want to keep it)
Route::get('/tasks', [\App\Http\Controllers\TaskController::class, 'index'])->name('tasks.index');
Route::get('/tasks/create', [\App\Http\Controllers\TaskController::class, 'create'])->name('tasks.create');
Route::post('/tasks', [\App\Http\Controllers\TaskController::class, 'store'])->name('tasks.store');
// Route for viewing tasks for a specific project
Route::get('/projects/{project}/tasks', [\App\Http\Controllers\TaskController::class, 'projectTasks'])->name('projects.tasks.index');
Route::resource('tasks', TaskController::class);

Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
