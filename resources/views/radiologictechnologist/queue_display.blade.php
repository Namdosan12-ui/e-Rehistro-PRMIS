@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Current Queue</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Queue Number</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <!-- Add any other columns you want to display -->
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($queues as $item)
                                    @if ($item->status !== 'done')
                                    <tr>
                                        <td>{{ $item->queuing_number }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ $item->created_at->format('Y-m-d H:i:s') }}</td>
                                        <!-- Add corresponding table columns for additional data -->
                                    </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f0f0f0;
    }

    .card {
        margin-top: 50px;
        border: none;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        background-color: #007bff;
        color: white;
        padding: 15px;
    }

    .card-body {
        padding: 20px;
    }

    .table {
        margin-bottom: 0;
    }
</style>
@endsection
