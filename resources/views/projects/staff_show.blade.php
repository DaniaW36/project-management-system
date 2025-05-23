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
                            <h4 class="mb-0">{{ $project->proj_name }}</h4>
                            <p class="mb-0 opacity-8">Assigned to: {{ $project->user->name }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('staff.staff-projects.index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i>Back to Projects
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Details -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Project Details</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width: 200px;">Description</th>
                                <td>{{ $project->proj_desc }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    @php
                                        $statusClass = match($project->proj_status) {
                                            'In Progress' => 'bg-gradient-info',
                                            'Completed' => 'bg-gradient-success',
                                            'On Hold' => 'bg-gradient-warning',
                                            'Pending' => 'bg-gradient-secondary',
                                            default => 'bg-gradient-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }} text-white">
                                        {{ $project->proj_status }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Start Date</th>
                                <td>{{ $project->proj_start_date->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th>End Date</th>
                                <td>{{ $project->proj_end_date->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Status Details</th>
                                <td>{{ $project->proj_statusDetails ?? 'No additional details' }}</td>
                            </tr>
                            <tr>
                                <th>Last Updated</th>
                                <td>{{ $project->proj_latest_update->format('M d, Y H:i') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Project Tasks -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Project Tasks</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Task</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Priority</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Due Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($project->tasks as $task)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $task->task_name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ Str::limit($task->task_desc, 50) }}</p>
                                            </div>
                                        </div>
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