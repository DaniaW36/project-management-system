@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0 d-flex justify-content-between align-items-center">
                    <h6>Edit Project</h6>
                    <a href="{{ route('admin.projects.show', $project) }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to Project
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="proj_name" class="form-control-label">Project Name</label>
                                    <input type="text" class="form-control @error('proj_name') is-invalid @enderror" 
                                           id="proj_name" name="proj_name" value="{{ old('proj_name', $project->proj_name) }}" required>
                                    @error('proj_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="user_id" class="form-control-label">Assigned Staff</label>
                                    <select class="form-control @error('user_id') is-invalid @enderror" 
                                            id="user_id" name="user_id" required>
                                        <option value="">Select Staff Member</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('user_id', $project->user_id) == $user->id ? 'selected' : '' }}>
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
                            <label for="proj_desc" class="form-control-label">Description</label>
                            <textarea class="form-control @error('proj_desc') is-invalid @enderror" 
                                      id="proj_desc" name="proj_desc" rows="3" required>{{ old('proj_desc', $project->proj_desc) }}</textarea>
                            @error('proj_desc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="proj_status" class="form-control-label">Status</label>
                                    <select class="form-control @error('proj_status') is-invalid @enderror" 
                                            id="proj_status" name="proj_status" required>
                                        <option value="Pending" {{ old('proj_status', $project->proj_status) == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="In Progress" {{ old('proj_status', $project->proj_status) == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="On Hold" {{ old('proj_status', $project->proj_status) == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                        <option value="Completed" {{ old('proj_status', $project->proj_status) == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                    @error('proj_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="proj_statusDetails" class="form-control-label">Status Details (Optional)</label>
                                    <textarea class="form-control @error('proj_statusDetails') is-invalid @enderror" 
                                              id="proj_statusDetails" name="proj_statusDetails" rows="1">{{ old('proj_statusDetails', $project->proj_statusDetails) }}</textarea>
                                    @error('proj_statusDetails')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="proj_start_date" class="form-control-label">Start Date</label>
                                    <input type="date" class="form-control @error('proj_start_date') is-invalid @enderror" 
                                           id="proj_start_date" name="proj_start_date" 
                                           value="{{ old('proj_start_date', $project->proj_start_date ? \Carbon\Carbon::parse($project->proj_start_date)->format('Y-m-d') : '') }}"
                                    @error('proj_start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="proj_end_date" class="form-control-label">End Date</label>
                                    <input type="date" class="form-control @error('proj_end_date') is-invalid @enderror" 
                                           id="proj_end_date" name="proj_end_date" 
                                           value="{{ old('proj_end_date', $project->proj_end_date ? \Carbon\Carbon::parse($project->proj_end_date)->format('Y-m-d') : '') }}"
                                    @error('proj_end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="proj_attachments" class="form-control-label">Attachments</label>
                            <input type="file" class="form-control @error('proj_attachments.*') is-invalid @enderror" 
                                   id="proj_attachments" name="proj_attachments[]" multiple>
                            <small class="text-muted">You can select multiple files. Maximum file size: 2MB</small>
                            @error('proj_attachments.*')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        @if($project->proj_attachments && count($project->proj_attachments) > 0)
                            <div class="form-group">
                                <label class="form-control-label">Current Attachments</label>
                                <div class="list-group">
                                    @foreach($project->proj_attachments as $index => $attachment)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="fas fa-file me-2"></i>
                                                {{ basename($attachment) }}
                                            </div>
                                            <div>
                                                <a href="{{ Storage::url($attachment) }}" class="btn btn-link text-info btn-sm" download>
                                                    <i class="fas fa-download"></i>
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-link text-danger btn-sm delete-attachment" 
                                                        data-project-id="{{ $project->id }}"
                                                        data-index="{{ $index }}"
                                                        onclick="return confirm('Are you sure you want to delete this attachment?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Update Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-attachment').forEach(button => {
        button.addEventListener('click', function() {
            const projectId = this.dataset.projectId;
            const index = this.dataset.index;
            
            fetch(`/admin/projects/${projectId}/attachments/${index}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                }
            })
            .then(response => {
                if (response.ok) {
                    // Remove the attachment item from the DOM
                    this.closest('.list-group-item').remove();
                } else {
                    alert('Failed to delete attachment');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while deleting the attachment');
            });
        });
    });
});
</script>
@endpush
@endsection
