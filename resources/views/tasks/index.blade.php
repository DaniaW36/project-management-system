@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Tasks for Project: {{ $project->proj_name }}</h2>

    @if($tasks->count())
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Task Name</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Assigned To</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->task_name }}</td>
                    <td><span class="badge bg-secondary text-capitalize">{{ str_replace('_', ' ', $task->task_status) }}</span></td>
                    <td><span class="badge bg-info text-capitalize">{{ $task->task_priority }}</span></td>
                    <td>{{ $task->due_date ? $task->due_date->format('d M Y') : '-' }}</td>
                    <td>{{ $task->user->name ?? 'Unassigned' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No tasks found for this project.</p>
    @endif

    <a href="{{ route('projects.index') }}" class="btn btn-primary mt-3">Back to Projects</a>
</div>
@endsection
