<div>


@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Confirm Delete Profile</h2>

        <p>Are you sure you want to delete this profile?</p>

        <form action="{{ route('profile.destroy', $profile->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Delete</button>
            <a href="{{ route('profile.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection

</div>
