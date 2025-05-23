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
                            <h4 class="mb-0">Edit Task</h4>
                            <p class="mb-0">Update task information</p>
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

                    <form action="{{ route('staff.tasks.update', $task->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Task Name -->
                                <div class="form-group mb-4">
                                    <label for="task_name" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Task Name</label>
                                    <input type="text" class="form-control" id="task_name" name="task_name" required 
                                           value="{{ old('task_name', $task->task_name) }}"
                                           placeholder="Enter task name">
                                </div>

                                <!-- Task Description -->
                                <div class="form-group mb-4">
                                    <label for="task_desc" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Task Description</label>
                                    <textarea class="form-control" id="task_desc" name="task_desc" rows="4"
                                              placeholder="Enter task description">{{ old('task_desc', $task->task_desc) }}</textarea>
                                </div>

                                <!-- Project Selection -->
                                <div class="form-group mb-4">
                                    <label for="project_id" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Project</label>
                                    <select class="form-select" id="project_id" name="project_id" required>
                                        <option value="">Select a project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                                                {{ $project->proj_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Task Status -->
                                <div class="form-group mb-4">
                                    <label for="task_status" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Task Status</label>
                                    <select class="form-select" id="task_status" name="task_status" required>
                                        @foreach(['not_started', 'pending', 'in_progress', 'completed'] as $status)
                                            <option value="{{ $status }}" {{ old('task_status', $task->task_status) == $status ? 'selected' : '' }}>
                                                {{ ucfirst(str_replace('_', ' ', $status)) }}
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
                                        @foreach(['low', 'medium', 'high'] as $priority)
                                            <option value="{{ $priority }}" {{ old('task_priority', $task->task_priority) == $priority ? 'selected' : '' }}>
                                                {{ ucfirst($priority) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>


                                <!-- Due Date -->
                                <div class="form-group mb-4">
                                    <label for="due_date" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Due Date</label>
                                    <input type="date" class="form-control" id="due_date" name="due_date"
                                           value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}">
                                </div>

                                <!-- Task Attachments -->
                                <div class="form-group mb-4">
                                    <label for="task_attachments" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">New Attachments</label>
                                    <input type="file" class="form-control" id="task_attachments" name="task_attachments[]" multiple>
                                    <small class="text-muted">You can select multiple files. Maximum size per file: 2MB</small>
                                </div>

                                <!-- Existing Attachments -->
                                @if($task->task_attachments)
                                    <div class="card mt-4">
                                        <div class="card-header pb-0">
                                            <h6 class="mb-0">Existing Attachments</h6>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                $attachments = $task->task_attachments ?? [];
                                            @endphp
                                            @if(!empty($attachments))
                                                <div class="row">
                                                    @foreach($attachments as $file)
                                                        <div class="col-md-6 mb-3">
                                                            <div class="card">
                                                                @if(in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                                                                    <img src="{{ asset('storage/' . $file) }}" class="card-img-top" alt="Attachment">
                                                                @else
                                                                    <div class="card-body text-center">
                                                                        <i class="fas fa-file-pdf fa-3x text-danger mb-3"></i>
                                                                        <h6 class="card-title">{{ basename($file) }}</h6>
                                                                    </div>
                                                                @endif
                                                                <div class="card-footer">
                                                                    <div class="d-flex justify-content-between">
                                                                        <a href="{{ asset('storage/' . $file) }}" 
                                                                           class="btn btn-sm btn-primary" 
                                                                           target="_blank">
                                                                            <i class="fas fa-eye me-2"></i>View
                                                                        </a>
                                                                        <button type="button" 
                                                                                class="btn btn-sm btn-danger delete-attachment"
                                                                                data-file="{{ $file }}"
                                                                                data-task-id="{{ $task->id }}">
                                                                            <i class="fas fa-trash-alt me-2"></i>Delete
                                                                        </button>
                                                                    </div>
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
                                @endif
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Task
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Handle attachment deletion
    document.querySelectorAll('.delete-attachment').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('Are you sure you want to delete this attachment?')) {
                const file = this.dataset.file;
                const taskId = this.dataset.taskId;
                
                fetch(`/tasks/${taskId}/attachments`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ file: file })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.closest('.col-md-6').remove();
                    } else {
                        alert('Failed to delete attachment');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while deleting the attachment');
                });
            }
        });
    });
</script>
@endpush
