@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
    .all {
        margin-top: 40px;
    }
</style>

<div class="card">
    <div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-8 py-12 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
        <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
        <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>
        <div class="relative flex justify-between items-center">
            <h1 class="all-header">
                <i class="fas fa-vials text-2xl text-orange-600 bg-orange-100 p-3 rounded-lg mr-4"></i>
                {{ __('Laboratory Service Details') }}
            </h1>
            <a href="{{ route('radiologictechnologist.laboratory_services.index') }}" class="px-6 py-3 bg-blue-400/40 text-blue rounded-xl font-semibold hover:bg-blue-400/40 transition-all duration-200 flex items-center space-x-2">
                <i class="fas fa-arrow-left"></i> {{ __('Back') }}
            </a>
        </div>
    </div>



<div class="all">
        <div class="form-group gap mb-2">
            <label for="service_name" class="block text-xl font-medium text-gray-700">Service Name</label>
            <input type="text" class="form-control1" id="service_name" value="{{ $laboratoryService->service_name }}" readonly>
        </div>

    <div class="form-group gap mb-2">
        <label for="descriptions" class="block text-xl font-medium text-gray-700">Descriptions</label>
        <textarea class="form-control1" id="descriptions" readonly>{{ $laboratoryService->descriptions }}</textarea>
    </div>

    <div class="form-group gap mb-2">
        <label for="fee" class="block text-xl font-medium text-gray-700">Fee</label>
        <input type="number" class="form-control1" id="fee" value="{{ $laboratoryService->fee }}" step="0.01" readonly>
    </div>

    <div class="form-group gap mb-2">
        <label for="category_id" class="block text-xl font-medium text-gray-700">Category</label>
        <input type="text" class="form-control1" id="category_id" value="{{ $laboratoryService->category->name }}" readonly>
    </div>
</div>
</div>
@endsection
