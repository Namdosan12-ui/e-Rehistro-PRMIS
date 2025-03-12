@extends('layouts.app')

@section('content')
<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
    .all {
        margin-top: 40px;
    }
    .card .btn-success {
        position: absolute;
        background-color: #28a745;
        border-color: #28a745;
        color: white;
        top: 70px;
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
    .column-container {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        padding: 20px;
    }
    .queue-column {
        background: white;
        border-radius: 8px;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        max-height: 600px;
        overflow-y: auto;
    }
    .queue-card {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 12px;
        margin-bottom: 12px;
    }
    .queue-title {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
    }
    .patient-info {
        font-size: 0.9em;
        color: #666;
        margin-top: 4px;
    }
    .release-btn {
        background-color: #28a745;
        color: white;
        padding: 6px 12px;
        border-radius: 4px;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }
    .release-btn:hover {
        background-color: #218838;
    }

    /* Scrollbar styling */
    .queue-column::-webkit-scrollbar {
        width: 6px;
    }

    .queue-column::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .queue-column::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 3px;
    }

    .queue-column::-webkit-scrollbar-thumb:hover {
        background: #555;
    }
</style>

<div class="card">
    <h1 class="all-header">
        <i class="fas fa-list-ol text-2xl text-purple-600 bg-purple-100 p-3 rounded-lg mr-4"></i>
        {{ __('Manage Patients Queues') }}
    </h1>

    @if(session('success'))
        <div id="successMessage" class="alert alert-success mb-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="all">
        <div class="column-container">
            <!-- Patients Column -->
            <div class="queue-column">
                <h2 class="queue-title">Patients</h2>
                @forelse($queues->where('status', 'pending')->take(4) as $pendingQueue)
                    <div class="queue-card">
                        <div class="flex justify-between mb-2">
                            <div>
                                <p class="font-bold">{{ $pendingQueue->transaction->patient->first_name }} {{ $pendingQueue->transaction->patient->last_name }}</p>
                                <p class="patient-info">
                                    @php
                                        $birthDate = new DateTime($pendingQueue->transaction->patient->date_of_birth);
                                        $today = new DateTime();
                                        $age = $birthDate->diff($today)->y;
                                    @endphp
                                    Age: {{ $age }} |
                                    Gender: {{ ucfirst($pendingQueue->transaction->patient->gender) }}
                                </p>
                                <p class="text-sm">Queue #: {{ $pendingQueue->queuing_number }}</p>
                            </div>
                            <div class="button-group">
                                <a href="{{ route('radiologictechnologist.queues.show-transaction', $pendingQueue->transaction_id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('radiologictechnologist.queues.start-process', $pendingQueue->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Start</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center">No pending patients</p>
                @endforelse
            </div>

            <!-- In Progress Column -->
            <div class="queue-column">
                <h2 class="queue-title">In Progress</h2>
                @forelse($queues->where('status', 'in_progress')->take(4) as $progressQueue)
                    <div class="queue-card">
                        <div class="flex justify-between mb-2">
                            <div>
                                <p class="font-bold">{{ $progressQueue->transaction->patient->first_name }} {{ $progressQueue->transaction->patient->last_name }}</p>
                                <p class="patient-info">
                                    @php
                                        $birthDate = new DateTime($progressQueue->transaction->patient->date_of_birth);
                                        $today = new DateTime();
                                        $age = $birthDate->diff($today)->y;
                                    @endphp
                                    Age: {{ $age }} |
                                    Gender: {{ ucfirst($progressQueue->transaction->patient->gender) }}
                                </p>
                                <p class="text-sm">Queue #: {{ $progressQueue->queuing_number }}</p>
                            </div>
                            <div class="button-group">
                                <form action="{{ route('radiologictechnologist.queues.markAsDone', $progressQueue->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-primary btn-sm">Complete</button>
                                </form>
                            </div>
                        </div>
                        <!-- Service Checklist -->
                        <div class="mt-3">
                            @foreach($progressQueue->transaction->services as $service)
                                <div class="flex items-center mb-2">
                                    <input type="checkbox"
                                           id="service_{{ $service->id }}_{{ $progressQueue->id }}"
                                           class="form-checkbox"
                                           onchange="updateServiceStatus({{ $progressQueue->id }}, {{ $service->id }}, this.checked)">
                                    <label for="service_{{ $service->id }}_{{ $progressQueue->id }}" class="ml-2 text-sm">
                                        {{ $service->service_name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center">No in-progress patients</p>
                @endforelse
            </div>

            <!-- Done Column -->
            <div class="queue-column">
                <h2 class="queue-title">Done</h2>
                @forelse($queues->where('status', 'done')->sortByDesc('updated_at')->take(4) as $doneQueue)
                    <div class="queue-card">
                        <div class="flex justify-between mb-2">
                            <div>
                                <p class="font-bold">{{ $doneQueue->transaction->patient->first_name }} {{ $doneQueue->transaction->patient->last_name }}</p>
                                <p class="patient-info">
                                    @php
                                        $birthDate = new DateTime($doneQueue->transaction->patient->date_of_birth);
                                        $today = new DateTime();
                                        $age = $birthDate->diff($today)->y;
                                    @endphp
                                    Age: {{ $age }} |
                                    Gender: {{ ucfirst($doneQueue->transaction->patient->gender) }}
                                </p>
                                <p class="text-sm">Queue #: {{ $doneQueue->queuing_number }}</p>
                                @if($doneQueue->notes)
                                    <p class="text-sm">Notes: {{ $doneQueue->notes }}</p>
                                @endif
                            </div>
                            <div class="button-group">
                                <form action="{{ route('radiologictechnologist.queues.release', $doneQueue->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="release-btn">
                                        Release
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 text-center">No completed patients</p>
                @endforelse
            </div>
        </div>
    </div>

    <a href="{{ route('radiologictechnologist.queue.display') }}" class="btn btn-success">View Queue Display</a>
</div>

<script>
    // Hide success message after 2 seconds
    setTimeout(function() {
        const successMessage = document.getElementById('successMessage');
        if (successMessage) {
            successMessage.style.display = 'none';
        }
    }, 2000);

    // Function to update service status
    function updateServiceStatus(queueId, serviceId, completed) {
        fetch(`/radiologictechnologist/queues/${queueId}/update-service`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                service_id: serviceId,
                completed: completed
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                checkAllServicesCompleted(queueId);
            }
        })
        .catch(error => console.error('Error:', error));
    }

    // Function to check if all services are completed
    function checkAllServicesCompleted(queueId) {
        const checkboxes = document.querySelectorAll(`[id^="service_"][id$="_${queueId}"]`);
        const allCompleted = Array.from(checkboxes).every(checkbox => checkbox.checked);
        const completeButton = document.querySelector(`form[action$="${queueId}"] button`);

        if (completeButton) {
            completeButton.disabled = !allCompleted;
            completeButton.style.opacity = allCompleted ? '1' : '0.5';
        }
    }
</script>
@endsection
