@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card shadow-lg rounded-4">
            <div class="card-header bg-gradient-primary text-white">
                <h4 class="mb-0">Project Details</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Project Name:</strong>
                    <p>{{ $projects->proj_name ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Description:</strong>
                    <p>{{ $projects->proj_desc ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Status:</strong>
                    <span class="badge
                        @if($projects->proj_status == 'In Progress') bg-gradient-info
                        @elseif($projects->proj_status == 'Completed') bg-gradient-success
                        @elseif($projects->proj_status == 'Pending') bg-gradient-warning
                        @elseif($projects->proj_status == 'On Hold') bg-gradient-secondary
                        @endif">
                        {{ $projects->proj_status ?? 'N/A' }}
                    </span>
                </div>

                <div class="mb-3">
                    <strong>Status Details:</strong>
                    <p>{{ $projects->proj_statusDetails ?? 'No details available' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Start Date:</strong>
                    <p>{{ \Carbon\Carbon::parse($projects->proj_start_date)->format('d M Y') ?? 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>End Date:</strong>
                    <p>{{ \Carbon\Carbon::parse($projects->proj_end_date)->format('d M Y') ?? 'N/A' }}</p>
                </div>

                <!-- Latest Update Time -->
                <div class="mb-3">
                    <strong class="text-uppercase text-primary">Last Updated:</strong>
                    <p>{{ $projects->latest_update ? \Carbon\Carbon::parse($projects->latest_update)->diffForHumans() : 'N/A' }}</p>
                </div>

                <div class="mb-3">
                    <strong>Attachments:</strong>
                    @if($projects->proj_attachments)
                        @php
                            $attachments = json_decode($projects->proj_attachments, true);
                        @endphp
                        @if(is_array($attachments) && count($attachments))
                            <ul class="list-unstyled">
                                @foreach ($attachments as $file)
                                    <li class="mb-3">
                                        @php
                                            $filePath = storage_path('app/public/' . $file);
                                            $fileName = basename($file);
                                            $fileSize = filesize($filePath);
                                            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                                        @endphp

                                        <!-- File Preview for Images and PDFs -->
                                        @if(in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']))
                                            <div class="mb-2">
                                                <strong>Image Preview:</strong><br>
                                                <img src="{{ asset('storage/' . $file) }}" class="img-fluid" style="max-height: 200px;">
                                            </div>
                                        @elseif($fileExtension == 'pdf')
                                            <div class="mb-2">
                                                <strong>PDF Preview:</strong><br>
                                                <!-- PDF Embed -->
                                                <iframe src="{{ asset('storage/' . $file) }}" width="100%" height="300px"></iframe>
                                            </div>
                                        @endif

                                        <!-- File Details -->
                                        <p>
                                            <strong>File Name:</strong> {{ $fileName }}<br>
                                            <strong>File Type:</strong> {{ strtoupper($fileExtension) }}<br>
                                            <strong>File Size:</strong> {{ number_format($fileSize / 1024, 2) }} KB
                                        </p>

                                        <!-- Download Link -->
                                        <a href="{{ asset('storage/' . $file) }}" class="btn btn-sm btn-outline-primary" download>
                                            <i class="fa fa-download"></i> Download File
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>No attachments available.</p>
                        @endif
                    @else
                        <p>No attachments available.</p>
                    @endif
                </div>


                <div class="text-end">
                    <a href="{{ route('projects.index') }}" class="btn btn-secondary">Back to Projects</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
