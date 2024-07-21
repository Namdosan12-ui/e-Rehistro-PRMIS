<div>
  <!-- resources/views/profiles/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Profile Details</h2>

        <div>
            <p><strong>User:</strong> {{ $profile->user->name }}</p>
            <p><strong>Bio:</strong> {{ $profile->bio }}</p>
            <p><strong>Phone:</strong> {{ $profile->phone }}</p>
            <p><strong>Address:</strong> {{ $profile->address }}</p>
            <!-- Add more profile details as needed -->
        </div>
    </div>
@endsection

</div>
