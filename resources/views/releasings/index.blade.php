@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Releasing</h1>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Patient Name</th>
                <th>Result File</th>
                <th>Actions</th>
                <th>Release</th>
                <th>Release Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($releasings as $releasing)
            <tr>
                <td>{{ $releasing->transaction_id }}</td>
                <td>{{ $releasing->transaction->patient->first_name }} {{ $releasing->transaction->patient->last_name }}</td>
                <td>
                    @if ($releasing->result_file)
                        <a href="{{ route('releasings.view', $releasing->id) }}" target="_blank">View Result</a>
                    @else
                        No result uploaded
                    @endif
                </td>
                <td>
                    @include('partials.upload_form', ['releasing' => $releasing])
                    @include('partials.email_form', ['releasing' => $releasing])
                </td>
                <td>
                    @include('partials.release_form', ['releasing' => $releasing])
                </td>
                <td>
                    {{ $releasing->releasing_status }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
