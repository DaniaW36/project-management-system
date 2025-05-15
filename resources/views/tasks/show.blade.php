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
                            <a href="{{ route('staff.tasks.edit', $task->id) }}" class="btn btn-light">
                                <i class="fas fa-edit me-2"></i>Edit Task
                            </a>
                            <a href="{{ route('staff.tasks.index') }}" class="btn btn-light">
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
        <div class="col-lg-8 mb-lg-0 mb-4">
            <!-- Task Description Card -->
            <div class="card mb-4">
                <div class="card-header bg-gradient-light pb-0 pt-3">
                    <h6 class="mb-1 text-dark">Description</h6>
                </div>
                <div class="card-body pt-3">
                    <p class="text-sm mb-0">{{ $task->task_desc ?? 'No description provided' }}</p>
                </div>
            </div>

            <!-- Progress Card -->
            <div class="card mb-4">
                <div class="card-header bg-gradient-light pb-0 pt-3">
                    <h6 class="mb-1 text-dark">Progress</h6>
                </div>
                <div class="card-body pt-3">
                    @php
                        $status = $task->task_status;
                        $percent = 0;
                        $barClass = '';
                        $statusText = ucfirst(str_replace('_', ' ', $task->task_status));

                        if ($status == 'not_started') {
                            $percent = 5; // Show a sliver for not started
                            $barClass = 'bg-secondary'; // More distinct than gradient-secondary for a sliver
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
                    <div class="d-flex align-items-center mb-1">
                        <span class="me-2 text-sm font-weight-bold">{{ $statusText }}</span>
                        <small class="text-muted">({{ $percent }}%)</small>
                    </div>
                    <div class="progress flex-grow-1" style="height: 10px;">
                        <div class="progress-bar {{ $barClass }}" role="progressbar"
                             style="width: {{ $percent }}%;"
                             aria-valuenow="{{ $percent }}"
                             aria-valuemin="0"
                             aria-valuemax="100">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attachments Card -->
            <div class="card">
                @php
                    $attachments = $task->task_attachments ?? [];
                    $attachmentCount = !empty($attachments) ? count($attachments) : 0;
                @endphp
                <div class="card-header bg-gradient-light pb-0 pt-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mb-1 text-dark">Attachments</h6>
                        <span class="badge bg-primary">{{ $attachmentCount }} {{ $attachmentCount == 1 ? 'file' : 'files' }}</span>
                    </div>
                </div>
                <div class="card-body pt-3">
                    @if(!empty($attachments))
                        <div class="row">
                            @foreach($attachments as $file)
                                <div class="col-md-4 mb-3">
                                    <div class="card border">
                                        @if(in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/' . $file) }}" class="card-img-top" alt="{{ basename($file) }}" style="height: 150px; object-fit: cover;">
                                        @else
                                            <div class="card-body text-center py-4">
                                                @php $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION)); @endphp
                                                @if($extension == 'pdf')
                                                    <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                                                @elseif(in_array($extension, ['doc', 'docx']))
                                                    <i class="fas fa-file-word fa-3x text-primary mb-2"></i>
                                                @elseif(in_array($extension, ['xls', 'xlsx']))
                                                    <i class="fas fa-file-excel fa-3x text-success mb-2"></i>
                                                @elseif(in_array($extension, ['ppt', 'pptx']))
                                                    <i class="fas fa-file-powerpoint fa-3x text-warning mb-2"></i>
                                                @elseif(in_array($extension, ['zip', 'rar']))
                                                    <i class="fas fa-file-archive fa-3x text-info mb-2"></i>
                                                @else
                                                    <i class="fas fa-file-alt fa-3x text-secondary mb-2"></i>
                                                @endif
                                                <p class="card-text text-xs text-truncate mb-0" title="{{ basename($file) }}">{{ basename($file) }}</p>
                                            </div>
                                        @endif
                                        <div class="card-footer py-2">
                                            <a href="{{ asset('storage/' . $file) }}"
                                               class="btn btn-sm btn-outline-primary w-100"
                                               target="_blank">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-muted mb-0 text-center py-3">No attachments available</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Task Info Card -->
            <div class="card mb-4">
                <div class="card-header bg-gradient-light pb-0 pt-3">
                    <h6 class="mb-1 text-dark">Task Details</h6>
                </div>
                <div class="card-body pt-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                            <span class="text-sm text-uppercase text-secondary font-weight-bold">Status:</span>
                            <span class="badge badge-sm
                                @if($task->task_status == 'in_progress') bg-gradient-info
                                @elseif($task->task_status == 'completed') bg-gradient-success
                                @elseif($task->task_status == 'pending') bg-gradient-warning
                                @elseif($task->task_status == 'not_started') bg-gradient-secondary
                                @else bg-gradient-light text-dark
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $task->task_status)) }}
                            </span>
                        </li>
                        <li class="list-group-item px-0 py-3 d-flex justify-content-between align-items-center">
                            <span class="text-sm text-uppercase text-secondary font-weight-bold">Priority:</span>
                            <span class="badge badge-sm 
                                @if($task->task_priority == 'high') bg-gradient-danger
                                @elseif($task->task_priority == 'medium') bg-gradient-warning
                                @elseif($task->task_priority == 'low') bg-gradient-info
                                @else bg-gradient-secondary
                                @endif">
                                {{ ucfirst($task->task_priority ?? 'N/A') }}
                            </span>
                        </li>
                        <li class="list-group-item px-0 py-3">
                            <span class="text-sm text-uppercase text-secondary font-weight-bold d-block mb-1">Project:</span>
                            <span class="text-sm">{{ $task->project->proj_name ?? 'N/A' }}</span>
                        </li>
                         @if($task->assignedUser)
                        <li class="list-group-item px-0 py-3">
                            <span class="text-sm text-uppercase text-secondary font-weight-bold d-block mb-1">Assigned To:</span>
                             <div class="d-flex align-items-center">
                                @if($task->assignedUser->profile_pic)
                                    <img src="{{ asset('storage/' . $task->assignedUser->profile_pic) }}" alt="avatar" class="avatar avatar-xs me-2">
                                @else
                                    <span class="avatar avatar-xs rounded-circle bg-gradient-primary me-2 d-flex align-items-center justify-content-center text-white text-uppercase">{{ substr($task->assignedUser->name, 0, 1) }}</span>
                                @endif
                                <span class="text-sm">{{ $task->assignedUser->name }}</span>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="card">
                <div class="card-header bg-gradient-light pb-0 pt-3">
                    <h6 class="mb-1 text-dark">Timeline</h6>
                </div>
                <div class="card-body pt-2">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 py-3">
                             <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-plus fa-fw text-secondary me-2"></i>
                                <div>
                                    <span class="text-xs text-uppercase text-secondary font-weight-bold d-block">Created</span>
                                    <span class="text-sm">{{ $task->created_at->format('M d, Y, h:i A') }}</span>
                                </div>
                            </div>
                        </li>
                       <li class="list-group-item px-0 py-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-calendar-check fa-fw text-secondary me-2"></i>
                                <div>
                                    <span class="text-xs text-uppercase text-secondary font-weight-bold d-block">Due Date</span>
                                    @if($task->due_date)
                                        @php
                                            $due = \Carbon\Carbon::parse($task->due_date);
                                            $now = now();
                                            $dueClass = '';
                                            if (!($task->task_status == 'completed')) { // Only apply warning/danger if not completed
                                                if ($due->isPast() && !$due->isToday()) {
                                                    $dueClass = 'text-danger font-weight-bold';
                                                } elseif ($due->isToday()) {
                                                    $dueClass = 'text-warning font-weight-bold';
                                                }
                                            }
                                        @endphp
                                        <span class="text-sm {{ $dueClass }}">{{ $due->format('M d, Y') }}</span>
                                        @if(!($task->task_status == 'completed') && $due->isPast() && !$due->isToday())
                                            <span class="text-xs text-danger"> (Overdue)</span>
                                        @elseif(!($task->task_status == 'completed') && $due->isToday())
                                            <span class="text-xs text-warning"> (Due Today)</span>
                                        @endif
                                    @else
                                        <span class="text-sm text-muted">Not set</span>
                                    @endif
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item px-0 py-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-history fa-fw text-secondary me-2"></i>
                                <div>
                                    <span class="text-xs text-uppercase text-secondary font-weight-bold d-block">Last Updated</span>
                                    <span class="text-sm">{{ $task->updated_at->diffForHumans() }}</span>
                                 </div>
                            </div>
                        </li>
                         @if($task->task_status == 'completed' && $task->completed_at)
                         <li class="list-group-item px-0 py-3">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle fa-fw text-success me-2"></i>
                                <div>
                                    <span class="text-xs text-uppercase text-secondary font-weight-bold d-block">Completed</span>
                                    <span class="text-sm">{{ \Carbon\Carbon::parse($task->completed_at)->format('M d, Y, h:i A') }}</span>
                                 </div>
                            </div>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
