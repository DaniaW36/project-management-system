<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;

use Illuminate\Http\Request;

class TaskController extends Controller
{

    public function __construct()
    {
        // Apply auth middleware to ensure only authenticated users can access these methods
        $this->middleware('auth');
    }

    public function index(Request $request)
{
    $projects = Project::where('user_id', auth()->id())->get();
    $query = Task::where('user_id', auth()->id())->with(['project', 'user']); // Eager load project + user

    if ($request->filled('project_id')) {
        $query->where('project_id', $request->project_id);
    }

    $tasks = $query->get();

    return view('tasks.index', compact('tasks', 'projects'));
}


     // Show tasks for a specific project
     public function projectTasks(Project $project)
     {
         $tasks = $project->tasks()->with('user')->get();
         return view('tasks.project_tasks', compact('project', 'tasks'));
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
        'user_id' => auth()->id(), // default to user 1 for now
        'task_name' => $request->task_name,
        'task_desc' => $request->task_desc,
        'task_status' => $request->task_status,
        'task_priority' => $request->task_priority,
        'due_date' => $request->due_date,
        'task_attachments' => $attachments ? json_encode($attachments) : null,
    ]);

    return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
}

public function show($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        return view('tasks.show', compact('task'));
    }

    public function edit($id)
{
    $task = Task::where('user_id', auth()->id())->findOrFail($id);
    $projects = Project::all(); // for the project dropdown

    return view('tasks.edit', compact('task', 'projects'));
}

public function update(Request $request, $id)
{
    $task = Task::findOrFail($id);

    $validated = $request->validate([
        'task_name' => 'required|string|max:255',
        'project_id' => 'required|exists:projects,id',
        'task_status' => 'required|in:not_started,pending,in_progress,completed',
        'task_priority' => 'required|in:High,Medium,Low',
        'due_date' => 'nullable|date',
        'task_desc' => 'nullable|string',
        'attachments.*' => 'nullable|file|max:2048' // max 2MB per file
    ]);

    $task->update([
        'task_name' => $validated['task_name'],
        'project_id' => $validated['project_id'],
        'task_status' => $validated['task_status'],
        'task_priority' => $validated['task_priority'],
        'due_date' => $validated['due_date'] ?? null,
        'task_desc' => $validated['task_desc'] ?? null,
    ]);

    // Handle new attachments
    if ($request->hasFile('attachments')) {
        foreach ($request->file('attachments') as $file) {
            $filePath = $file->store('attachments', 'public');

            $task->attachments()->create([
                'file_name' => $file->getClientOriginalName(),
                'file_path' => $filePath,
            ]);
        }
    }

    return redirect()->route('tasks.show', $task->id)
                     ->with('success', 'Task updated successfully.');
}

public function destroy($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

}
