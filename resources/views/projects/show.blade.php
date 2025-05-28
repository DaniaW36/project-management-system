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
                            <p class="mb-0">Project Details</p>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('staff.projects.edit', $project->id) }}" class="btn btn-light">
                                <i class="fas fa-pencil-alt me-2"></i>Edit Project
                            </a>
                            <a href="{{ route('staff.projects.index') }}" class="btn btn-light">
                                <i class="fas fa-arrow-left me-2"></i>Back to Projects
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Project Information -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Project Information</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Description</h6>
                                <p class="text-sm">{{ $project->proj_desc }}</p>
                            </div>
                            <div class="mb-4">
                                <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Status</h6>
                                <span class="badge badge-sm
                                    @if($project->proj_status == 'In Progress') bg-gradient-info
                                    @elseif($project->proj_status == 'Completed') bg-gradient-success
                                    @elseif($project->proj_status == 'Pending') bg-gradient-warning
                                    @elseif($project->proj_status == 'On Hold') bg-gradient-secondary
                                    @endif">
                                    {{ $project->proj_status }}
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">Start Date</h6>
                                <p class="text-sm">{{ $project->proj_start_date ? \Carbon\Carbon::parse($project->proj_start_date)->format('M d, Y') : 'Not set' }}</p>
                            </div>
                            <div class="mb-4">
                                <h6 class="text-uppercase text-secondary text-xs font-weight-bolder">End Date</h6>
                                <p class="text-sm">{{ $project->proj_end_date ? \Carbon\Carbon::parse($project->proj_end_date)->format('M d, Y') : 'Not set' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Progress -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Project Progress</h6>
                </div>
                <div class="card-body">
                    @php
                        $proj_status = $project->proj_status;
                        $percent = 0;
                        $barClass = '';

                        if ($proj_status == 'Pending') {
                            $percent = 10;
                            $barClass = 'bg-gradient-warning';
                        } elseif ($proj_status == 'In Progress') {
                            $percent = 50;
                            $barClass = 'bg-gradient-info';
                        } elseif ($proj_status == 'On Hold') {
                            $percent = 75;
                            $barClass = 'bg-gradient-secondary';
                        } elseif ($proj_status == 'Completed') {
                            $percent = 100;
                            $barClass = 'bg-gradient-success';
                        }
                    @endphp
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <div class="progress">
                                <div class="progress-bar {{ $barClass }}" role="progressbar" 
                                    style="width: {{ $percent }}%;" 
                                    aria-valuenow="{{ $percent }}" 
                                    aria-valuemin="0" 
                                    aria-valuemax="100">
                                </div>
                            </div>
                        </div>
                        <div class="ms-3">
                            <span class="text-sm font-weight-bold">{{ $percent }}%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Attachments -->
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Project Attachments</h6>
                </div>
                <div class="card-body">
                    @php
                        $attachments = $project->proj_attachments ?? [];
                    @endphp
                    @if(!empty($attachments))
                        <div class="row">
                            @foreach($attachments as $attachment)
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        @if(in_array(pathinfo($attachment, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                            <img src="{{ asset('storage/' . $attachment) }}" class="card-img-top" alt="Attachment">
                                        @else
                                            <div class="card-body text-center">
                                                <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                                <h6 class="card-title">{{ basename($attachment) }}</h6>
                                            </div>
                                        @endif
                                        <div class="card-footer">
                                            <a href="{{ asset('storage/' . $attachment) }}" 
                                               class="btn btn-sm btn-primary w-100" 
                                               download>
                                                <i class="fas fa-download me-2"></i>Download
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

        <!-- Project Details Sidebar -->
        <div class="col-lg-4">
            <!-- Project Timeline -->
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Project Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="timeline timeline-one-side">
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="fas fa-plus text-success"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Project Created</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    {{ $project->created_at->format('M d, Y H:i') }}
                                </p>
                            </div>
                        </div>
                        @if($project->proj_start_date)
                        <div class="timeline-block mb-3">
                            <span class="timeline-step">
                                <i class="fas fa-play text-info"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Project Started</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    {{ \Carbon\Carbon::parse($project->proj_start_date)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                        @endif
                        @if($project->proj_end_date)
                        <div class="timeline-block">
                            <span class="timeline-step">
                                <i class="fas fa-flag text-warning"></i>
                            </span>
                            <div class="timeline-content">
                                <h6 class="text-dark text-sm font-weight-bold mb-0">Project Deadline</h6>
                                <p class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                    {{ \Carbon\Carbon::parse($project->proj_end_date)->format('M d, Y') }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Project Statistics -->
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Project Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <div>
                            <h6 class="text-sm font-weight-bold mb-0">Last Updated</h6>
                            <p class="text-xs text-secondary mb-0">
                                {{ $project->updated_at->diffForHumans() }}
                            </p>
                        </div>
                        <div class="text-end">
                            <h6 class="text-sm font-weight-bold mb-0">Created By</h6>
                            <p class="text-xs text-secondary mb-0">
                                @if($project->creator)
                                    {{ $project->creator->name }}
                                @else
                                    Unknown creator
                                @endif
                            </p>
                        </div>
                    </div>
                    <hr class="horizontal dark">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="text-sm font-weight-bold mb-0">Duration</h6>
                            <p class="text-xs text-secondary mb-0">
                                @if($project->proj_start_date && $project->proj_end_date)
                                    {{ \Carbon\Carbon::parse($project->proj_start_date)->diffInDays($project->proj_end_date) }} days
                                @else
                                    Not set
                                @endif
                            </p>
                        </div>
                        <div class="text-end">
                            <h6 class="text-sm font-weight-bold mb-0">Attachments</h6>
                            <p class="text-xs text-secondary mb-0">
                                {{ count($attachments) }} files
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
