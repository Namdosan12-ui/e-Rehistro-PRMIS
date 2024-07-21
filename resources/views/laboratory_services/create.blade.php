@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="header-background1">
    <h2 class="all-header1">
        <i class="fas fa-user"></i>
        {{ __('Add New Laboratory Service') }}
    </h2>
</div>

<div class="all-container1">
    <div class="card-body1">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('laboratory_services.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="service_name" class="form-label">Service Name</label>
                <input type="text" class="form-control" id="service_name" name="service_name" value="{{ old('service_name') }}" required>
            </div>

            <div class="form-group">
                <label for="descriptions" class="form-label">Descriptions</label>
                <textarea class="form-control" id="descriptions" name="descriptions" required>{{ old('descriptions') }}</textarea>
            </div>

            <div class="form-group">
                <label for="fee" class="form-label">Fee</label>
                <input type="number" class="form-control" id="fee" name="fee" value="{{ old('fee') }}" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="category_id" class="form-label">Category</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Add Service</button>
            <a href="{{ route('laboratory_services.index') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
        </form>

        <hr>

        <h2>Add New Category</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Category Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Add Category</button>
        </form>
    </div>
        </div>
@endsection
