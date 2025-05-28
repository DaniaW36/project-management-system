<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $tasks = Task::with(['project', 'user', 'creator'])->latest()->get();
        return view('admin.tasks.index', compact('tasks'));
    }

    public function create()
    {
        $projects = Project::all();
        $users = User::all();
        return view('admin.tasks.create', compact('projects', 'users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'task_name' => 'required|string|max:255',
            'task_desc' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
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
            'task_attachments.*' => 'nullable|file|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $task = Task::create([
            'task_name' => $request->task_name,
            'task_desc' => $request->task_desc,
            'project_id' => $request->project_id,
            'user_id' => $request->user_id,
            'created_by' => auth()->id(),
            'task_status' => $request->task_status,
            'task_priority' => $request->task_priority,
            'due_date' => $request->due_date
        ]);

        if ($request->hasFile('task_attachments')) {
            $attachments = [];
            foreach ($request->file('task_attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = pathinfo($originalName, PATHINFO_FILENAME);
                $uniqueName = $fileName . '_' . time() . '.' . $extension;
                $path = $file->storeAs('task-attachments', $uniqueName, 'public');
                $attachments[] = $path;
            }
            $task->task_attachments = $attachments;
            $task->save();
        }

        return redirect()->route('admin.tasks.show', $task)
            ->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $task->load(['project', 'user', 'creator']);
        return view('admin.tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $projects = Project::all();
        $users = User::all();
        return view('admin.tasks.edit', compact('task', 'projects', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'task_name' => 'required|string|max:255',
            'task_desc' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'user_id' => 'required|exists:users,id',
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
            'task_attachments.*' => 'nullable|file|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $task->update([
            'task_name' => $request->task_name,
            'task_desc' => $request->task_desc,
            'project_id' => $request->project_id,
            'user_id' => $request->user_id,
            'task_status' => $request->task_status,
            'task_priority' => $request->task_priority,
            'due_date' => $request->due_date
        ]);

        if ($request->hasFile('task_attachments')) {
            $attachments = $task->task_attachments ?? [];
            foreach ($request->file('task_attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $fileName = pathinfo($originalName, PATHINFO_FILENAME);
                $uniqueName = $fileName . '_' . time() . '.' . $extension;
                $path = $file->storeAs('task-attachments', $uniqueName, 'public');
                $attachments[] = $path;
            }
            $task->task_attachments = $attachments;
            $task->save();
        }

        return redirect()->route('admin.tasks.show', $task)
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        // Delete attachments
        if ($task->task_attachments) {
            foreach ($task->task_attachments as $attachment) {
                Storage::delete($attachment);
            }
        }

        $task->delete();

        return redirect()->route('admin.tasks.index')
            ->with('success', 'Task deleted successfully.');
    }

    public function deleteAttachment(Task $task, $index)
    {
        $attachments = $task->task_attachments;
        
        if (isset($attachments[$index])) {
            Storage::delete($attachments[$index]);
            unset($attachments[$index]);
            $task->task_attachments = array_values($attachments);
            $task->save();
        }

        return redirect()->back()
            ->with('success', 'Attachment deleted successfully.');
    }
} 