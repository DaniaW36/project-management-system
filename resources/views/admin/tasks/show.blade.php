@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Task Details</h6>
                    <div>
                        <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-pencil-alt me-1"></i> Edit Task
                        </a>
                        <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to Tasks
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Task Information</h5>
                            <table class="table">
                                <tr>
                                    <th style="width: 200px;">Task Name</th>
                                    <td>{{ $task->task_name }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $task->task_desc }}</td>
                                </tr>
                                <tr>
                                    <th>Project</th>
                                    <td>
                                        <a href="{{ route('admin.projects.show', $task->project) }}" class="text-info">
                                            {{ $task->project->proj_name }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @php
                                            $statusClass = '';
                                            switch ($task->task_status) {
                                                case 'completed':
                                                    $statusClass = 'success';
                                                    break;
                                                case 'in_progress':
                                                    $statusClass = 'info';
                                                    break;
                                                case 'pending':
                                                    $statusClass = 'warning';
                                                    break;
                                                case 'not_started':
                                                    $statusClass = 'secondary';
                                                    break;
                                                default:
                                                    $statusClass = 'light';
                                            }
                                        @endphp
                                        <span class="badge badge-sm bg-gradient-{{ $statusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->task_status)) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Priority</th>
                                    <td>
                                        <span class="badge badge-sm bg-gradient-{{ $task->task_priority === 'high' ? 'danger' : ($task->task_priority === 'medium' ? 'warning' : 'info') }}">
                                            {{ ucfirst($task->task_priority) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Due Date</th>
                                    <td>{{ $task->due_date ? $task->due_date->format('M d, Y') : 'Not set' }}</td>
                                </tr>
                                <tr>
                                    <th>Assigned To</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($task->user && $task->user->profile_pic)
                                                <img src="{{ asset('storage/' . $task->user->profile_pic) }}" alt="profile_image" class="avatar avatar-md me-3">
                                            @elseif($task->user)
                                                <div class="avatar avatar-md me-3 bg-gradient-dark d-flex align-items-center justify-content-center">
                                                    <span class="text-white text-lg">{{ strtoupper(substr($task->user->name, 0, 1)) }}</span>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="mb-0">{{ $task->user->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $task->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">Attachments</h5>
                            @if($task->task_attachments && count($task->task_attachments) > 0)
                                <div class="list-group">
                                    @foreach($task->task_attachments as $index => $attachment)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-file me-2"></i>
                                                {{ basename($attachment) }}
                                            </div>
                                            <div>
                                                <a href="{{ Storage::url($attachment) }}" class="btn btn-link text-info btn-sm" target="_blank">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <form action="{{ route('admin.tasks.delete-attachment', ['task' => $task, 'index' => $index]) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger btn-sm" onclick="return confirm('Are you sure you want to delete this attachment?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted">No attachments found.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 