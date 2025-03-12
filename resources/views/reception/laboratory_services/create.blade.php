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
    .form-grid4 {
        display: grid;
        gap: 5px;
        grid-template-columns: repeat(2, 1fr);
    }
</style>

<form action="{{ route('reception.laboratory_services.store') }}" method="POST">
    @csrf

<div class="card">
    <div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-8 py-12 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
        <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
        <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>
        <div class="relative flex justify-between items-center">
    <h1 class="all-header">
        <i class="fas fa-vials text-2xl text-orange-600 bg-orange-100 p-3 rounded-lg mr-4"></i>
        {{ __('Add New Laboratory Service') }}
    </h1>

    @if (session('success'))
    <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

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
        <button type="submit" class="px-6 py-3 bg-white text-blue-600 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
            <i class="fas fa-save"></i><span>Add Service</span>
        </button>
        <a href="{{ route('reception.laboratory_services.index') }}" class="px-6 py-3 bg-blue-400/40 text-blue rounded-xl font-semibold hover:bg-blue-400/40 transition-all duration-200 flex items-center space-x-2">
            <i class="fas fa-times"></i><span>Cancel</span>
        </a>
    </div>

</div>
    </div>

    <div class="all">

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
</div>
</div>
</form>

<form action="{{ route('reception.categories.store') }}" method="POST">
    @csrf
<div class="card">
    <div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-8 py-12 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
        <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
        <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>
        <div class="relative flex justify-between items-center">
            <h1 class="all-header">
                <i class="fas fa-vials text-2xl text-red-600 bg-red-100 p-3 rounded-lg mr-4"></i>
                {{ __('Add New Category') }}
            </h1>

            <div class="flex space-x-4">
                <div class="flex justify-end space-x-4 mt-4">
                    <button type="submit" class="px-6 py-3 bg-white text-blue-600 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                        <i class="fas fa-save"></i><span>Update Service</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="all">
        <div class="form-grid5">
            <div class="form-group">
                <label for="name">Category Name</label>
                    <input type="text" class="form-control1" id="name" name="name" value="{{ old('name') }}" required>
                </div>
            </div>
    </div>
</div>
</form>
@endsection
