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
                            <h4 class="mb-0">Tasks Overview</h4>
                            <p class="mb-0">Manage and track all your tasks</p>
                        </div>
                        <a href="{{ route('staff.tasks.create') }}" class="btn btn-light">
                            <i class="fas fa-plus me-2"></i>Add New Task
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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Total Tasks</p>
                                <h5 class="font-weight-bolder mb-0">{{ $tasks->count() }}</h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-tasks text-lg opacity-10"></i>
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
                                <h5 class="font-weight-bolder mb-0">{{ $tasks->where('task_status', 'in_progress')->count() }}</h5>
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
                                <h5 class="font-weight-bolder mb-0">{{ $tasks->where('task_status', 'completed')->count() }}</h5>
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
                                <h5 class="font-weight-bolder mb-0">{{ $tasks->where('task_status', 'pending')->count() }}</h5>
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

    <!-- Tasks Table -->
    <div class="card">
        <div class="card-header pb-0">
            <div class="row">
                <div class="col-6 d-flex align-items-center">
                    <h6 class="mb-0">Tasks List</h6>
                </div>
                <div class="col-6 text-end">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search tasks..." id="searchInput">
                        <button class="btn btn-outline-primary" type="button">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0" id="tasksTable">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Task Name</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Project</th>
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
                                        <p class="text-xs text-secondary mb-0">Created {{ $task->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <p class="text-xs font-weight-bold mb-0">{{ $task->project->proj_name ?? 'Not assigned' }}</p>
                            </td>
                            <td class="align-middle text-center text-sm">
                                <span class="badge badge-sm
                                    @if($task->task_status == 'in_progress') bg-gradient-info
                                    @elseif($task->task_status == 'completed') bg-gradient-success
                                    @elseif($task->task_status == 'pending') bg-gradient-warning
                                    @elseif($task->task_status == 'not_started') bg-gradient-secondary
                                    @endif">
                                    {{ $task->task_status }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge badge-sm bg-gradient-{{ $task->task_priority == 'High' ? 'danger' : ($task->task_priority == 'Medium' ? 'warning' : 'info') }}">
                                    {{ $task->task_priority }}
                                </span>
                            </td>
                            <td class="align-middle text-center">
                                @if($task->due_date)
                                    @php
                                        $due = \Carbon\Carbon::parse($task->due_date);
                                        $dueClass = $due->isPast() && !$due->isToday() ? 'text-danger' : ($due->isToday() ? 'text-warning' : 'text-dark');
                                    @endphp
                                    <span class="text-xs font-weight-bold {{ $dueClass }}">
                                        {{ $due->format('M d, Y') }}
                                    </span>
                                @else
                                    <span class="text-xs font-weight-bold text-muted">Not set</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('staff.tasks.show', $task->id) }}" 
                                        class="btn btn-link text-primary px-3 mb-0" 
                                        data-bs-toggle="tooltip" 
                                        data-bs-original-title="View task">
                                        <i class="fas fa-eye text-primary me-2"></i>View
                                    </a>
                                    <a href="{{ route('staff.tasks.edit', $task->id) }}" 
                                        class="btn btn-link text-warning px-3 mb-0"
                                        data-bs-toggle="tooltip" 
                                        data-bs-original-title="Edit task">
                                        <i class="fas fa-pencil-alt text-warning me-2"></i>Edit
                                    </a>
                                    <form action="{{ route('staff.tasks.destroy', $task->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="btn btn-link text-danger px-3 mb-0"
                                            data-bs-toggle="tooltip" 
                                            data-bs-original-title="Delete task"
                                            onclick="return confirm('Are you sure you want to delete this task?')">
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
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Search functionality
    document.getElementById('searchInput').addEventListener('keyup', function() {
        var input = this.value.toLowerCase();
        var table = document.getElementById('tasksTable');
        var rows = table.getElementsByTagName('tr');

        for (var i = 1; i < rows.length; i++) {
            var row = rows[i];
            var cells = row.getElementsByTagName('td');
            var found = false;

            for (var j = 0; j < cells.length; j++) {
                var cell = cells[j];
                if (cell.textContent.toLowerCase().indexOf(input) > -1) {
                    found = true;
                    break;
                }
            }

            row.style.display = found ? '' : 'none';
        }
    });
</script>
@endpush
