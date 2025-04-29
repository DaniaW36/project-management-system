@extends('layouts.master')

@section('content')
<div class="card mb-4">
    <h2>Create New Task</h2>

    <div class="card-body px-2 pt-0 pb-2">
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Project Dropdown --}}
        <div class="mb-3">
            <label for="project_id" class="form-label">Project</label>
            <select name="project_id" class="form-select" required>
                <option value="">Select a project</option>
                @foreach($projects as $project)
                    <option value="{{ $project->id }}">{{ $project->project_name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Task Name --}}
        <div class="mb-3">
            <label for="task_name" class="form-label">Task Name</label>
            <input type="text" name="task_name" class="form-control" required>
        </div>

        {{-- Task Description --}}
        <div class="mb-3">
            <label for="task_desc" class="form-label">Task Description</label>
            <textarea name="task_desc" class="form-control" rows="3"></textarea>
        </div>

        {{-- Task Status --}}
        <div class="mb-3">
            <label for="task_status" class="form-label">Status</label>
            <select name="task_status" class="form-select" required>
                <option value="not_started">Not Started</option>
                <option value="pending">Pending</option>
                <option value="in_progress">In Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        {{-- Task Priority --}}
        <div class="mb-3">
            <label for="task_priority" class="form-label">Priority</label>
            <select name="task_priority" class="form-select" required>
                <option value="low">Low</option>
                <option value="medium" selected>Medium</option>
                <option value="high">High</option>
            </select>
        </div>

        {{-- Due Date --}}
        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" name="due_date" class="form-control">
        </div>

        {{-- File Upload --}}
        <div class="mb-3">
            <label for="task_attachments" class="form-label">Attachments (multiple files allowed)</label>
            <input type="file" name="task_attachments[]" class="form-control" multiple>
        </div>

        <button type="submit" class="btn btn-primary">Create Task</button>
    </form>
</div>
@endsection
