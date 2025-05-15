@extends('layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <!-- Profile Information -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Profile Information</h6>
                    <p class="text-sm mb-0">Update your account's profile information and email address.</p>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name" class="form-control-label">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                        id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-control-label">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="department" class="form-control-label">Department</label>
                                    <input type="text" class="form-control @error('department') is-invalid @enderror" 
                                        id="department" name="department" value="{{ old('department', $user->department) }}">
                                    @error('department')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="phone" class="form-control-label">Phone Number</label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                        id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="profile_pic" class="form-control-label">Profile Picture</label>
                                    <input type="file" class="form-control @error('profile_pic') is-invalid @enderror" 
                                        id="profile_pic" name="profile_pic" accept="image/*">
                                    @error('profile_pic')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Maximum file size: 2MB. Allowed formats: JPG, PNG, GIF</small>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Profile Preview -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header pb-0">
                    <h6>Profile Preview</h6>
                </div>
                <div class="card-body text-center">
                    <div class="avatar avatar-xl rounded-circle bg-gradient-primary mb-3">
                        @if($user->profile_pic)
                            <img src="{{ Storage::url($user->profile_pic) }}" alt="Profile Picture" 
                                class="avatar avatar-xl rounded-circle">
                        @else
                            <span class="text-white text-lg">{{ substr($user->name, 0, 1) }}</span>
                        @endif
                    </div>
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-sm text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="mt-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-sm">Department</span>
                            <span class="text-sm font-weight-bold">{{ $user->department ?? 'Not Set' }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-sm">Phone</span>
                            <span class="text-sm font-weight-bold">{{ $user->phone ?? 'Not Set' }}</span>
                        </div>
                        
                    </div>
                </div>
            </div>

            <!-- Account Security -->
            <div class="card mt-4">
                <div class="card-header pb-0">
                    <h6>Account Security</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0">Password</h6>
                            <p class="text-sm text-muted mb-0">Change your current password</p>
                        </div>
                        <a href="{{ route('profile.password.change.form') }}" class="btn btn-sm btn-outline-secondary">Change Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview profile picture before upload
    const profilePicInput = document.getElementById('profile_pic');
    const profilePreview = document.querySelector('.avatar img');
    const profileInitial = document.querySelector('.avatar span');

    profilePicInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if (profilePreview) {
                    profilePreview.src = e.target.result;
                } else {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'avatar avatar-xl rounded-circle';
                    profileInitial.parentNode.replaceChild(img, profileInitial);
                }
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush
