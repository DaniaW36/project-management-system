@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-gradient-primary text-white">
                <div class="card-body p-4">
                    <h4 class="mb-0">Welcome back, {{ Auth::user()->name }}!</h4>
                    <p class="mb-0">Here's an overview of your tasks and projects.</p>
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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">My Tasks</p>
                                <h5 class="font-weight-bolder mb-0">{{ $totalTasks }}</h5>
                                <p class="mb-0 text-sm text-success">
                                    <span class="font-weight-bold">{{ $completedTasks }}</span> Completed
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="fas fa-tasks text-lg opacity-10" aria-hidden="true"></i>
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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">My Projects</p>
                                <h5 class="font-weight-bolder mb-0">{{ $totalProjects }}</h5>
                                <p class="mb-0 text-sm text-success">
                                    <span class="font-weight-bold">{{ $activeProjects ?? 0 }}</span> Active
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="fas fa-project-diagram text-lg opacity-10" aria-hidden="true"></i>
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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Pending Tasks</p>
                                <h5 class="font-weight-bolder mb-0">{{ $pendingTasks }}</h5>
                                <p class="mb-0 text-sm text-warning">
                                    <span class="font-weight-bold">{{ $inProgressTasks ?? 0 }}</span> In Progress
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="fas fa-clock text-lg opacity-10" aria-hidden="true"></i>
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
                                <p class="text-sm mb-0 text-uppercase font-weight-bold">Task Completion</p>
                                <h5 class="font-weight-bolder mb-0">
                                    @php
                                        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100) : 0;
                                    @endphp
                                    {{ $completionRate }}%
                                </h5>
                                <p class="mb-0 text-sm text-success">
                                    <span class="font-weight-bold">{{ $completedTasks }}/{{ $totalTasks }}</span> Tasks
                                </p>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="fas fa-chart-line text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="row">
        <!-- Task Status Chart -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>My Task Status Overview</h6>
                </div>
                <div class="card-body">
                    <canvas id="taskChart" height="300"></canvas>
                </div>
            </div>
        </div>

        <!-- Personal Performance -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>My Performance</h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        <div class="list-group-item p-3">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar avatar-xl rounded-circle bg-gradient-primary me-3">
                                    <span class="text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                                    <small class="text-muted">{{ Auth::user()->email }}</small>
                                </div>
                            </div>
                            <div class="mt-2">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-sm">Task Completion Rate</span>
                                    <span class="text-sm font-weight-bold">{{ $completionRate }}%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-gradient-success" role="progressbar" 
                                        style="width: {{ $completionRate }}%" 
                                        aria-valuenow="{{ $completionRate }}" 
                                        aria-valuemin="0" 
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between mt-2">
                                    <small class="text-muted">{{ $completedTasks }}/{{ $totalTasks }} Tasks</small>
                                    <small class="text-muted">{{ $activeProjects ?? 0 }} Active Projects</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>My Recent Tasks</h6>
                    <a href="{{ route('staff.tasks.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th>Task</th>
                                    <th>Project</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Progress</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentTasks as $task)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0">{{ $task->task_name }}</h6>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $task->project->proj_name ?? 'N/A' }}</td>
                                    <td>
                                        @php
                                            $statusClass = match($task->task_status) {
                                                'completed' => 'bg-gradient-success',
                                                'in_progress' => 'bg-gradient-info',
                                                'pending' => 'bg-gradient-warning',
                                                'not_started' => 'bg-gradient-secondary',
                                                default => 'bg-gradient-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $statusClass }} text-white">
                                            {{ ucfirst(str_replace('_', ' ', $task->task_status)) }}
                                        </span>
                                    </td>
                                    <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : '-' }}</td>
                                    <td>
                                        @php
                                            $progress = match($task->task_status) {
                                                'not_started' => 0,
                                                'pending' => 25,
                                                'in_progress' => 50,
                                                'completed' => 100,
                                                default => 0
                                            };
                                        @endphp
                                        <div class="progress">
                                            <div class="progress-bar bg-gradient-success" role="progressbar" 
                                                style="width: {{ $progress }}%" 
                                                aria-valuenow="{{ $progress }}" 
                                                aria-valuemin="0" 
                                                aria-valuemax="100">
                                                {{ $progress }}%
                                            </div>
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
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var ctx = document.getElementById('taskChart').getContext('2d');
    var taskChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($taskStatusChart->keys()) !!},
            datasets: [{
                label: 'Number of Tasks',
                data: {!! json_encode($taskStatusChart->values()) !!},
                backgroundColor: [
                    '#9e9e9e', // Not Started
                    '#ff9800', // Pending
                    '#2196f3', // In Progress
                    '#4caf50'  // Completed
                ],
                borderColor: [
                    '#9e9e9e',
                    '#ff9800',
                    '#2196f3',
                    '#4caf50'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'My Task Status Distribution'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        drawBorder: false
                    },
                    ticks: {
                        stepSize: 1
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
});
</script>
@endpush
