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
                            <h4 class="mb-0">Create New Project</h4>
                            <p class="mb-0">Add a new project to the system</p>
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

                    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <!-- Project Name -->
                                <div class="form-group mb-4">
                                    <label for="proj_name" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Project Name</label>
                                    <input type="text" class="form-control" id="proj_name" name="proj_name" required 
                                           value="{{ old('proj_name') }}"
                                           placeholder="Enter project name">
                                </div>

                                <!-- Project Description -->
                                <div class="form-group mb-4">
                                    <label for="proj_desc" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Project Description</label>
                                    <textarea class="form-control" id="proj_desc" name="proj_desc" required rows="4"
                                              placeholder="Enter project description">{{ old('proj_desc') }}</textarea>
                                </div>

                                <!-- Project Status -->
                                <div class="form-group mb-4">
                                    <label for="proj_status" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Project Status</label>
                                    <select class="form-select" id="proj_status" name="proj_status" required>
                                        @foreach(['In Progress', 'Completed', 'Pending', 'On Hold'] as $status)
                                            <option value="{{ $status }}" {{ old('proj_status') == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Project Status Details -->
                                <div class="form-group mb-4">
                                    <label for="proj_statusDetails" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Status Details</label>
                                    <textarea class="form-control" id="proj_statusDetails" name="proj_statusDetails" rows="3"
                                              placeholder="Enter status details (optional)">{{ old('proj_statusDetails') }}</textarea>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <!-- Start Date -->
                                <div class="form-group mb-4">
                                    <label for="proj_start_date" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Start Date</label>
                                    <input type="date" class="form-control" id="proj_start_date" name="proj_start_date"
                                           value="{{ old('proj_start_date') }}">
                                </div>

                                <!-- End Date -->
                                <div class="form-group mb-4">
                                    <label for="proj_end_date" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">End Date</label>
                                    <input type="date" class="form-control" id="proj_end_date" name="proj_end_date"
                                           value="{{ old('proj_end_date') }}">
                                </div>

                                <!-- Project Attachments -->
                                <div class="form-group mb-4">
                                    <label for="proj_attachments" class="form-label text-uppercase text-secondary text-xs font-weight-bolder">Project Attachments</label>
                                    <input type="file" class="form-control" id="proj_attachments" name="proj_attachments[]" multiple>
                                    <small class="text-muted">You can select multiple files. Maximum file size: 10MB per file.</small>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create Project
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
