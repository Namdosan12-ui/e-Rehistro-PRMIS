@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="all-container">
    <div class="card">
        <div class="card-header">
            <h2 class="all-header">
                <i class="fas fa-users"></i>
                {{ __('Laboratory Services') }}
            </h2>
        </div>

        <div class="card-body">
            <form action="{{ route('laboratory_services.index') }}" method="GET" class="form-inline mb-3">
                <label for="search_by" class="mr-2">Select what to search:</label>
                <div class="input-group">
                    <select name="search_by" id="search_by" class="custom-select mr-3">
                        <option value="select" selected>None</option>
                        <option value="service_name">Service Name</option>
                        <option value="descriptions">Descriptions</option>
                        <option value="fee">Fee</option>
                        <option value="category">Category</option>
                    </select>
                    <input type="text" name="search" id="search" class="form-control mr-5" placeholder="Type here...">

                    <div class="input-group-append">
                        <button type="submit" class="btn btn-primary mr-3"><i class="fas fa-search"></i>Search</button>
                        <a href="{{ route('laboratory_services.index') }}" class="btn btn-danger"> <i class="fas fa-times"></i> Clear</a>
                    </div>
                </div>
            </form>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <table class="all-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Category</th>
                        <th>Fee</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach ($services as $service)
                    <tr>
                        <td>{{ $service->id }}</td>
                        <td>{{ $service->service_name }}</td>
                        <td>{{ $service->category->name }}</td> <!-- Assuming 'name' is the attribute of the Category model -->
                        <td>{{ $service->fee }}</td>
                        <td>
                            <a href="{{ route('laboratory_services.show', $service->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View Info</a>
                            <a href="{{ route('laboratory_services.edit', $service->id) }}" class="btn btn-edit btn-sm"><i class="fas fa-edit"></i> Edit</a>
                            <form action="{{ route('laboratory_services.destroy', $service->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i> Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                

                </tbody>
            </table>
            <a href="{{ route('laboratory_services.create') }}" class="btn btn-success">{{ __('New Service') }}</a>
        </div>
    </div>
</div>
@endsection
