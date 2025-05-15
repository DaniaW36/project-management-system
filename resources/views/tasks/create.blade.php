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
                            <h4 class="mb-0">Create New Task</h4>
                            <p class="mb-0">Add a new task to your project</p>
                        </div>
                        <a href="{{ route('staff.tasks.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Back to Tasks
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('staff.tasks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Task Name -->
                                <div class="form-group mb-4">
                                    <label for="task_name" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Task Name</label>
                                    <input type="text" class="form-control" id="task_name" name="task_name" required 
                                           value="{{ old('task_name') }}"
                                           placeholder="Enter task name">
                                </div>

                                <!-- Task Description -->
                                <div class="form-group mb-4">
                                    <label for="task_desc" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Task Description</label>
                                    <textarea class="form-control" id="task_desc" name="task_desc" required rows="4"
                                              placeholder="Enter task description">{{ old('task_desc') }}</textarea>
                                </div>

                                <!-- Project Selection -->
                                <div class="form-group mb-4">
                                    <label for="project_id" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Project</label>
                                    <select class="form-select" id="project_id" name="project_id" required>
                                        <option value="">Select a project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->proj_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Task Status -->
                                <div class="form-group mb-4">
                                    <label for="task_status" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Task Status</label>
                                    <select class="form-select" id="task_status" name="task_status" required>
                                        @foreach(['not_started' => 'Not Started', 'pending' => 'Pending', 'in_progress' => 'In Progress', 'completed' => 'Completed'] as $value => $label)
                                            <option value="{{ $value }}" {{ old('task_status') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <!-- Task Priority -->
                                <div class="form-group mb-4">
                                    <label for="task_priority" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Priority</label>
                                    <select class="form-select" id="task_priority" name="task_priority" required>
                                        @foreach(['Low', 'Medium', 'High'] as $priority)
                                            <option value="{{ $priority }}" {{ old('task_priority') == $priority ? 'selected' : '' }}>
                                                {{ $priority }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Due Date -->
                                <div class="form-group mb-4">
                                    <label for="due_date" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Due Date</label>
                                    <input type="date" class="form-control" id="due_date" name="due_date"
                                           value="{{ old('due_date') }}">
                                </div>

                                <!-- Task Attachments -->
                                <div class="form-group mb-4">
                                    <label for="task_attachments" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Task Attachments</label>
                                    <input type="file" class="form-control" id="task_attachments" name="task_attachments[]" multiple>
                                    <small class="text-muted">You can select multiple files. Maximum file size: 10MB per file.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
