@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="card pt-16 ">
    <h1 class="all-header">
        <i class="fas fa-users-cog text-2xl text-blue-600 bg-blue-100 p-3 rounded-lg mr-4"></i>
        {{ __('User Management') }}
    </h1>



    <div class="card-body">
        @if(session('success'))
        <div id="successMessage" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <div class="table-container">
            <table class="all-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Birthday</th>
                        <th>License No</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->role->role_name }}</td>
                            <td>{{ $user->birthday ? $user->birthday->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $user->license_no ?? 'N/A' }}</td>
                            <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $user->updated_at->format('Y-m-d H:i:s') }}</td>
                            <td>
                                <div class="button-group">
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-edit btn-sm">
                                        <i class="fas fa-edit"></i> {{ __('Edit') }}
                                    </a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?')">
                                            <i class="fas fa-trash"></i> {{ __('Delete') }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-success">{{ __('Add User') }}</a>
</div>

<!-- Script to Hide Success Message after 5 Seconds -->
<script>
    setTimeout(function() {
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 2000); // 2000 milliseconds = 2 seconds
</script>

@endsection
