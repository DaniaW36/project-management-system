<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\TaskController as AdminTaskController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;

// Public routes
Route::get('/', fn() => view('welcome'));
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Protected routes
Route::middleware('auth')->group(function () {

    // Common: Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password/change', [ProfileController::class, 'showChangePasswordForm'])->name('profile.password.change.form');
    Route::put('/profile/password/change', [ProfileController::class, 'changePassword'])->name('profile.password.update');

    // ---------------- STAFF ROUTES ----------------
    Route::middleware('role:staff')->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // My Projects
        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/projects', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/projects/{id}', [ProjectController::class, 'show'])->name('projects.show');
        Route::get('/projects/{id}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::put('/projects/{id}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/projects/{id}', [ProjectController::class, 'destroy'])->name('projects.destroy');
        Route::post('/projects/{project}/attachments/{index}/delete', [ProjectController::class, 'deleteAttachment'])->name('projects.delete-attachment');

        // View Other Staff Projects (Read-only)
        Route::get('/staff-projects', [ProjectController::class, 'staffProjects'])->name('staff-projects.index');
        Route::get('/staff-projects/{id}', [ProjectController::class, 'staffProjectShow'])->name('staff-projects.show');

        // My Tasks
        Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store');
        Route::get('/tasks/{task}', [TaskController::class, 'show'])->name('tasks.show');
        Route::get('/tasks/{task}/edit', [TaskController::class, 'edit'])->name('tasks.edit');
        Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update');
        Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy');
        Route::delete('/tasks/{task}/attachments/{index}', [TaskController::class, 'deleteAttachment'])->name('tasks.delete-attachment');
        Route::get('/projects/{project}/tasks', [TaskController::class, 'projectTasks'])->name('projects.tasks.index');

        // View Other Staff Tasks (Read-only)
        Route::get('/staff-tasks', [TaskController::class, 'staffTasks'])->name('staff-tasks.index');
        Route::get('/staff-tasks/{task}', [TaskController::class, 'staffTaskShow'])->name('staff-tasks.show');
    });

    // ---------------- ADMIN ROUTES ----------------
    Route::middleware('role:admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'adminIndex'])->name('dashboard');

        // Projects
        Route::resource('projects', AdminProjectController::class);
        Route::delete('projects/{project}/attachments/{index}', [AdminProjectController::class, 'deleteAttachment'])
            ->name('projects.delete-attachment');

        // Tasks
        Route::resource('tasks', AdminTaskController::class);
        Route::delete('tasks/{task}/attachments/{index}', [AdminTaskController::class, 'deleteAttachment'])
            ->name('tasks.delete-attachment');
    });

});
