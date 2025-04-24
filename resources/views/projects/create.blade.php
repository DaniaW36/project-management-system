@extends('layouts.master')

@section('content')
<div class="card mb-4">
    <div class="card-header pb-0">
      <h6>Add New Project</h6>
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
        <form action="/projects" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Project Name -->
            <div class="form-group">
                <label for="proj_name">Project Name</label>
                <input type="text" class="form-control" id="proj_name" name="proj_name" required placeholder="Enter project name">

            </div>

            <!-- Project Description -->
            <div class="form-group">
                <label for="proj_desc">Project Description</label>
                <textarea class="form-control" id="proj_desc" name="proj_desc" required placeholder="Enter project description"></textarea>
            </div>

            <!-- Project Status -->
            <div class="form-group">
                <label for="proj_status">Project Status</label>
                <select class="form-control" id="proj_status" name="proj_status" required>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                    <option value="Pending">Pending</option>
                    <option value="On Hold">On Hold</option>
                </select>
            </div>

            <!-- Project Status Details -->
            <div class="form-group">
                <label for="proj_statusDetails">Status Details</label>
                <textarea class="form-control" id="proj_statusDetails" name="proj_statusDetails" rows="3" placeholder="Enter status details (optional)"></textarea>
            </div>

            <!-- Start Date -->
            <div class="form-group">
                <label for="proj_start_date">Start Date</label>
                <input type="date" class="form-control" id="proj_start_date" name="proj_start_date">
            </div>

            <!-- End Date -->
            <div class="form-group">
                <label for="proj_end_date">End Date</label>
                <input type="date" class="form-control" id="proj_end_date" name="proj_end_date">
            </div>

            <!-- Attachments -->
            <div class="form-group">
                <label for="proj_attachments">Project Attachments</label>
                <input type="file" class="form-control-file" id="proj_attachments" name="proj_attachments[]" multiple>
            </div>

            <button type="submit" class="btn btn-primary">Create Project</button>
        </form>
    </div>
  </div>
</div>
</div>
@endsection
