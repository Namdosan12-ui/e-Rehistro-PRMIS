<div>
   <!-- resources/views/profiles/confirm-delete.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Confirm Deletion</h2>
        <p>Are you sure you want to delete this profile?</p>
        <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Confirm Delete</button>
            <a href="{{ route('profiles.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection

</div>
