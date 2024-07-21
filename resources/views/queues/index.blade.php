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

        <a href="{{ route('queue.display') }}" class="btn btn-primary">View Queue Display</a>

    <table class="all-table">
        <thead>
            <tr>
                <th>Queuing Number</th>
                <th>Transaction ID</th>
                <th>Patient Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($queues as $queue)
                <tr>
                    <td>{{ $queue->queuing_number }}</td>
                    <td>{{ $queue->transaction_id }}</td>
                    <td>{{ $queue->transaction->patient->first_name }} {{ $queue->transaction->patient->last_name }}</td>
                    <td>

                        <form action="{{ route('queues.markAsDone', $queue->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="btn btn-success">Mark as Done</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
        </div>
    </div>
@endsection
