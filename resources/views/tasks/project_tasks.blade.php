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
                            <h4 class="mb-0">Project Tasks</h4>
                            <p class="mb-0 opacity-8">{{ $project->proj_name }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('staff.projects.show', $project->id) }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i>Back to Project
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Tasks List</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
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
                                @forelse($tasks as $task)
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
                                                $statusClass = match($task->task_status) {
                                                    'completed' => 'bg-gradient-success',
                                                    'in_progress' => 'bg-gradient-info',
                                                    'pending' => 'bg-gradient-warning',
                                                    'not_started' => 'bg-gradient-secondary',
                                                    default => 'bg-gradient-secondary'
                                                };
                                            @endphp
                                            <span class="badge badge-sm {{ $statusClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $task->task_status)) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
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
                                            <a href="{{ route('staff.tasks.show', $task->id) }}" class="btn btn-link text-info px-3 mb-0">
                                                <i class="fas fa-eye me-2"></i>View
                                            </a>
                                            @if($task->user_id === auth()->id())
                                                <a href="{{ route('staff.tasks.edit', $task->id) }}" class="btn btn-link text-warning px-3 mb-0">
                                                    <i class="fas fa-pencil-alt me-2"></i>Edit
                                                </a>
                                            @endif
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
@endsection 