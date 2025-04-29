<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;

use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Project $project)
    {
        $tasks = $project->tasks()->with('user')->get(); // eager load user
        return view('tasks.index', compact('project', 'tasks'));
    }

    public function create()
{
    $projects = Project::all(); // Get all projects for dropdown

    return view('tasks.create', compact('projects'));
}

public function store(Request $request)
{
    $request->validate([
        'project_id' => 'required|exists:projects,id',
        'user_id' => 'nullable|exists:users,id',
        'task_name' => 'required|string|max:255',
        'task_desc' => 'nullable|string',
        'task_status' => 'required|in:not_started,pending,in_progress,completed',
        'task_priority' => 'required|in:low,medium,high',
        'due_date' => 'nullable|date',
        'task_attachments.*' => 'nullable|file|max:2048', // 2MB max per file
    ]);

    $attachments = [];

    if ($request->hasFile('task_attachments')) {
        foreach ($request->file('task_attachments') as $file) {
            $path = $file->store('attachments', 'public');
            $attachments[] = $path;
        }
    }

    Task::create([
        'project_id' => $request['project_id'],
        'user_id' => auth()->id() ?? 1, // default to user 1 for now
        'task_name' => $request->task_name,
        'task_desc' => $request->task_desc,
        'task_status' => $request->task_status,
        'task_priority' => $request->task_priority,
        'due_date' => $request->due_date,
        'task_attachments' => $attachments ? json_encode($attachments) : null,
    ]);

    return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
}




}
