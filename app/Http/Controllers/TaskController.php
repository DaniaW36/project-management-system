<?php

namespace App\Http\Controllers;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\Storage;

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
        'task_priority' => 'required',
        'due_date' => [
            'required',
            'date',
            function ($attribute, $value, $fail) use ($request) {
                $project = Project::find($request->project_id);
                if ($project) {
                    if ($value < $project->proj_start_date || $value > $project->proj_end_date) {
                        $fail('The task due date must be between the project start date (' . $project->proj_start_date->format('M d, Y') . ') and end date (' . $project->proj_end_date->format('M d, Y') . ').');
                    }
                }
            },
        ],
        'task_attachments.*' => 'nullable|file|max:2048', // 2MB max per file
    ]);

    $attachments = [];

    if ($request->hasFile('task_attachments')) {
        foreach ($request->file('task_attachments') as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $uniqueName = $fileName . '_' . time() . '.' . $extension;
            $path = $file->storeAs('task-attachments', $uniqueName, 'public');
            $attachments[] = $path;
        }
    }

    Task::create([
        'project_id' => $request['project_id'],
        'user_id' => auth()->id(), // default to user 1 for now
        'created_by' => auth()->id(), // Set the creator to the current user
        'task_name' => $request->task_name,
        'task_desc' => $request->task_desc,
        'task_status' => $request->task_status,
        'task_priority' => $request->task_priority,
        'due_date' => $request->due_date,
        'task_attachments' => $attachments ? json_encode($attachments) : null,
    ]);

    return redirect()->route('staff.tasks.index')->with('success', 'Task created successfully.');
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
        'task_priority' => 'required|in:low,medium,high',
        'due_date' => [
            'required',
            'date',
            function ($attribute, $value, $fail) use ($request) {
                $project = Project::find($request->project_id);
                if ($project) {
                    if ($value < $project->proj_start_date || $value > $project->proj_end_date) {
                        $fail('The task due date must be between the project start date (' . $project->proj_start_date->format('M d, Y') . ') and end date (' . $project->proj_end_date->format('M d, Y') . ').');
                    }
                }
            },
        ],
        'task_desc' => 'nullable|string',
        'task_attachments.*' => 'nullable|file|max:2048' // Fixed the field name
    ]);

    // Get existing attachments
    $attachments = $task->task_attachments ?? [];

    // Handle new attachments
    if ($request->hasFile('task_attachments')) {
        foreach ($request->file('task_attachments') as $file) {
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $uniqueName = $fileName . '_' . time() . '.' . $extension;
            $path = $file->storeAs('task-attachments', $uniqueName, 'public');
            $attachments[] = $path;
        }
    }

    // Update the task
    $task->update([
        'task_name' => $validated['task_name'],
        'project_id' => $validated['project_id'],
        'task_status' => $validated['task_status'],
        'task_priority' => $validated['task_priority'],
        'due_date' => $validated['due_date'] ?? null,
        'task_desc' => $validated['task_desc'] ?? null,
        'task_attachments' => $attachments // Already an array, mutator will handle json_encode
    ]);

    return redirect()->route('staff.tasks.show', $task->id)
                     ->with('success', 'Task updated successfully.');
}

public function destroy($id)
    {
        $task = Task::where('user_id', auth()->id())->findOrFail($id);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

public function deleteAttachment(Task $task, $index)
{
    // Ensure task_attachments is an array
    $attachments = $task->task_attachments ?? [];
    
    if (isset($attachments[$index])) {
        // Delete file from storage
        Storage::disk('public')->delete($attachments[$index]);

        // Remove the attachment and reindex the array
        unset($attachments[$index]);
        $attachments = array_values($attachments);

        // Update the task with the new attachments
        $task->update([
            'task_attachments' => $attachments
        ]);

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Attachment deleted successfully.']);
        }

        return redirect()->back()->with('success', 'Attachment deleted successfully.');
    }

    if (request()->ajax() || request()->wantsJson()) {
        return response()->json(['success' => false, 'message' => 'Attachment not found.'], 404);
    }

    return redirect()->back()->with('error', 'Attachment not found.');
}

    /**
     * Display a listing of other staff's tasks.
     */
    public function staffTasks()
    {
        $tasks = Task::with(['project', 'user', 'creator'])
            ->where('user_id', '!=', auth()->id())
            ->latest()
            ->get();

        return view('tasks.staff_index', compact('tasks'));
    }

    /**
     * Display the specified staff task in read-only mode.
     */
    public function staffTaskShow($id)
    {
        $task = Task::with(['project', 'user', 'creator'])
            ->where('user_id', '!=', auth()->id())
            ->findOrFail($id);

        return view('tasks.staff_show', compact('task'));
    }
}
