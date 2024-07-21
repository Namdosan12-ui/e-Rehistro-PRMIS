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
                        {{ __('Manage Patients') }}
                    </h2>
                </div>

                <div class="card-body">
                    @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                    @endif

                    <table class="all-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Date of Birth</th>
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
                                <td>{{ $patient->gender }}</td>
                                <td>{{ $patient->contact_information }}</td>
                                <td>{{ $patient->address }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-edit btn-sm">
                                            <i class="fas fa-edit"></i>{{ __('Edit') }}
                                        </a>

                                        <a href="{{ route('patients.transactions', $patient->id) }}" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i> {{ __('Transactions') }}
                                        </a>
                                        
                                        <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-eye"></i> {{ __('View') }}
                                        </a>

                                        <form action="{{ route('patients.destroy', $patient->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this patient?')">
                                                <i class="fas fa-trash"></i>{{ __('Delete') }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <a href="{{ route('patients.create') }}" class="btn btn-success">{{ __('Add Patient') }}</a>
                </div>
            </div>
</div>
@endsection
