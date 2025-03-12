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
        {{ __('Queue Details') }}
    </h2>
</div>

<div class="all-container1">
    <div class="card-body1">

    <div class="form-group">
        <label for="transaction_id" class="col-sm-2 col-form-label">Transaction ID</label>
        <div class="col-sm-10">
            <p>{{ $queue->transaction_id }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="patient_name" class="col-sm-2 col-form-label">Patient Name</label>
        <div class="col-sm-10">
            <p>{{ $queue->transaction->patient->first_name }} {{ $queue->transaction->patient->last_name }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="queuing_number" class="col-sm-2 col-form-label">Queuing Number</label>
        <div class="col-sm-10">
            <p>{{ $queue->queuing_number }}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-10">
            <p>{{ $queue->status }}</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-10 offset-sm-2">
            <a href="{{ route('radiologictechnologist.queues.index') }}" class="btn btn-secondary">Back to Queues</a>
        </div>
    </div>
</div>
</div>
@endsection
