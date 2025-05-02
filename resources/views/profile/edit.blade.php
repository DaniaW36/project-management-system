@extends('layouts.master')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">My Profile</h2>



    <div class="row">
        <div class="col-md-4 text-center">
            <div class="card shadow-sm p-3">
                <img src="{{ $user->profile_pic ? asset('storage/' . $user->profile_pic) : 'https://via.placeholder.com/150' }}"
                     class="rounded-circle img-fluid mb-3"
                     style="width: 150px; height: 150px; object-fit: cover;"
                     alt="Profile Picture">
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ ucfirst($user->role) }}</p>
            </div>
        </div>

        <div class="col-md-8">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="card shadow-sm p-4">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}">
                </div>

                <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <input type="text" name="department" class="form-control" value="{{ old('department', $user->department) }}">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                </div>

                <div class="mb-3">
                    <label for="profile_pic" class="form-label">Profile Picture</label>
                    <input type="file" name="profile_pic" class="form-control">
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
