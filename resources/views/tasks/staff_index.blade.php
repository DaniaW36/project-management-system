@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Other Staff Tasks</h6>
                        <a href="{{ route('staff.tasks.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to My Tasks
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Task</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Project</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Assigned To</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created By</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Priority</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Due Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($tasks as $task)
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
                                        <p class="text-xs font-weight-bold mb-0">{{ $task->project->proj_name ?? 'No Project' }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ $task->user->name }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $task->user->email }}</p>
                                    </td>
                                    <td class="align-middle text-center">
                                        @if($task->creator)
                                            <p class="text-xs font-weight-bold mb-0">{{ $task->creator->name }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $task->creator->email }}</p>
                                        @else
                                            <p class="text-xs text-secondary mb-0">Unknown creator</p>
                                        @endif
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
                                        <span class="badge badge-sm {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $task->task_status)) }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ ucfirst($task->task_priority) }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $task->due_date->format('M d, Y') }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('staff.staff-tasks.show', $task->id) }}" 
                                           class="btn btn-link text-primary px-3 mb-0"
                                           data-bs-toggle="tooltip" 
                                           data-bs-original-title="View task">
                                            <i class="fas fa-eye text-primary me-2"></i>View
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 