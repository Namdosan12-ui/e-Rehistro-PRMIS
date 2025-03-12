@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
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

</style>

<div class="card">
    <h1 class="all-header">
        <i class="fas fa-stethoscope text-2xl text-teal-600 bg-teal-100 p-3 rounded-lg mr-4"></i>
        {{ __('Consultations') }}
    </h1>

    <div class="card-body">
        @if (session('success'))
            <div id="successMessage" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                {{ session('success') }}
            </div>
        @endif

        <a href="{{ route('admin.consultations.create') }}" class="btn btn-success">
            <i></i>Add Consultation</a>

        <div class="table-container">
            <table class="all-table">
                <thead>
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Patient</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Symptoms</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Diagnosis</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Treatment Plan</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($consultations->sortByDesc('created_at') as $consultation)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $consultation->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $consultation->patient->first_name }} {{ $consultation->patient->last_name }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $consultation->date }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $consultation->symptoms }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $consultation->diagnoses }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $consultation->treatment_plan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <div class="flex items-center space-x-2">
                                <!-- View button always visible -->
                                <a href="{{ route('admin.consultations.show', $consultation->id) }}"
                                   class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 hover:bg-blue-200 rounded-md transition duration-150 ease-in-out">
                                    <i class="fas fa-eye mr-1"></i> View
                                </a>

                                <!-- Forward and Edit buttons only visible if status is pending -->
                                @if($consultation->status === 'pending')
                                    <form action="{{ route('admin.consultations.forward', $consultation->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit"
                                                class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 hover:bg-green-200 rounded-md transition duration-150 ease-in-out">
                                            <i class="fas fa-forward mr-1"></i> Forward
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.consultations.edit', $consultation->id) }}"
                                       class="inline-flex items-center px-3 py-1 bg-yellow-100 text-yellow-700 hover:bg-yellow-200 rounded-md transition duration-150 ease-in-out">
                                        <i class="fas fa-edit mr-1"></i> Edit
                                    </a>
                                @endif

                                <!-- Delete button always visible -->
                                <form action="{{ route('admin.consultations.destroy', $consultation->id) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 hover:bg-red-200 rounded-md transition duration-150 ease-in-out">
                                        <i class="fas fa-trash mr-1"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

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
