<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function index()
    {
        $projects = Project::with(['user'])->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        $users = User::where('role', 'staff')->get();
        return view('admin.projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'proj_name' => 'required|string|max:255',
            'proj_desc' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'proj_start_date' => 'required|date',
            'proj_end_date' => 'required|date|after_or_equal:proj_start_date',
            'proj_status' => 'required|in:In Progress,On Hold,Completed,Pending',
            'proj_statusDetails' => 'nullable|string',
            'proj_attachments.*' => 'nullable|file|max:2048'
        ]);

        $attachments = [];
        if ($request->hasFile('proj_attachments')) {
            foreach ($request->file('proj_attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->storeAs('attachments', $originalName, 'public');
                $attachments[] = $path;
            }
        }

        Project::create([
            'proj_name' => $validated['proj_name'],
            'proj_desc' => $validated['proj_desc'],
            'user_id' => $validated['user_id'],
            'created_by' => auth()->id(),
            'proj_start_date' => $validated['proj_start_date'],
            'proj_end_date' => $validated['proj_end_date'],
            'proj_status' => $validated['proj_status'],
            'proj_statusDetails' => $validated['proj_statusDetails'] ?? null,
            'proj_latest_update' => now(),
            'proj_attachments' => $attachments
        ]);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        $project->load(['user', 'tasks.user']);
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $users = User::where('role', 'staff')->get();
        return view('admin.projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'proj_name' => 'required|string|max:255',
            'proj_desc' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'proj_start_date' => 'required|date',
            'proj_end_date' => 'required|date|after_or_equal:proj_start_date',
            'proj_status' => 'required|in:In Progress,On Hold,Completed,Pending',
            'proj_statusDetails' => 'nullable|string',
            'proj_attachments.*' => 'nullable|file|max:2048'
        ]);

        $attachments = $project->proj_attachments;
        
        if ($request->hasFile('proj_attachments')) {
            foreach ($request->file('proj_attachments') as $file) {
                $originalName = $file->getClientOriginalName();
                $path = $file->storeAs('attachments', $originalName, 'public');
                $attachments[] = $path;
            }
        }

        $project->update([
            'proj_name' => $validated['proj_name'],
            'proj_desc' => $validated['proj_desc'],
            'user_id' => $validated['user_id'],
            'proj_start_date' => $validated['proj_start_date'],
            'proj_end_date' => $validated['proj_end_date'],
            'proj_status' => $validated['proj_status'],
            'proj_statusDetails' => $validated['proj_statusDetails'] ?? null,
            'proj_latest_update' => now(),
            'proj_attachments' => $attachments
        ]);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        // Delete project attachments from storage
        if (!empty($project->proj_attachments)) {
            $attachments = $project->proj_attachments;
            foreach ($attachments as $attachment) {
                \Storage::disk('public')->delete($attachment);
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    public function deleteAttachment(Project $project, $index)
    {
        $attachments = $project->proj_attachments ?? [];

        if (isset($attachments[$index])) {
            // Delete file from storage using Laravel's Storage facade
            Storage::disk('public')->delete($attachments[$index]);

            // Remove the attachment and reindex the array
            unset($attachments[$index]);
            $attachments = array_values($attachments);

            // Update the project with the new attachments array
            $project->update([
                'proj_attachments' => $attachments
            ]);

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Attachment deleted successfully.']);
            }

            return redirect()->back()
                ->with('success', 'Attachment deleted successfully.');
        }

        if (request()->ajax() || request()->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Attachment not found.'], 404);
        }

        return redirect()->back()
            ->with('error', 'Attachment not found.');
    }
} 