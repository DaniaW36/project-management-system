@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Edit Task</h5>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm">Back to Tasks</a>
    </div>

    <div class="card-body">
        <form action="{{ route('tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Task Name --}}
            <div class="mb-4">
                <label for="task_name" class="form-label text-uppercase text-muted">Task Name</label>
                <input type="text" name="task_name" id="task_name" class="form-control" value="{{ old('task_name', $task->task_name) }}" required>
            </div>

            {{-- Project Name --}}
            <div class="mb-4">
                <label for="project_id" class="form-label text-uppercase text-muted">Project</label>
                <select name="project_id" id="project_id" class="form-select" required>
                    <option value="">-- Select Project --</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                            {{ $project->proj_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Status --}}
            <div class="mb-4">
                <label for="task_status" class="form-label text-uppercase text-muted">Status</label>
                <select name="task_status" id="task_status" class="form-select" required>
                    <option value="not_started" {{ old('task_status', $task->task_status) == 'not_started' ? 'selected' : '' }}>Not Started</option>
                    <option value="pending" {{ old('task_status', $task->task_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ old('task_status', $task->task_status) == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ old('task_status', $task->task_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>

            {{-- Priority --}}
            <div class="mb-4">
                <label for="task_priority" class="form-label text-uppercase text-muted">Priority</label>
                <select name="task_priority" id="task_priority" class="form-select" required>
                    <option value="High" {{ old('task_priority', $task->task_priority) == 'High' ? 'selected' : '' }}>High</option>
                    <option value="Medium" {{ old('task_priority', $task->task_priority) == 'Medium' ? 'selected' : '' }}>Medium</option>
                    <option value="Low" {{ old('task_priority', $task->task_priority) == 'Low' ? 'selected' : '' }}>Low</option>
                </select>
            </div>

            {{-- Due Date --}}
            <div class="mb-4">
                <label for="due_date" class="form-label text-uppercase text-muted">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="form-control"
                value="{{ old('due_date', $task->due_date ?? '') }}">
            </div>

            {{-- Task Description --}}
            <div class="mb-4">
                <label for="task_desc" class="form-label text-uppercase text-muted">Task Description</label>
                <textarea name="task_desc" id="task_desc" class="form-control" rows="4">{{ old('task_desc', $task->task_desc) }}</textarea>
            </div>

            {{-- Attachments (Optional) --}}
            @php
    $attachments = json_decode($task->task_attachments, true) ?? [];
@endphp

@if (!empty($attachments))
    <ul>
        @foreach ($attachments as $attachment)
            <li>
                <a href="{{ asset('storage/' . $attachment) }}" target="_blank">{{ basename($attachment) }}</a>
            </li>
        @endforeach
    </ul>
@endif


            {{-- Submit Button --}}
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">Update Task</button>
            </div>

        </form>
    </div>
</div>
@endsection
