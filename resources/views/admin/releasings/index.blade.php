@extends('layouts.app')

@section('content')
<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="card">
    <h1 class="all-header">
        <i class="fas fa-file-export text-2xl text-pink-600 bg-pink-100 p-3 rounded-lg mr-4"></i>
        {{ __('Releasing') }}
    </h1>

    @if (session('success'))
        <div id="successMessage" class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {!! session('error') !!}
        </div>
    @endif

    <div class="table-container">
        <table class="all-table">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Patient Name</th>
                    <th>Result File</th>
                    <th>Actions</th>
                    <th>Release</th>
                    <th>Release Status</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($releasings as $releasing)
                    <tr>
                        <td>{{ $releasing->transaction_id }}</td>
                        <td>{{ $releasing->transaction->patient->first_name }} {{ $releasing->transaction->patient->last_name }}</td>
                        <td>
                            @if ($releasing->result_file)
                                <a href="{{ route('admin.releasings.view', $releasing->id) }}" target="_blank">View Result</a>
                            @else
                                No result uploaded
                            @endif
                        </td>
                        <td>
                            @if (!$releasing->result_file)
                                <form action="{{ route('admin.releasings.upload', $releasing->id) }}" method="POST" enctype="multipart/form-data" class="upload-form">
                                    @csrf
                                    <div class="form-group">
                                        <label for="result_file">Choose File:</label>
                                        <input type="file" id="result_file" name="result_file" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </form>
                            @elseif ($releasing->result_file && !$releasing->released_at)
                                @include('admin.partials.email-form', ['releasing' => $releasing])
                            @endif
                        </td>
                        <td>
                            @if (!$releasing->released_at)
                                @include('admin.partials.release_form', ['releasing' => $releasing])
                            @else
                                {{ \Carbon\Carbon::parse($releasing->released_at)->format('Y-m-d') }}
                            @endif
                        </td>
                        <td>
                            {{ $releasing->releasing_status }}
                        </td>
                        <td>
                            <form action="{{ route('admin.releasings.destroy', $releasing->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this releasing record?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <script>
            setTimeout(function() {
                const successMessage = document.getElementById('successMessage');
                if (successMessage) {
                    successMessage.style.display = 'none';
                }
            }, 2000);
        </script>
    </div>
</div>
@endsection
