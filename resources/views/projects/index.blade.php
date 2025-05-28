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
                            <h4 class="mb-0">Projects Overview</h4>
                            <p class="mb-0">Manage and track all your projects</p>
                        </div>
                        <a href="{{ route('staff.projects.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Add New Project
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Projects</p>
                                <h5 class="font-weight-bolder mb-0">{{ $projects->count() }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-project-diagram text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">In Progress</p>
                                <h5 class="font-weight-bolder mb-0">{{ $projects->where('proj_status', 'In Progress')->count() }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="fas fa-spinner text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Completed</p>
                                <h5 class="font-weight-bolder mb-0">{{ $projects->where('proj_status', 'Completed')->count() }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="fas fa-check-circle text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Pending</p>
                                <h5 class="font-weight-bolder mb-0">{{ $projects->where('proj_status', 'Pending')->count() }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="fas fa-clock text-lg opacity-10"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Projects Table -->
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-6 d-flex align-items-center">
                    <h6 class="mb-0">Projects List</h6>
                </div>
                <div class="col-6 text-end">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search projects..." id="searchInput">
                        <button class="btn btn-outline-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="projectsTable">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Progress</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created By</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Due Date</th>
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
                                        <p class="text-xs text-secondary mb-0">Created {{ $project->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ Str::limit($project->proj_desc, 50) }}</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge badge-sm
                                    @if($project->proj_status == 'In Progress') bg-gradient-info
                                    @elseif($project->proj_status == 'Completed') bg-gradient-success
                                    @elseif($project->proj_status == 'Pending') bg-gradient-warning
                                    @elseif($project->proj_status == 'On Hold') bg-gradient-secondary
                                    @endif">
                                    {{ $project->proj_status }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
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
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="me-2 text-xs font-weight-bold">{{ $percent }}%</span>
                                    <div style="min-width: 100px;">
                                        <div class="progress">
                                            <div class="progress-bar {{ $barClass }}" role="progressbar" 
                                                style="width: {{ $percent }}%;" 
                                                aria-valuenow="{{ $percent }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                @if($project->creator)
                                    <p class="text-xs font-weight-bold mb-0">{{ $project->creator->name }}</p>
                                    <p class="text-xs text-secondary mb-0">{{ $project->creator->email }}</p>
                                @else
                                    <p class="text-xs text-secondary mb-0">Unknown creator</p>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <span class="text-secondary text-xs font-weight-bold">
                                    {{ $project->proj_end_date ? \Carbon\Carbon::parse($project->proj_end_date)->format('M d, Y') : 'N/A' }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('staff.projects.show', $project->id) }}" 
                                        class="btn btn-link text-primary px-3 mb-0" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-original-title="View project">
                                        <i class="fas fa-eye text-primary me-2"></i>View
                                    </a>
                                    <a href="{{ route('staff.projects.edit', $project->id) }}" 
                                        class="btn btn-link text-warning px-3 mb-0"
                                        data-bs-toggle="tooltip" 
                                        data-bs-original-title="Edit project">
                                        <i class="fas fa-pencil-alt text-warning me-2"></i>Edit
                                    </a>
                                    <form action="{{ route('staff.projects.destroy', $project->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="btn btn-link text-danger px-3 mb-0"
                                            data-bs-toggle="tooltip" 
                                            data-bs-original-title="Delete project"
                                            onclick="return confirm('Are you sure you want to delete this project?')">
                                            <i class="fas fa-trash-alt text-danger me-2"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('projectsTable');
    const rows = table.getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        
        for (let i = 1; i < rows.length; i++) {
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;

            for (let j = 0; j < cells.length; j++) {
                const cell = cells[j];
                if (cell.textContent.toLowerCase().indexOf(searchText) > -1) {
                    found = true;
                    break;
                }
            }

            row.style.display = found ? '' : 'none';
        }
    });
});
</script>
@endpush
