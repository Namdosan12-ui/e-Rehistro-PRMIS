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
    right: 55px;
    width: 200px;
    height: 38px;
    font-size: 18px;
    font-weight: 400;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 3px;
    }

    .input-group {
    display: flex;
    align-items: center;
    top: 90px;
    left: 270px;
    transition: left 0.3s ease;
    }
</style>

<div class="card">
    <h1 class="all-header">
        <i class="fas fa-file-invoice-dollar text-2xl text-yellow-600 bg-yellow-100 p-3 rounded-lg mr-4"></i>
        {{ __('Transactions for ') . $patient->first_name . ' ' . $patient->last_name }}
    </h1>

    <!-- Search Form -->
    <form action="{{ route('radiologictechnologist.transactions.search', ['patient_id' => $patient->id]) }}" method="GET" class="form-inline mb-3 search-form">
        <div class="input-group">
            <input type="text" name="search" id="search" class="form-control" placeholder="Search transactions...">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Search</button>
        </div>
    </form>

    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-container">
            <table class="all-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Services Availed</th>
                        <th>Total Payment</th>
                        <th>Payment Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->date }}</td>
                            <td>
                                <ul>
                                    @foreach ($transaction->services as $service)
                                        <li>{{ $service->service_name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $transaction->total_payments }}</td>
                            <td>{{ $transaction->payment_status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $transactions->links() }} <!-- Pagination links -->
        </div>
        <a href="{{ route('radiologictechnologist.patients.index') }}" class="btn btn-success">{{ __('Back to Patients List') }}</a>
    </div>
</div>

@endsection
