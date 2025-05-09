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
                            <h4 class="mb-0">Edit Project</h4>
                            <p class="mb-0">Update project details and attachments</p>
                        </div>
                        <a href="{{ route('projects.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left me-2"></i>Back to Projects
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

                    <form action="{{ route('projects.update', $projects->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Project Name -->
                                <div class="form-group mb-4">
                                    <label for="proj_name" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Project Name</label>
                                    <input type="text" class="form-control" id="proj_name" name="proj_name" required 
                                           value="{{ old('proj_name', $projects->proj_name ?? '') }}"
                                           placeholder="Enter project name">
                                </div>

                                <!-- Project Description -->
                                <div class="form-group mb-4">
                                    <label for="proj_desc" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Project Description</label>
                                    <textarea class="form-control" id="proj_desc" name="proj_desc" required rows="4"
                                              placeholder="Enter project description">{{ old('proj_desc', $projects->proj_desc ?? '') }}</textarea>
                                </div>

                                <!-- Project Status -->
                                <div class="form-group mb-4">
                                    <label for="proj_status" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Project Status</label>
                                    <select class="form-select" id="proj_status" name="proj_status" required>
                                        @foreach(['In Progress', 'Completed', 'Pending', 'On Hold'] as $status)
                                            <option value="{{ $status }}" {{ old('proj_status', $projects->proj_status ?? '') == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Project Status Details -->
                                <div class="form-group mb-4">
                                    <label for="proj_statusDetails" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Status Details</label>
                                    <textarea class="form-control" id="proj_statusDetails" name="proj_statusDetails" rows="3"
                                              placeholder="Enter status details (optional)">{{ old('proj_statusDetails', $projects->proj_statusDetails ?? '') }}</textarea>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <!-- Start Date -->
                                <div class="form-group mb-4">
                                    <label for="proj_start_date" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Start Date</label>
                                    <input type="date" class="form-control" id="proj_start_date" name="proj_start_date"
                                           value="{{ old('proj_start_date', $projects->proj_start_date ?? '') }}">
                                </div>

                                <!-- End Date -->
                                <div class="form-group mb-4">
                                    <label for="proj_end_date" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">End Date</label>
                                    <input type="date" class="form-control" id="proj_end_date" name="proj_end_date"
                                           value="{{ old('proj_end_date', $projects->proj_end_date ?? '') }}">
                                </div>

                                <!-- New Attachments Upload -->
                                <div class="form-group mb-4">
                                    <label for="proj_attachments" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Add New Attachments</label>
                                    <input type="file" class="form-control" id="proj_attachments" name="proj_attachments[]" multiple>
                                    <small class="text-muted">You can select multiple files. Maximum file size: 10MB per file.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Existing Attachments -->
                        @if($projects->proj_attachments)
                            <div class="card mt-4">
                                <div class="card-header pb-0">
                                    <h6 class="mb-0">Existing Attachments</h6>
                                </div>
                                <div class="card-body">
                                    @php
                                        $attachments = is_array($projects->proj_attachments)
                                            ? $projects->proj_attachments
                                            : json_decode($projects->proj_attachments, true);
                                    @endphp
                                    @if(!empty($attachments))
                                        <div class="row">
                                            @foreach($attachments as $index => $file)
                                                <div class="col-md-4 mb-4">
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
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <a href="{{ asset('storage/' . $file) }}" 
                                                                   class="btn btn-sm btn-primary" 
                                                                   target="_blank">
                                                                    <i class="fas fa-eye me-2"></i>View
                                                                </a>
                                                                <form action="{{ route('projects.delete-attachment', ['project' => $projects->id, 'index' => $index]) }}" 
                                                                      method="POST" 
                                                                      onsubmit="return confirm('Are you sure you want to delete this attachment?')">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                                        <i class="fas fa-trash-alt me-2"></i>Delete
                                                                    </button>
                                                                </form>
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

                        <!-- Submit Button -->
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
