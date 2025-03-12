@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="card">
<h2 class="all-header">
    <i class="fas fa-user"></i>
    {{ __('Edit Laboratory Service') }}
</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class ="card-body">
            <form action="{{ route('medicaltechnologist.laboratory_services.update', $laboratoryService->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="service_name">Service Name</label>
                    <input type="text" class="form-control1" id="service_name" name="service_name" value="{{ old('service_name', $laboratoryService->service_name) }}" required>
                </div>

                <div class="form-group">
                    <label for="descriptions">Descriptions</label>
                    <textarea class="form-control1" id="descriptions" name="descriptions" required>{{ old('descriptions', $laboratoryService->descriptions) }}</textarea>
                </div>

                <div class="form-group">
                    <label for="fee">Fee</label>
                    <input type="number" class="form-control1" id="fee" name="fee" value="{{ old('fee', $laboratoryService->fee) }}" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Category</label>
                    <select name="category_id" id="category_id" class="form-control1" required>
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $laboratoryService->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-success1">{{ __('Update Service') }}</button>
                <a href="{{ route('medicaltechnologist.laboratory_services.index') }}" class="btn btn-cancel"> {{ __('Cancel') }}</a>

            </form>
            </div>
        </div>
    @endsection
