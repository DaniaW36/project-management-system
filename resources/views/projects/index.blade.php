@extends('layouts.master')

@section('content')
<div class="card mb-4">
    <div class="card-header pb-0">
      <h6>Projects List</h6>
      <a href="{{ route('projects.create') }}" class="btn btn-info float-end">Add Project</a>
    </div>
    <div class="card-body px-0 pt-0 pb-2">
      <div class="table-responsive p-0">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project Name</th>
              <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Project Description</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Project Status</th>
              <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($projects as $project)
            <tr>
                <td class="text-sm font-weight-bold mb-0">{{ $project->proj_name }}</td>
                <td class="text-sm text-secondary mb-0">{{ $project->proj_desc }}</td>
                <td class="align-middle text-center text-sm">
                    @php
                        $proj_status = $project->proj_status;
                        $percent = 0;
                        $barClass = '';

                        if ($proj_status == 'Pending') {
                            $percent = 10;
                            $barClass = 'bg-gradient-warning';
                        } elseif ($proj_status == 'In Progress') {
                            $percent = 50;
                            $barClass = 'bg-gradient-info';
                        } elseif ($proj_status == 'On Hold') {
                            $percent = 75;
                            $barClass = 'bg-gradient-secondary';
                        } elseif ($proj_status == 'Completed') {
                            $percent = 100;
                            $barClass = 'bg-gradient-success';
                        }
                    @endphp

                    <div class="d-flex align-items-center justify-content-center">
                      <span class="me-2 text-xs font-weight-bold">{{ $percent }}%</span>
                      <div style="min-width: 100px;">
                        <div class="progress">
                          <div class="progress-bar {{ $barClass }}" role="progressbar" style="width: {{ $percent }}%;" aria-valuenow="{{ $percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                  </td>

                <td class="align-middle text-center">
                    <div class="d-flex justify-content-center gap-2">
                    <a href=" {{ route('projects.show', $project->id) }}" class="btn btn-primary btn-sm">View</a>
                    <a href=" {{ route('projects.edit', $project->id) }}" class="btn btn-warning btn-sm">Edit</a>

                    <form action="/projects/{{$project->id }}" method="POST">
                        @method("DELETE")
                        @csrf
                    <input type="submit" class="btn btn-danger btn-sm" value="Delete" onclick="return confirm('Are you sure you want to delete this project?')">
                </form>
            </div>
                </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
