@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="card">
    <h2 class="all-header">
        <i class="fas fa-user"></i>
        {{ __('Add New Laboratory Service') }}
    </h2>

    <div class="card-body1">

        @if (session('success'))
        <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container0">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('medicaltechnologist.laboratory_services.store') }}" method="POST">
                @csrf
                <div class="form-grid4">
                    <div class="form-group">
                        <label for="service_name">Service Name</label>
                        <input type="text" class="form-control1" id="service_name" name="service_name" value="{{ old('service_name') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category</label>
                        <select name="category_id" id="category_id" class="form-control1" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descriptions">Descriptions</label>
                        <textarea class="form-control1" id="descriptions" name="descriptions" required>{{ old('descriptions') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="fee">Fee</label>
                        <input type="number" class="form-control1" id="fee" name="fee" value="{{ old('fee') }}" step="0.01" required>
                    </div>

                </div>

                <div class="button-group1">
                    <button type="submit" class="btn btn-success5">Add Service</button>
                    <a href="{{ route('medicaltechnologist.laboratory_services.index') }}" class="btn btn-cancel5">{{ __('Cancel') }}</a>
                </div>
            </form>

        </div>
    </div>
</div>

<div class="card">
    <h2 class="all-header">
        <i class="fas fa-user"></i>
        {{ __('Add New Category') }}
    </h2>

    <div class="card-body3">

            <form action="{{ route('medicaltechnologist.categories.store') }}" method="POST">
                @csrf
                <div class="form-grid5">
                    <div class="form-group">
                        <label for="name">Category Name</label>
                        <input type="text" class="form-control1" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                </div>
                <div class="button-group1">
                    <button type="submit" class="btn btn-success6">Add Category</button>
                </div>
            </form>
    </div>
</div>
@endsection
