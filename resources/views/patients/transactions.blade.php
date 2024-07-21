@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="header-background1">
    <h2 class="all-header1">{{ __('Transactions for ') . $patient->first_name . ' ' . $patient->last_name }}</h2>
</div>

<div class="all-container1">

                <div class="card-body1">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Search Form -->
                    <form action="{{ route('transactions.search', ['patient_id' => $patient->id]) }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search transactions...">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i>Search</button>
                        </div>
                    </form>

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
                    <a href="{{ route('patients.index') }}" class="btn btn-primary">{{ __('Back to Patients List') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
