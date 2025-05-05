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
        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('task_status', 'Completed')->count();
        $pendingTasks = Task::where('task_status', '!=', 'Completed')->count();

        // Group tasks by status
        $taskStatusChart = Task::select('task_status', \DB::raw('count(*) as total'))
            ->groupBy('task_status')
            ->pluck('total', 'task_status');

        $recentTasks = Task::with('project')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('staffdashboard.dashboard', compact(
            'totalProjects',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'taskStatusChart',
            'recentTasks'
        ));
    }
}
