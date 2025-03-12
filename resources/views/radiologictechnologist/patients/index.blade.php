@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
    .card .btn-success {
    position: absolute;
    background-color: #28a745;
    border-color: #28a745;
    color: white;
    top: 610px;
    right: 35px;
    width: 150px;
    height: 38px;
    font-size: 18px;
    font-weight: 400;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 3px;
}
</style>


<div class="card">
    <h1 class="all-header">
        <i class="fas fa-user-injured text-2xl text-green-600 bg-green-100 p-3 rounded-lg mr-4"></i>
        {{ __('Manage Patient') }}
    </h1>

    <div class="card-body">
        <!-- Search Form -->
        <form action="{{ route('radiologictechnologist.patients.index') }}" method="GET" class="form-inline mb-3">
            <label for="search_by" class="text">Select what to search:</label>
            <div class="input-group">
                <select name="search_by" id="search_by" class="custom-select">
                    <option value="select" selected>None</option>
                    <option value="first_name">First Name</option>
                    <option value="last_name">Last Name</option>
                    <option value="contact_information">Contact Information</option>
                    <option value="address">Address</option>
                    <option value="email_address">Email Address</option>
                </select>
                <input type="text" name="search" id="search" class="form-control" placeholder="Type here...">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
                    <a href="{{ route('radiologictechnologist.patients.index') }}" class="btn btn-clr"><i class="fas fa-times"></i> Clear</a>
                </div>
            </div>
        </form>
        <!-- Success Message Display -->
        @if(session('success'))
            <div id="successMessage" class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        <!-- Patients Table -->
        <div class="table-container">
            <table class="all-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Contact Information</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                        <tr>
                            <td>{{ $patient->id }}</td>
                            <td>{{ $patient->first_name }}</td>
                            <td>{{ $patient->last_name }}</td>
                            <td>{{ $patient->date_of_birth }}</td>
                            <td>
                                @php
                                    $dob = \Carbon\Carbon::parse($patient->date_of_birth);
                                    $age = $dob->age;
                                @endphp
                                {{ $age }}
                            </td>
                            <td>{{ $patient->gender }}</td>
                            <td>{{ $patient->contact_information }}</td>
                            <td>{{ $patient->address }}</td>
                            <td>
                                <div class="button-group">
                                    <a href="{{ route('radiologictechnologist.patients.transactions', $patient->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> {{ __('Transactions') }}
                                    </a>
                                    <a href="{{ route('radiologictechnologist.patients.show', $patient->id) }}" class="btn btn-dts btn-sm">
                                        <i class="fas fa-eye"></i> {{ __('Details') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Patient Button -->

</div>

<!-- Script to Hide Success Message after 5 Seconds -->
<script>
    setTimeout(function() {
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 2000);

    // Keep selected search option after form submission
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        const searchBy = urlParams.get('search_by');
        if (searchBy) {
            document.getElementById('search_by').value = searchBy;
        }
    });
</script>
@endsection
