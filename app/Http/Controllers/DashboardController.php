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
        $completedTasks = Task::where('user_id', $userId)->where('task_status', 'completed')->count();
        $pendingTasks = Task::where('user_id', $userId)->where('task_status', '!=', 'completed')->count();

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
        // Get all staff members with their projects and tasks
        $staff = User::where('role', 'staff')
            ->with(['projects', 'tasks'])
            ->get();
        
        // Get all projects with their assigned users and tasks
        $projects = Project::with(['user', 'tasks'])
            ->latest()
            ->get();
        
        // Get all tasks with their related projects and users
        $tasks = Task::with(['project', 'user'])
            ->latest()
            ->get();

        // Calculate task statistics
        $completedTasks = $tasks->where('task_status', 'completed')->count();
        $pendingTasks = $tasks->where('task_status', '!=', 'completed')->count();
        $totalTasks = $tasks->count();

        // Calculate project statistics
        $totalProjects = $projects->count();
        $activeProjects = $projects->where('proj_status', 'In Progress')->count();

        // Count tasks by status using groupBy
        $taskStatusChart = $tasks->groupBy('task_status')
            ->map(function ($group) {
                return $group->count();
            });

        // Ensure all statuses are present in the chart data
        $allStatuses = ['not_started', 'pending', 'in_progress', 'completed'];
        $taskStatusChart = collect($allStatuses)->mapWithKeys(function ($status) use ($taskStatusChart) {
            return [$status => $taskStatusChart->get($status, 0)];
        });

        // Calculate staff performance metrics
        $staffMetrics = $staff->map(function ($member) use ($tasks, $projects) {
            $memberTasks = $tasks->where('user_id', $member->id);
            $completedMemberTasks = $memberTasks->where('task_status', 'completed')->count();
            $totalMemberTasks = $memberTasks->count();
            
            return [
                'id' => $member->id,
                'name' => $member->name,
                'email' => $member->email,
                'total_tasks' => $totalMemberTasks,
                'completed_tasks' => $completedMemberTasks,
                'completion_rate' => $totalMemberTasks > 0 ? round(($completedMemberTasks / $totalMemberTasks) * 100) : 0,
                'active_projects' => $projects->where('user_id', $member->id)->where('proj_status', 'In Progress')->count()
            ];
        });

        return view('admin.dashboard', compact(
            'staff',
            'projects',
            'tasks',
            'completedTasks',
            'pendingTasks',
            'totalTasks',
            'totalProjects',
            'activeProjects',
            'taskStatusChart',
            'staffMetrics'
        ));
    }


}
