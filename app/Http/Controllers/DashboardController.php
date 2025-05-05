<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

public function index()
{
    $user = Auth::user();

    $totalProjects = Project::count();
    $totalTasks = Task::count();
    $completedTasks = Task::where('task_status', 'Completed')->count();
    $pendingTasks = Task::where('task_status', '!=', 'Completed')->count();

    $taskStatusChart = Task::selectRaw('task_status, COUNT(*) as count')
                            ->groupBy('task_status')
                            ->pluck('count', 'task_status');

    $recentTasks = Task::with('project')
                        ->latest()
                        ->take(5)
                        ->get();

    return view('dashboard', compact(
        'totalProjects',
        'totalTasks',
        'completedTasks',
        'pendingTasks',
        'taskStatusChart',
        'recentTasks'
    ));
}

}
