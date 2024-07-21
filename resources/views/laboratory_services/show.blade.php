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
        {{ __('Laboratory Service Details') }}
    </h2>
</div>

<div class="all-container1">
    <div class="card-body1">
    <div class="form-group">
        <label for="service_name" class="form-label">Service Name</label>
        <input type="text" class="form-control" id="service_name" value="{{ $laboratoryService->service_name }}" readonly>
    </div>

    <div class="form-group">
        <label for="descriptions" class="form-label">Descriptions</label>
        <textarea class="form-control" id="descriptions" readonly>{{ $laboratoryService->descriptions }}</textarea>
    </div>

    <div class="form-group">
        <label for="fee" class="form-label">Fee</label>
        <input type="number" class="form-control" id="fee" value="{{ $laboratoryService->fee }}" step="0.01" readonly>
    </div>

    <div class="form-group">
        <label for="category_id" class="form-label">Category</label>
        <input type="text" class="form-control" id="category_id" value="{{ $laboratoryService->category->name }}" readonly>
    </div>

</div>
<a href="{{ route('laboratory_services.index') }}" class="btn btn-danger">{{ __('Back') }}</a>
</div>
@endsection
