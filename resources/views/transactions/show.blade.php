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
        {{ __('Transaction Details') }}
    </h2>
</div>

<div class="all-container1">
    <div class="card-body1">

        <div class="form-group">
            <h5 class="card-title">Transaction ID: {{ $transaction->id }}</h5>
            <p class="card-text">Date: {{ $transaction->date }}</p>
            <p class="card-text">Total Payments: {{ $transaction->total_payments }}</p>
            <p class="card-text">Payment Status: {{ $transaction->payment_status }}</p>
            
            @if ($transaction->physician)
            <p class="card-text">Physician: {{ $transaction->physician }}</p>
            @endif

            @if ($transaction->radiologic_technologist)
            <p class="card-text">Radiologic Technologist: {{ $transaction->radiologic_technologist }}</p>
            @endif

            @if ($transaction->queue)
                <h5 class="card-title">Queue Information</h5>
                <p class="card-text">Queue Number: {{ $transaction->queue->queuing_number }}</p>
                <p class="card-text">Queue Created At: {{ $transaction->queue->created_at->format('Y-m-d H:i:s') }}</p>
            @endif
        </div>  

        <div class="form-group">
            <h5 class="card-title">Patient Information</h5>
            <p class="card-text">Name: {{ $transaction->patient->first_name }} {{ $transaction->patient->last_name }}</p>
            <p class="card-text">Date of Birth: {{ $transaction->patient->date_of_birth }}</p>
            <p class="card-text">Gender: {{ $transaction->patient->gender }}</p>
        </div>
        
        <div class="form-group">
            <h5 class="card-title">Last Meal</h5>
            <p class="card-text">Last Meal: {{ $transaction->last_meal }}</p>
        </div>

        <div class="form-group">
            <h5 class="card-title">Services Availed</h5>
            <table class="all-table">
                <thead>
                    <tr>
                        <th>Service Name</th>
                        <th>Description</th>
                        <th>Fee</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->services as $service)
                    <tr>
                        <td>{{ $service->service_name }}</td>
                        <td>{{ $service->descriptions }}</td>
                        <td>{{ $service->fee }}</td> <!-- Directly accessing fee from laboratory_services table -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <!-- Drug Test Consent Section -->
        <div class="form-group">
            <h5 class="card-title">Drug Test Consent</h5>
            <p class="card-text">
                Purpose of Drug Test: {{ $transaction->drug_test_purpose }}
                <br>
                Confirmatory Testing Agreement:
                @if ($transaction->confirmatory_testing_agreement === 'accepted')
                    Accepted
                @else
                    Not Accepted
                @endif
                <br>
                Sample Acknowledgement:
                @if ($transaction->sample_acknowledgement)
                    Acknowledged
                @else
                    Not Acknowledged
                @endif
                <br>
                Medication in the Past 30 Days:
                @if ($transaction->medication_past_30_days)
                    Yes
                @else
                    No
                @endif
                <br>
                Alcohol in the Past 24 Hours:
                @if ($transaction->alcohol_past_24_hours)
                    Yes
                @else
                    No
                @endif
                <br>
                
                Sample Type: {{ $transaction->sample_type }}
                <br>
            </p>
        </div>

        <!-- Instructions Section -->
        <div class="row justify-content-center mt-4">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Instructions') }}</div>
                    <div class="card-body">
                        <h2>Fasting and Reminder</h2>
                        <p>
                            Please ensure that the patient has fasted for at least 8 hours before the transaction.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <a href="javascript:window.print()" class="btn btn-primary">Print</a>
        <a href="{{ route('transactions.index') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
    </div>
</div>

@endsection
