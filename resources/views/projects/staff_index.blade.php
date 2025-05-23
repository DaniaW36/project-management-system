@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6>Other Staff Projects</h6>
                        <a href="{{ route('staff.projects.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-arrow-left me-2"></i>Back to My Projects
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Assigned To</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Start Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">End Date</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($projects as $project)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">{{ $project->proj_name }}</h6>
                                                <p class="text-xs text-secondary mb-0">{{ Str::limit($project->proj_desc, 50) }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p class="text-xs font-weight-bold mb-0">{{ $project->user->name }}</p>
                                        <p class="text-xs text-secondary mb-0">{{ $project->user->email }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        @php
                                            $statusClass = match($project->proj_status) {
                                                'In Progress' => 'bg-gradient-info',
                                                'Completed' => 'bg-gradient-success',
                                                'On Hold' => 'bg-gradient-warning',
                                                'Pending' => 'bg-gradient-secondary',
                                                default => 'bg-gradient-secondary'
                                            };
                                        @endphp
                                        <span class="badge badge-sm {{ $statusClass }}">{{ $project->proj_status }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $project->proj_start_date->format('M d, Y') }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">{{ $project->proj_end_date->format('M d, Y') }}</span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('staff.staff-projects.show', $project->id) }}" 
                                           class="btn btn-link text-primary px-3 mb-0"
                                           data-bs-toggle="tooltip" 
                                           data-bs-original-title="View project">
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