<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;



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
