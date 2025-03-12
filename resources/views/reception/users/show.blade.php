@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="card">
    <h1 class="all-header">
        <i class="fas fa-user"></i>
        {{ __('My Profile') }}
    </h1>

    <div class="card-body">
        <!-- Profile Picture Section -->
        <div class="form-group2">
            <label>Profile Picture</label>
            @if (auth()->user()->profile_picture)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}" alt="Profile Picture" class="img-thumbnail" width="100">
                </div>
            @else
                <p>No profile picture uploaded</p>
            @endif
        </div>

        <div class="form-grid">
            <!-- Personal Information -->
            <div class="form-group">
                <label>Full Name</label>
                <div class="form-control">{{ auth()->user()->name }}</div>
            </div>

            <div class="form-group">
                <label>Email Address</label>
                <div class="form-control">{{ auth()->user()->email }}</div>
            </div>

            <div class="form-group">
                <label>Role</label>
                <div class="form-control">{{ auth()->user()->role->role_name }}</div>
            </div>

            <div class="form-group">
                <label>Birthday</label>
                <div class="form-control">
                    {{ auth()->user()->birthday ? date('F d, Y', strtotime(auth()->user()->birthday)) : 'Not provided' }}
                </div>
            </div>

            <!-- Account Details -->
            <div class="form-group">
                <label>Account Created</label>
                <div class="form-control">{{ auth()->user()->created_at->format('F d, Y h:i A') }}</div>
            </div>

            <div class="form-group">
                <label>Last Updated</label>
                <div class="form-control">{{ auth()->user()->updated_at->format('F d, Y h:i A') }}</div>
            </div>

            <!-- Additional User Information (if available) -->
            @if(auth()->user()->phone)
            <div class="form-group">
                <label>Phone Number</label>
                <div class="form-control">{{ auth()->user()->phone }}</div>
            </div>
            @endif

            @if(auth()->user()->address)
            <div class="form-group">
                <label>Address</label>
                <div class="form-control">{{ auth()->user()->address }}</div>
            </div>
            @endif

            @if(auth()->user()->department)
            <div class="form-group">
                <label>Department</label>
                <div class="form-control">{{ auth()->user()->department }}</div>
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="mt-4">
            <a href="{{ route('reception.users.edit', auth()->user()->id) }}" class="btn btn-success1">
                <i class="fas fa-edit"></i> {{ __('Edit Profile') }}
            </a>

            </a>
        </div>
    </div>
</div>
@endsection
