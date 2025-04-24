@extends('layouts.master')

@section('content')
<div class="card mb-4">
    <div class="card-header pb-0">
        <h6>Edit Project</h6>
    </div>
    <div class="card-body px-2 pt-0 pb-2">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form to edit project details -->
        <form action="{{ route('projects.update', $projects->id) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            <!-- Project Name -->
            <div class="form-group">
                <label for="proj_name">Project Name</label>
                <input type="text" class="form-control" id="proj_name" name="proj_name" required placeholder="Enter project name" value="{{ $projects->proj_name ?? '' }}">
            </div>

            <!-- Project Description -->
            <div class="form-group">
                <label for="proj_desc">Project Description</label>
                <textarea class="form-control" id="proj_desc" name="proj_desc" required placeholder="Enter project description">{{ old('proj_desc', $projects->proj_desc ?? '') }}</textarea>
            </div>

            <!-- Project Status -->
            <div class="form-group">
                <label for="proj_status">Project Status</label>
                <select class="form-control" id="proj_status" name="proj_status" required>
                    @foreach(['In Progress', 'Completed', 'Pending', 'On Hold'] as $status)
                        <option value="{{ $status }}" {{ old('proj_status', $projects->proj_status ?? '') == $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Project Status Details -->
            <div class="form-group">
                <label for="proj_statusDetails">Status Details</label>
                <textarea class="form-control" id="proj_statusDetails" name="proj_statusDetails" rows="3" placeholder="Enter status details (optional)">{{ old('proj_statusDetails', $projects->proj_statusDetails ?? '') }}</textarea>
            </div>

            <!-- Start Date -->
            <div class="form-group">
                <label for="proj_start_date">Start Date</label>
                <input type="date" class="form-control" id="proj_start_date" name="proj_start_date" value="{{ old('proj_start_date', $projects->proj_start_date ?? '') }}">
            </div>

            <!-- End Date -->
            <div class="form-group">
                <label for="proj_end_date">End Date</label>
                <input type="date" class="form-control" id="proj_end_date" name="proj_end_date" value="{{ old('proj_end_date', $projects->proj_end_date ?? '') }}">
            </div>

            <!-- Attachments Upload -->
            <div class="form-group">
                <label for="proj_attachments">Project Attachments</label>
                <input type="file" class="form-control-file" id="proj_attachments" name="proj_attachments[]" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Update Project</button>
        </form>

        <!-- Display Existing Attachments -->
        @if($projects->proj_attachments)
            <div class="mt-4">
                <label>Existing Attachments:</label>
                <ul class="list-unstyled">
                    @php
                        $attachments = is_array($projects->proj_attachments)
                            ? $projects->proj_attachments
                            : json_decode($projects->proj_attachments, true);
                    @endphp
                    @foreach($attachments as $index => $file)
                        <li class="d-flex align-items-center justify-content-between border-bottom py-2">
                            <a href="{{ asset('storage/' . $file) }}" target="_blank" class="text-primary">
                                {{ basename($file) }}
                            </a>
                            <form action="{{ route('projects.delete-attachment', ['project' => $projects->id, 'index' => $index]) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>
</div>
@endsection
