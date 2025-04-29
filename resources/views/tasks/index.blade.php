@extends('layouts.master')

@section('content')
<div class="card mb-4">
    <div class="card-header pb-0 d-flex justify-content-between align-items-center">
        <h6>Tasks List</h6>
        <a href="{{ route('tasks.create') }}" class="btn btn-info btn-sm">Add Task</a>
    </div>

    <div class="card-body px-0 pt-0 pb-2">
        <div class="px-3 pt-3">
            <!-- Filter Dropdown -->
            <form method="GET" action="{{ route('tasks.index') }}" class="row mb-4">
                <div class="col-md-6">
                    <select name="project_id" class="form-select" onchange="this.form.submit()">
                        <option value="">-- All Projects --</option>
                        @foreach($projects as $proj)
                            <option value="{{ $proj->id }}" {{ request('project_id') == $proj->id ? 'selected' : '' }}>
                                {{ $proj->proj_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Task Name</th>
                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Project Name</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Priority</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Due Date</th>
                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Assigned To</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td class="text-sm font-weight-bold mb-0">{{ $task->task_name }}</td>
                        <td class="text-sm text-secondary mb-0">{{ $task->project->proj_name ?? '-' }}</td>

                        <td class="align-middle text-center text-sm">
                            <span class="badge bg-secondary text-capitalize">
                                {{ str_replace('_', ' ', $task->task_status) }}
                            </span>
                        </td>

                        <td class="align-middle text-center text-sm">
                            <span class="badge bg-info text-capitalize">
                                {{ $task->task_priority }}
                            </span>
                        </td>

                        <td class="align-middle text-center text-sm">
                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : '-' }}
                        </td>

                        <td class="align-middle text-center text-sm">
                            {{ $task->user->name ?? 'Unassigned' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-secondary py-4">
                            No tasks found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-4 mt-3">
            <a href="{{ route('projects.index') }}" class="btn btn-primary btn-sm">Back to Projects</a>
        </div>
    </div>
</div>
@endsection
