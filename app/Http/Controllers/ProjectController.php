<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('projects.index', compact(['projects']));
    }

    public function show($id)
    {
        $projects = Project::findorFail($id);
        return view('projects.show', compact(['projects']));
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
            'proj_attachments' => json_encode ($attachments),
            'user_id' => 1  //auth()->id(), // Assuming logged-in user is the project owner
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
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

$projects = Project::findOrFail($id);

$attachments  = json_decode($projects->proj_attachments, true) ?? [];

 // Handle new attachments
 if ($request->hasFile('proj_attachments')) {
    foreach ($request->file('proj_attachments') as $file) {
        $path = $file->storeAs('attachments', $file->getClientOriginalName(), 'public');
        $attachments[] = $path;
    }
}

// Save solution
$projects->update([
            'proj_name' => $request->proj_name,
            'proj_desc' => $request->proj_desc,
            'proj_status' => $request->proj_status,
            'proj_statusDetails' => $request->proj_statusDetails,
            'proj_start_date' => $request->proj_start_date,
            'proj_end_date' => $request->proj_end_date,
            'proj_latest_update' => now(),
            'proj_attachments' => json_encode ($attachments),
            'user_id' => 1  //auth()->id(), // Assuming logged-in user is the project owner
        ]);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');

    }

    public function destroy($id)
    {
        $projects = Project::findOrFail($id);
        $projects->delete();

        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
    public function deleteAttachment(Project $project, $index)
    {
        // Get the attachments array
        $attachments = json_decode($project->proj_attachments, true) ?? [];

        // Check if the attachment exists in the array
        if (isset($attachments[$index])) {
            // Get the file path
            $filePath = storage_path('app/public/' . $attachments[$index]);

            // Delete file from storage
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Remove the attachment and reindex the array
            unset($attachments[$index]);
            $attachments = array_values($attachments);

            // Update the project with the new attachments
            $project->update([
                'proj_attachments' => json_encode($attachments)
            ]);
        }

        // Redirect back with a success message
        return redirect()->route('projects.edit', $project->id)->with('success', 'Attachment deleted successfully.');
    }


}
