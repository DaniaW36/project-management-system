@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Project Details</h6>
                    <div>
                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-pencil-alt me-1"></i> Edit Project
                        </a>
                        <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left me-1"></i> Back to Projects
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Project Information</h5>
                            <table class="table">
                                <tr>
                                    <th style="width: 200px;">Project Name</th>
                                    <td>{{ $project->proj_name }}</td>
                                </tr>
                                <tr>
                                    <th>Description</th>
                                    <td>{{ $project->proj_desc }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @php
                                            $projectStatusClass = '';
                                            switch ($project->proj_status) {
                                                case 'Completed':
                                                    $projectStatusClass = 'success';
                                                    break;
                                                case 'In Progress':
                                                    $projectStatusClass = 'info';
                                                    break;
                                                case 'On Hold':
                                                case 'Pending':
                                                    $projectStatusClass = 'warning';
                                                    break;
                                                default:
                                                    $projectStatusClass = 'light';
                                            }
                                        @endphp
                                        <span class="badge badge-sm bg-gradient-{{ $projectStatusClass }}">
                                            {{ $project->proj_status }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Start Date</th>
                                    <td>{{ \Carbon\Carbon::parse($project->proj_start_date)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td> {{ \Carbon\Carbon::parse($project->proj_end_date)->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Assigned Staff</th>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            
                                            <div>
                                                <h6 class="mb-0">{{ $project->user->name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ $project->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5 class="mb-3">Attachments</h5>
                            @if($project->proj_attachments && count($project->proj_attachments) > 0)
                                <div class="list-group">
                                    @foreach($project->proj_attachments as $index => $attachment)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-file me-2"></i>
                                                {{ basename($attachment) }}
                                            </div>
                                            <div>
                                                <a href="{{ Storage::url($attachment) }}" class="btn btn-link text-info btn-sm" target="_blank">
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <form action="{{ route('admin.projects.delete-attachment', ['project' => $project, 'index' => $index]) }}" method="POST" class="d-inline">
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

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0">Project Tasks</h5>
                                <a href="{{ route('admin.tasks.create', ['project_id' => $project->id]) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-1"></i> Add Task
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Task</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Assigned To</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Priority</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Due Date</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($project->tasks as $task)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        <div class="d-flex flex-column justify-content-center">
                                                            <h6 class="mb-0 text-sm">{{ $task->task_name }}</h6>
                                                            <p class="text-xs text-secondary mb-0">{{ Str::limit($task->task_desc, 50) }}</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <p class="text-xs font-weight-bold mb-0">{{ $task->user->name }}</p>
                                                    <p class="text-xs text-secondary mb-0">{{ $task->user->email }}</p>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    @php
                                                        $taskStatusClass = '';
                                                        switch ($task->task_status) {
                                                            case 'completed':
                                                                $taskStatusClass = 'success';
                                                                break;
                                                            case 'in_progress':
                                                                $taskStatusClass = 'info';
                                                                break;
                                                            case 'pending':
                                                                $taskStatusClass = 'warning';
                                                                break;
                                                            case 'not_started':
                                                                $taskStatusClass = 'secondary';
                                                                break;
                                                            default:
                                                                $taskStatusClass = 'light';
                                                        }
                                                    @endphp
                                                    <span class="badge badge-sm bg-gradient-{{ $taskStatusClass }}">
                                                        {{ ucfirst(str_replace('_', ' ', $task->task_status)) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center text-sm">
                                                    <span class="badge badge-sm bg-gradient-{{ $task->task_priority === 'high' ? 'danger' : ($task->task_priority === 'medium' ? 'warning' : 'info') }}">
                                                        {{ ucfirst($task->task_priority) }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <span class="text-secondary text-xs font-weight-bold">
                                                        {{ $task->due_date ? $task->due_date->format('M d, Y') : 'Not set' }}
                                                    </span>
                                                </td>
                                                <td class="align-middle text-center">
                                                    <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-link text-warning px-3 mb-0">
                                                        <i class="fas fa-pencil-alt me-2"></i>Edit
                                                    </a>
                                                    <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link text-danger px-3 mb-0" onclick="return confirm('Are you sure you want to delete this task?')">
                                                            <i class="fas fa-trash me-2"></i>Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">
                                                    <p class="text-muted mb-0">No tasks found for this project.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 