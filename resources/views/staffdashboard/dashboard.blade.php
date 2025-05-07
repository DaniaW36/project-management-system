@extends('layouts.master')

@section('content')
<div class="container">

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white p-3">
                <h5>Total Projects</h5>
                <h3>{{ $totalProjects }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white p-3">
                <h5>Total Tasks</h5>
                <h3>{{ $totalTasks }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white p-3">
                <h5>Completed Tasks</h5>
                <h3>{{ $completedTasks }}</h3>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white p-3">
                <h5>Pending Tasks</h5>
                <h3>{{ $pendingTasks }}</h3>
            </div>
        </div>
    </div>

    {{-- Chart Placeholder --}}
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card p-3">
                <h5>Task Status Overview</h5>
                <canvas id="taskChart" width="400" height="150"></canvas>
            </div>
        </div>
    </div>

    {{-- Recent Tasks --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card p-3">
                <h5>Recent Tasks</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentTasks as $task)
                            <tr>
                                <td>{{ $task->task_name }}</td>
                                <td>{{ $task->project->proj_name ?? 'N/A' }}</td>
                                <td>{{ $task->task_status }}</td>
                                <td>{{ $task->due_date ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('taskChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($taskStatusChart->keys()) !!},
            datasets: [{
                data: {!! json_encode($taskStatusChart->values()) !!},
                backgroundColor: ['#4caf50', '#ff9800', '#f44336', '#2196f3']
            }]
        }
    });
</script>
@endsection
