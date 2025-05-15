@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>All Projects</h6>
                    <a href="{{ route('admin.projects.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i> New Project
                    </a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Assigned Staff</th>
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
                                            $statusClass = '';
                                            switch ($project->proj_status) {
                                                case 'Completed':
                                                    $statusClass = 'success';
                                                    break;
                                                case 'In Progress':
                                                    $statusClass = 'info';
                                                    break;
                                                case 'On Hold':
                                                case 'Pending':
                                                    $statusClass = 'warning';
                                                    break;
                                                default:
                                                    $statusClass = 'light'; // Default for any unexpected status
                                            }
                                        @endphp
                                        <span class="badge badge-sm bg-gradient-{{ $statusClass }}">
                                            {{ $project->proj_status }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                        {{ \Carbon\Carbon::parse($project->proj_start_date)->format('d M Y') }}
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-secondary text-xs font-weight-bold">
                                       {{ Carbon\Carbon::parse($project->proj_end_date)->format('d M Y') }} 
                                        </span>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-link text-info px-3 mb-0">
                                            <i class="fas fa-eye me-2"></i>View
                                        </a>
                                        <a href="{{ route('admin.projects.edit', $project) }}" class="btn btn-link text-warning px-3 mb-0">
                                            <i class="fas fa-pencil-alt me-2"></i>Edit
                                        </a>
                                        <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger px-3 mb-0" onclick="return confirm('Are you sure you want to delete this project?')">
                                                <i class="fas fa-trash me-2"></i>Delete
                                            </button>
                                        </form>
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