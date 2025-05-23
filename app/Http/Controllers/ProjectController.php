<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::where('user_id', auth()->id())->get();
        return view('projects.index', compact(['projects']));
    }

    public function show($id)
    {
        $project = Project::findorFail($id);
        return view('projects.show', compact('project'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'proj_name' => 'required|string|max:255',
            'proj_desc' => 'required|string',
            'proj_status' => 'required',
            'proj_statusDetails' => 'nullable',
            'proj_start_date' => 'required|date',
            'proj_end_date' => 'required|date|after_or_equal:proj_start_date',
            'proj_attachments' => 'nullable|array',
            'proj_attachments.*' => 'file|max:10240',

        ]);

        $attachments = [];

        if ($request->hasFile('proj_attachments')) {
            foreach ($request->file('proj_attachments') as $file) {
                $path = $file->storeAs('attachments', $file->getClientOriginalName(), 'public');
                $attachments[] = $path;
            }
        }

        Project::create([
            'proj_name' => $request->proj_name,
            'proj_desc' => $request->proj_desc,
            'proj_status' => $request->proj_status,
            'proj_statusDetails' => $request->proj_statusDetails,
            'proj_start_date' => $request->proj_start_date,
            'proj_end_date' => $request->proj_end_date,
            'proj_latest_update' => now(),
            'proj_attachments' => $attachments,
            'user_id' => auth()->id(), // Assuming logged-in user is the project owner
        ]);

        return redirect()->route('staff.projects.index')->with('success', 'Project created successfully.');
    }

    public function edit($id)
    {
        $projects = Project::findOrFail($id);
        return view('projects.edit', compact('projects'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'proj_name' => 'required|string|max:255',
            'proj_desc' => 'required|string',
            'proj_status' => 'required',
            'proj_statusDetails' => 'nullable',
            'proj_start_date' => 'required|date',
            'proj_end_date' => 'required|date|after_or_equal:proj_start_date',
            'proj_attachments.*' => 'nullable|file|max:10240', // max 10MB

        ]);

        $project = Project::findOrFail($id);

        $attachments = $project->proj_attachments ?? [];

        // Handle new attachments
        if ($request->hasFile('proj_attachments')) {
            foreach ($request->file('proj_attachments') as $file) {
                $path = $file->storeAs('attachments', $file->getClientOriginalName(), 'public');
                $attachments[] = $path;
            }
        }

        // Save solution
        $project->update([
            'proj_name' => $request->proj_name,
            'proj_desc' => $request->proj_desc,
            'proj_status' => $request->proj_status,
            'proj_statusDetails' => $request->proj_statusDetails,
            'proj_start_date' => $request->proj_start_date,
            'proj_end_date' => $request->proj_end_date,
            'proj_latest_update' => now(),
            'proj_attachments' => $attachments,
        ]);

        return redirect()->route('staff.projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy($id)
    {
        $projects = Project::findOrFail($id);
        $projects->delete();

        return redirect()->route('staff.projects.index')->with('success', 'Project deleted successfully.');
    }

    public function deleteAttachment(Request $request, Project $project, $index)
    {
        $attachments = $project->proj_attachments ?? [];

        if (isset($attachments[$index])) {
            $fileToDelete = $attachments[$index];

            // Delete file from storage
            Storage::disk('public')->delete($fileToDelete);

            // Remove the attachment and reindex the array
            unset($attachments[$index]);
            $project->proj_attachments = array_values($attachments); // Eloquent handles array to JSON conversion
            $project->save();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Attachment deleted successfully.']);
            }
            // Fallback for non-AJAX, though less likely to be used now
            return redirect()->route('staff.projects.edit', $project->id)->with('success', 'Attachment deleted successfully.');
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Attachment not found or already deleted.'], 404);
        }
        // Fallback for non-AJAX
        return redirect()->route('staff.projects.edit', $project->id)->with('error', 'Attachment not found.');
    }

    /**
     * Display a listing of other staff's projects.
     */
    public function staffProjects()
    {
        $projects = Project::with(['user', 'tasks'])
            ->where('user_id', '!=', auth()->id())
            ->latest()
            ->get();

        return view('projects.staff_index', compact('projects'));
    }

    /**
     * Display the specified staff project in read-only mode.
     */
    public function staffProjectShow($id)
    {
        $project = Project::with(['user', 'tasks.user'])
            ->where('user_id', '!=', auth()->id())
            ->findOrFail($id);

        return view('projects.staff_show', compact('project'));
    }
}
