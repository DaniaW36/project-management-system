@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Tasks</h6>
                    <a href="{{ route('admin.tasks.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> New Task
                    </a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Task</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Project</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Created By</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Priority</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Due Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Assigned To</th>
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
                                            <p class="text-xs font-weight-bold mb-0">{{ $task->project->proj_name }}</p>
                                        </td>
                                        <td>
                                            @if($task->creator)
                                                <p class="text-xs font-weight-bold mb-0">{{ $task->creator->name }}</p>
                                                <p class="text-xs text-secondary mb-0">{{ $task->creator->email }}</p>
                                            @else
                                                <p class="text-xs text-secondary mb-0">Unknown creator</p>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center text-sm">
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
                                        <td class="align-middle text-center text-sm">
                                            <span class="badge badge-sm bg-gradient-{{ $task->task_priority === 'high' ? 'danger' : ($task->task_priority === 'medium' ? 'warning' : 'info') }}">
                                                {{ ucfirst($task->task_priority) }}
                                            </span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span class="text-secondary text-xs font-weight-bold">{{ $task->due_date->format('M d, Y') }}</span>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="d-flex align-items-center justify-content-center">
                                                
                                                <div>
                                                    <h6 class="mb-0 text-sm">{{ $task->user->name }}</h6>
                                                    <p class="text-xs text-secondary mb-0">{{ $task->user->email }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('admin.tasks.show', $task) }}" class="btn btn-link text-info px-3 mb-0" title="View">
                                                    <i class="fas fa-eye text-info me-2"></i>View
                                                </a>
                                                <a href="{{ route('admin.tasks.edit', $task) }}" class="btn btn-link text-warning px-3 mb-0" title="Edit">
                                                    <i class="fas fa-pencil-alt text-warning me-2"></i>Edit
                                                </a>
                                                <form action="{{ route('admin.tasks.destroy', $task) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link text-danger px-3 mb-0" 
                                                            onclick="return confirm('Are you sure you want to delete this task?')" title="Delete">
                                                        <i class="fas fa-trash text-danger me-2"></i>Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-muted mb-0">No tasks found.</p>
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