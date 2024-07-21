<div>
  <!-- resources/views/profiles/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Profiles</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Bio</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profiles as $profile)
                <tr>
                    <td>{{ $profile->user->name }}</td>
                    <td>{{ $profile->bio }}</td>
                    <td>{{ $profile->phone }}</td>
                    <td>{{ $profile->address }}</td>
                    <td>
                        <a href="{{ route('profiles.show', $profile->id) }}" class="btn btn-info">View</a>
                        <a href="{{ route('profiles.edit', $profile->id) }}" class="btn btn-primary">Edit</a>
                        <!-- Add delete button with form submission -->
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

</div>
