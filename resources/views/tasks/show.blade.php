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
                            <p class="mb-0 opacity-8">{{ $task->project->proj_name ?? 'Not assigned to any project' }}</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-light">
                                <i class="fas fa-edit me-2"></i>Edit Task
                            </a>
                            <a href="{{ route('tasks.index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i>Back to Tasks
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Task Description Card -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Description</h6>
                </div>
                <div class="card-body">
                    <p class="text-dark mb-0">{{ $task->task_desc ?? 'No description provided' }}</p>
                </div>
            </div>

            <!-- Progress Card -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Progress</h6>
                </div>
                <div class="card-body">
                    @php
                        $status = $task->task_status;
                        $percent = 0;
                        $barClass = '';

                        if ($status == 'not_started') {
                            $percent = 0;
                            $barClass = 'bg-gradient-secondary';
                        } elseif ($status == 'pending') {
                            $percent = 25;
                            $barClass = 'bg-gradient-warning';
                        } elseif ($status == 'in_progress') {
                            $percent = 50;
                            $barClass = 'bg-gradient-info';
                        } elseif ($status == 'completed') {
                            $percent = 100;
                            $barClass = 'bg-gradient-success';
                        }
                    @endphp
                    <div class="d-flex align-items-center">
                        <span class="me-2 text-xs font-weight-bold">{{ $percent }}%</span>
                        <div class="progress flex-grow-1" style="height: 8px;">
                            <div class="progress-bar {{ $barClass }}" role="progressbar" 
                                style="width: {{ $percent }}%;" 
                                aria-valuenow="{{ $percent }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attachments Card -->
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Attachments</h6>
                </div>
                <div class="card-body">
                    @php
                        $attachments = is_array($task->task_attachments)
                            ? $task->task_attachments
                            : json_decode($task->task_attachments, true);
                    @endphp
                    @if(!empty($attachments))
                        <div class="row">
                            @foreach($attachments as $file)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        @if(in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/' . $file) }}" class="card-img-top" alt="Attachment">
                                        @else
                                            <div class="card-body text-center">
                                                <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                                <h6 class="card-title">{{ basename($file) }}</h6>
                                            </div>
                                        @endif
                                        <div class="card-footer">
                                            <a href="{{ asset('storage/' . $file) }}" 
                                               class="btn btn-sm btn-primary w-100" 
                                               target="_blank">
                                                <i class="fas fa-eye me-2"></i>View
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-muted mb-0">No attachments available</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Task Info Card -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Task Information</h6>
                </div>
                <div class="card-body">
                    <!-- Status -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-2">Status</h6>
                        <span class="badge badge-sm
                            @if($task->task_status == 'in_progress') bg-gradient-info
                            @elseif($task->task_status == 'completed') bg-gradient-success
                            @elseif($task->task_status == 'pending') bg-gradient-warning
                            @elseif($task->task_status == 'not_started') bg-gradient-secondary
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $task->task_status)) }}
                        </span>
                    </div>

                    <!-- Priority -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-2">Priority</h6>
                        <span class="badge badge-sm bg-gradient-{{ $task->task_priority == 'high' ? 'danger' : ($task->task_priority == 'medium' ? 'warning' : 'info') }}">
                            {{ ucfirst($task->task_priority) }}
                        </span>
                    </div>

                    <!-- Project -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-secondary text-xs font-weight-bolder mb-2">Project</h6>
                        <p class="mb-0">{{ $task->project->proj_name ?? 'Not assigned' }}</p>
                    </div>
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <small class="text-muted">Created</small>
                            <p class="mb-0">{{ $task->created_at->format('M d, Y') }}</p>
                        </div>
                        <div>
                            <small class="text-muted">Start Date</small>
                            <p class="mb-0">{{ $task->task_start_date ? \Carbon\Carbon::parse($task->task_start_date)->format('M d, Y') : 'Not set' }}</p>
                        </div>
                        <div>
                            <small class="text-muted">Due Date</small>
                            @if($task->task_due_date)
                                @php
                                    $due = \Carbon\Carbon::parse($task->task_due_date);
                                    $now = now();
                                    $dueClass = $due->isPast() && !$due->isToday() ? 'text-danger' : ($due->isToday() ? 'text-warning' : 'text-dark');
                                @endphp
                                <p class="mb-0 {{ $dueClass }}">{{ $due->format('M d, Y') }}</p>
                            @else
                                <p class="mb-0 text-muted">Not set</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Card -->
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <small class="text-muted">Last Updated</small>
                            <p class="mb-0">{{ $task->updated_at->diffForHumans() }}</p>
                        </div>
                        <div>
                            <small class="text-muted">Attachments</small>
                            <p class="mb-0">{{ !empty($attachments) ? count($attachments) : 0 }} files</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
