@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Link to the new CSS file -->
</head>

<div class="card">
    <h1 class="all-header">
        <i class="fas fa-vials text-2xl text-orange-600 bg-orange-100 p-3 rounded-lg mr-4"></i>
        {{ __('Laboratory Services') }}
    </h1>

    <form action="{{ route('physician.laboratory_services.index') }}" method="GET" class="form-inline mb-3">
        <label for="search_by" class="text">Select what to search:</label>
        <div class="input-group">
            <select name="search_by" id="search_by" class="custom-select">
                <option value="select" selected>None</option>
                <option value="service_name">Service Name</option>
                <option value="descriptions">Descriptions</option>
                <option value="fee">Fee</option>
                <option value="category">Category</option>
            </select>
            <input type="text" name="search" id="search" class="form-control" placeholder="Type here...">
            <div class="input-group-append">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                <a href="{{ route('physician.laboratory_services.index') }}" class="btn btn-clr"><i class="fas fa-times"></i> Clear</a>
            </div>
        </div>
    </form>

    <div class="card-body">
        @if (session('success'))
        <div id="successMessage" class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
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
                            <td>{{ $service->category->name }}</td>
                            <td>{{ $service->fee }}</td>
                            <td>
                                <div class="action-buttons">
                                <a href="{{ route('physician.laboratory_services.show', $service->id) }}" class="btn btn-info btn-sm"><i class="fas fa-eye"></i> View Info</a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- S  cript to Hide Success Message after 5 Seconds -->
<script>
    setTimeout(function() {
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 2000); // 2000 milliseconds = 2 seconds
</script>

@endsection
