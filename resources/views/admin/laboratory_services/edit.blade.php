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

<form action="{{ route('admin.laboratory_services.update', $laboratoryService->id) }}" method="POST">
    @csrf
    @method('PUT')

<div class="card">
    <div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-8 py-12 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
        <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
        <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>
        <div class="relative flex justify-between items-center">
            <h1 class="all-header">
                <i class="fas fa-vials text-2xl text-orange-600 bg-orange-100 p-3 rounded-lg mr-4"></i>
                {{ __('Edit Laboratory Service') }}
            </h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="flex space-x-4">
            <!-- Save Button -->
            <div class="flex justify-end space-x-4 mt-4">
                <button type="submit" class="px-6 py-3 bg-white text-blue-600 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-save"></i><span>Update Service</span>
                </button>

                <!-- Cancel Button -->
                <a href="{{ route('admin.laboratory_services.index') }}" class="px-6 py-3 bg-blue-400/40 text-blue rounded-xl font-semibold hover:bg-blue-400/40 transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-times"></i><span>Cancel</span>
                </a>
            </div>
        </div>
        </div>
    </div>

        <div class ="all">

            <div class="form-group gap mb-2">
                <label for="service_name" class="block text-xl font-medium text-gray-700">Service Name</label>
                <input type="text" class="form-control1" id="service_name" name="service_name" value="{{ old('service_name', $laboratoryService->service_name) }}" required>
            </div>

            <div class="form-group gap mb-2">
                <label for="descriptions" class="block text-xl font-medium text-gray-700">Descriptions</label>
                <textarea class="form-control1" id="descriptions" name="descriptions" required>{{ old('descriptions', $laboratoryService->descriptions) }}</textarea>
            </div>

            <div class="form-group gap mb-2">
                <label for="fee" class="block text-xl font-medium text-gray-700">Fee</label>
                <input type="number" class="form-control1" id="fee" name="fee" value="{{ old('fee', $laboratoryService->fee) }}" step="0.01" required>
            </div>

            <div class="form-group gap mb-2">
                <label for="category_id" class="block text-xl font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id" class="form-control1" required>
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ $laboratoryService->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            </div>
        </div>
    </form>
    @endsection
