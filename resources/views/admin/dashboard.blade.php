@extends('layouts.master')

@section('content')
<div class="container mx-auto px-4 py-6">

    <!-- Dashboard Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Staff Card -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
            <div class="flex items-center space-x-4">
                <div class="bg-blue-500 p-3 rounded-full text-white">
                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M16 7V4H8v3H5v14h14V7h-3zm-7 0V5h4v2h-4z"></path></svg>
                </div>
                <div>
                    <h5 class="text-2xl font-semibold">{{ count($staff) }}</h5>
                    <p class="text-gray-500">Total Staff</p>
                </div>
            </div>
        </div>

        <!-- Total Projects Card -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
            <div class="flex items-center space-x-4">
                <div class="bg-green-500 p-3 rounded-full text-white">
                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M6 2h12v20H6V2zm4 8h4v4h-4zm0 6h4v4h-4z"></path></svg>
                </div>
                <div>
                    <h5 class="text-2xl font-semibold">{{ count($projects) }}</h5>
                    <p class="text-gray-500">Total Projects</p>
                </div>
            </div>
        </div>

        <!-- Total Tasks Card -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
            <div class="flex items-center space-x-4">
                <div class="bg-yellow-500 p-3 rounded-full text-white">
                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M5 4h14v16H5V4zm7 3l-5 5h4v6h2V12h4z"></path></svg>
                </div>
                <div>
                    <h5 class="text-2xl font-semibold">{{ count($tasks) }}</h5>
                    <p class="text-gray-500">Total Tasks</p>
                </div>
            </div>
        </div>

        <!-- Completed Tasks Card -->
        <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-xl transition duration-300">
            <div class="flex items-center space-x-4">
                <div class="bg-teal-500 p-3 rounded-full text-white">
                    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 5v14m7-7l-7 7-7-7"></path></svg>
                </div>
                <div>
                    <h5 class="text-2xl font-semibold">{{ $completedTasks }}</h5>
                    <p class="text-gray-500">Completed Tasks</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Task Completion Chart (Using a simple bar chart example) -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <h3 class="text-2xl font-semibold mb-4">Task Status Overview</h3>
        <div class="h-64">
            <canvas id="taskStatusChart"></canvas>
        </div>
    </div>

    <!-- Staff Members Section -->
    <div class="mb-8">
        <h3 class="text-2xl font-semibold mb-4">Staff Members</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($staff as $member)
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-200">
                <h4 class="text-xl font-medium">{{ $member->name }}</h4>
                <p class="text-gray-500">{{ $member->email }}</p>
                <div class="mt-4 flex justify-between items-center">
                    <a href="#" class="text-blue-500 hover:text-blue-700">View Profile</a>
                    <span class="text-gray-600">{{ $member->created_at?->diffForHumans() ?? 'N/A' }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Projects Section -->
    <div class="mb-8">
        <h3 class="text-2xl font-semibold mb-4">All Projects</h3>
        <div class="space-y-4">
            @foreach ($projects as $project)
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-200">
                <h4 class="text-xl font-medium">{{ $project->name }}</h4>
                <p class="text-gray-500">Assigned to: {{ $project->user->name ?? 'Unassigned' }}</p>
                <div class="mt-4 flex justify-between items-center">
                    <a href="#" class="text-blue-500 hover:text-blue-700">View Project</a>
                    <span class="text-gray-600">{{ $project->created_at?->diffForHumans() ?? 'N/A' }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Tasks Section -->
    <div class="mb-8">
        <h3 class="text-2xl font-semibold mb-4">All Tasks</h3>
        <div class="space-y-4">
            @foreach ($tasks as $task)
            <div class="bg-white p-6 rounded-lg shadow-md hover:shadow-lg transition duration-200">
                <h4 class="text-xl font-medium">{{ $task->task_name }}</h4>
                <p class="text-gray-500">Status: {{ $task->task_status }}</p>
                <p class="text-gray-600">Project: {{ $task->project->name ?? 'N/A' }}</p>
                <p class="text-gray-600">Assigned to: {{ $task->user->name ?? 'N/A' }}</p>
                <div class="mt-4 flex justify-between items-center">
                    <a href="#" class="text-blue-500 hover:text-blue-700">View Task</a>
                    <span class="text-gray-600">{{ $task->created_at?->diffForHumans() ?? 'N/A' }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('taskStatusChart').getContext('2d');
    var taskStatusChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Completed', 'Pending', 'In Progress'],
            datasets: [{
                label: '# of Tasks',
                data: [{{ $completedTasks }}, {{ $pendingTasks }}, {{ $totalTasks - $completedTasks - $pendingTasks }}],
                backgroundColor: ['#4CAF50', '#FFC107', '#2196F3'],
                borderColor: ['#4CAF50', '#FFC107', '#2196F3'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
