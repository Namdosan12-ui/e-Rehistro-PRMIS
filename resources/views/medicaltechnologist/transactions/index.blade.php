@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="card">
    <h1 class="all-header">
        <i class="fas fa-users"></i>
        {{ __('Transactions') }}
    </h1>

    <div class="card-body">
        @if (session('success'))
            <div id="successMessage" class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('medicaltechnologist.transactions.create') }}" class="btn btn-avail">Avail Services</a>

        <div class="table-container">
            <table class="all-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient</th>
                        <th>Availed Laboratory Services</th>
                        <th>Date</th>
                        <th>Total Payments</th>
                        <th>Payment Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->id }}</td>
                            <td>{{ $transaction->patient->first_name }} {{ $transaction->patient->last_name }}</td>
                            <td>
                                <ul>
                                    @foreach ($transaction->services as $service)
                                        <li>{{ $service->service_name }} - PHP {{ number_format($service->fee, 2) }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>{{ $transaction->date }}</td>
                            <td>PHP {{ number_format($transaction->total_payments, 2) }}</td>
                            <td>
                                @if ($transaction->payment_status == 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @else
                                    <span class="badge bg-warning text-dark">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                <div class="button-group">
                                    <a href="{{ route('medicaltechnologist.transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-eye"></i> {{ __('View') }}
                                    </a>

                                    <form action="{{ route('medicaltechnologist.transactions.destroy', $transaction->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>

                                    @if ($transaction->payment_status == 'unpaid')
                                        <form action="{{ route('medicaltechnologist.transactions.markPaid', $transaction->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-paid">Mark as Paid</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{ $transactions->links() }}
        </div>

        <!-- Script to Hide Success Message after 5 Seconds -->
        <script>
            setTimeout(function() {
                const successMessage = document.getElementById('successMessage');
                if (successMessage) {
                    successMessage.style.display = 'none';
                }
            }, 2000); // 2000 milliseconds = 2 seconds
        </script>
    </div>
</div>

@endsection
