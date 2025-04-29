@extends('layouts.master')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Task Details</h5>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary btn-sm">Back to Tasks</a>
    </div>

    <div class="card-body">

        {{-- Task Name --}}
        <div class="mb-4">
            <h6 class="text-uppercase text-muted mb-1">Task Name</h6>
            <p class="fw-bold text-dark mb-0">{{ $task->task_name }}</p>
        </div>

        {{-- Project Name --}}
        <div class="mb-4">
            <h6 class="text-uppercase text-muted mb-1">Project Name</h6>
            <p class="fw-bold text-dark mb-0">{{ $task->project->proj_name ?? '-' }}</p>
        </div>

        {{-- Status --}}
        <div class="mb-4">
            <h6 class="text-uppercase text-muted mb-1">Status</h6>
            @php
                $status = strtolower(trim($task->task_status ?? ''));
                $statusClass = match($status) {
                    'not_started' => 'bg-gradient-warning',
                    'pending' => 'bg-gradient-info',
                    'in_progress' => 'bg-gradient-secondary',
                    'completed' => 'bg-gradient-success',
                    default => 'bg-gradient-light'
                };
            @endphp
            <span class="badge {{ $statusClass }} text-white px-3 py-2 text-capitalize">
                {{ str_replace('_', ' ', $task->task_status) }}
            </span>
        </div>

        {{-- Priority --}}
        <div class="mb-4">
            <h6 class="text-uppercase text-muted mb-1">Priority</h6>
            @php
                $priority = ucfirst(strtolower($task->task_priority ?? ''));
                $priorityClass = match($priority) {
                    'High' => 'bg-gradient-danger',
                    'Medium' => 'bg-gradient-warning',
                    'Low' => 'bg-gradient-info',
                    default => 'bg-gradient-light'
                };
            @endphp
            <span class="badge {{ $priorityClass }} text-white px-3 py-2 text-capitalize">
                {{ $priority }}
            </span>
        </div>

        {{-- Due Date --}}
        <div class="mb-4">
            <h6 class="text-uppercase text-muted mb-1">Due Date</h6>
            @if ($task->due_date)
                @php
                    $due = \Carbon\Carbon::parse($task->due_date);
                    $now = now();
                    $dueClass = $due->isPast() && !$due->isToday() ? 'text-danger fw-bold' : ($due->isToday() ? 'text-warning fw-bold' : 'text-dark');
                @endphp
                <p class="{{ $dueClass }} mb-0">{{ $due->format('d M Y') }}</p>
            @else
                <p class="text-muted mb-0">No Due Date</p>
            @endif
        </div>

        {{-- Task Description --}}
        <div class="mb-4">
            <h6 class="text-uppercase text-muted mb-1">Task Description</h6>
            <p class="text-dark">{{ $task->task_desc ?? '-' }}</p>
        </div>

        {{-- Attachments --}}
        <div>
            <h6 class="text-uppercase text-muted mb-1">Attachments</h6>
            @if ($task->attachments && count($task->attachments))
                <ul class="list-group list-group-flush">
                    @foreach ($task->attachments as $attachment)
                        <li class="list-group-item">
                            <a href="{{ asset('storage/'.$attachment->file_path) }}" target="_blank" class="text-decoration-underline">
                                📎 {{ $attachment->file_name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted mb-0">No attachments available.</p>
            @endif
        </div>

    </div>
</div>
@endsection
