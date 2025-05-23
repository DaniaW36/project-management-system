@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">{{ $task->task_name }}</h4>
                            <p class="mb-0 opacity-8">Assigned to: {{ $task->user->name }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('staff.staff-tasks.index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i>Back to Tasks
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Details -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Task Details</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width: 200px;">Description</th>
                                <td>{{ $task->task_desc }}</td>
                            </tr>
                            <tr>
                                <th>Project</th>
                                <td>{{ $task->project->proj_name ?? 'Not assigned to any project' }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @php
                                        $statusClass = match($task->task_status) {
                                            'completed' => 'bg-gradient-success',
                                            'in_progress' => 'bg-gradient-info',
                                            'pending' => 'bg-gradient-warning',
                                            'not_started' => 'bg-gradient-secondary',
                                            default => 'bg-gradient-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} text-white">
                                        {{ ucfirst(str_replace('_', ' ', $task->task_status)) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Priority</th>
                                <td>{{ ucfirst($task->task_priority) }}</td>
                            </tr>
                            <tr>
                                <th>Due Date</th>
                                <td>{{ $task->due_date->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Assigned To</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <h6 class="mb-0">{{ $task->user->name }}</h6>
                                            <p class="text-xs text-secondary mb-0">{{ $task->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attachments Section -->
    @if(!empty($task->task_attachments))
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Attachments</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($task->task_attachments as $attachment)
                        <div class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                            <div>
                                <i class="fas fa-paperclip me-2"></i>
                                {{ basename($attachment) }}
                            </div>
                            <a href="{{ Storage::url($attachment) }}" class="btn btn-link text-primary" target="_blank">
                                <i class="fas fa-download"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 