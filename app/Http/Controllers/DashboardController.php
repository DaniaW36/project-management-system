<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class DashboardController extends Controller
{

    public function index()
    {

        $userId = auth()->id();

        $totalProjects = Project::where('user_id', $userId)->count();
        $totalTasks = Task::where('user_id', $userId)->count();
        $completedTasks = Task::where('user_id', $userId)->where('task_status', 'Completed')->count();
        $pendingTasks = Task::where('user_id', $userId)->where('task_status', '!=', 'Completed')->count();

        // Group tasks by status
        $taskStatusChart = Task::select('task_status', \DB::raw('count(*) as total'))
            ->where('user_id', $userId)
            ->groupBy('task_status')
            ->pluck('total', 'task_status');

        $recentTasks = Task::with('project')
            ->where('user_id', $userId)
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

    public function adminIndex()
    {
        $staff = User::where('role', 'staff')->get();
        $projects = Project::with('user')->latest()->get();
        $tasks = Task::with(['project', 'user'])->latest()->get();

        // Add these task summary calculations
        $completedTasks = $tasks->where('task_status', 'Completed')->count();
        $pendingTasks = $tasks->where('task_status', '!=', 'Completed')->count();
        $totalTasks = $tasks->count();

        // Group tasks by status (for chart)
        $taskStatusChart = $tasks->groupBy('task_status')->map->count();

        return view('admin.dashboard', compact(
            'staff',
            'projects',
            'tasks',
            'completedTasks',
            'pendingTasks',
            'totalTasks',
            'taskStatusChart'
        ));
    }


}
