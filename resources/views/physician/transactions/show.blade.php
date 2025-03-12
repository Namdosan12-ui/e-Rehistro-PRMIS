@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="card">
    <h2 class="all-header">
        <i class="fas fa-user"></i>
        {{ __('Transaction Details') }}
    </h2>

    <div class="card-body">
        <div class="table-container">
            <div class="form-grid6">
                <div class="form-group6">
                    <h5 class="card-title6">Transaction ID: {{ $transaction->id }}</h5>
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
                        <h5 class="card-title6">Queue Information</h5>
                        <p class="card-text">Queue Number: {{ $transaction->queue->queuing_number }}</p>
                        <p class="card-text">Queue Created At: {{ $transaction->queue->created_at->format('Y-m-d H:i:s') }}</p>
                    @endif
                </div>

                <div class="form-group6">
                    <h5 class="card-title6">Patient Information</h5>
                    <p class="card-text">Name: {{ $transaction->patient->first_name }} {{ $transaction->patient->last_name }}</p>
                    <p class="card-text">Date of Birth: {{ $transaction->patient->date_of_birth }}</p>
                    <p class="card-text">Gender: {{ $transaction->patient->gender }}</p>
                </div>

                <div class="form-group6">
                    <h5 class="card-title6">Last Meal</h5>
                    <p class="card-text">Last Meal: {{ $transaction->last_meal }}</p>
                </div>
            </div>

            <div class="form-grid6">
            <div class="form-group7">
                <h5 class="card-title6">Services Availed</h5>
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
                            <td>{{ $service->fee }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Drug Test Consent Section -->
            <div class="form-group8">
                <h5 class="card-title6">Drug Test Consent</h5>
                <p class="card-text">
                    Purpose of Drug Test: {{ $transaction->drug_test_purpose }}<br>
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
                    Sample Type: {{ $transaction->sample_type }}<br>
                </p>
            </div>
            </div>

            <!-- Consultation Information Section -->
            <div class="form-group6">
                <h5 class="card-title6">Consultation Details</h5>
                @if ($transaction->consultation)
                    <p class="card-text">Consultation ID: {{ $transaction->consultation->id }}</p>
                    <p class="card-text">Consultation Date: {{ $transaction->consultation->date->format('Y-m-d') }}</p>
                    <p class="card-text">Symptoms: {{ $transaction->consultation->symptoms }}</p>
                    <p class="card-text">Diagnoses: {{ $transaction->consultation->diagnoses }}</p>
                    <p class="card-text">Treatment Plan: {{ $transaction->consultation->treatment_plan }}</p>
                    <p class="card-text">Status: {{ $transaction->consultation->status }}</p>
                @else
                    <p class="card-text">No consultation details available.</p>
                @endif
            </div>

            <!-- Instructions Section -->
                        <div class="ins">{{ __('Instructions') }}</div>
                        <div class="card-body4">
                            <h2>Fasting and Reminder</h2>
                            <p>Please ensure that the patient has fasted for at least 8 hours before the transaction.</p>
                        </div>
        </div>

        <a href="{{ route('physician.transactions.edit', $transaction->id) }}" class="btn btn-warning">Edit Transaction</a>
        <a href="javascript:window.print()" class="btn btn-primary">Print</a>
        <a href="{{ route('physician.transactions.index') }}" class="btn btn-cancel6">{{ __('Cancel') }}</a>
    </div>
</div>

@endsection
