@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Create New Task</h6>
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to Tasks
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.tasks.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="task_name" class="form-control-label">Task Name</label>
                                    <input type="text" class="form-control @error('task_name') is-invalid @enderror" 
                                           id="task_name" name="task_name" value="{{ old('task_name') }}" required>
                                    @error('task_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="project_id" class="form-control-label">Project</label>
                                    <select class="form-control @error('project_id') is-invalid @enderror" 
                                            id="project_id" name="project_id" required>
                                        <option value="">Select Project</option>
                                        @foreach($projects as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->proj_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('project_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="task_desc" class="form-control-label">Description</label>
                            <textarea class="form-control @error('task_desc') is-invalid @enderror" 
                                      id="task_desc" name="task_desc" rows="3" required>{{ old('task_desc') }}</textarea>
                            @error('task_desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="task_status" class="form-control-label">Status</label>
                                    <select class="form-control @error('task_status') is-invalid @enderror" 
                                            id="task_status" name="task_status" required>
                                        <option value="not_started" {{ old('task_status') == 'not_started' ? 'selected' : '' }}>Not Started</option>
                                        <option value="pending" {{ old('task_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="in_progress" {{ old('task_status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="completed" {{ old('task_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('task_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="task_priority" class="form-control-label">Priority</label>
                                    <select class="form-control @error('task_priority') is-invalid @enderror" 
                                            id="task_priority" name="task_priority" required>
                                        <option value="low" {{ old('task_priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('task_priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('task_priority') == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    @error('task_priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="due_date" class="form-control-label">Due Date</label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                           id="due_date" name="due_date" value="{{ old('due_date') }}" required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="user_id" class="form-control-label">Assigned To</label>
                                    <select class="form-control @error('user_id') is-invalid @enderror" 
                                            id="user_id" name="user_id" required>
                                        <option value="">Select Staff Member</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->email }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="task_attachments" class="form-control-label">Attachments</label>
                            <input type="file" class="form-control @error('task_attachments.*') is-invalid @enderror" 
                                   id="task_attachments" name="task_attachments[]" multiple>
                            <small class="text-muted">You can select multiple files. Maximum file size: 2MB</small>
                            @error('task_attachments.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Create Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
