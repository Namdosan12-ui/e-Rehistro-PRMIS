@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-b from-gray-900 to-black py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header Section -->
        <div class="bg-gray-800 text-white rounded-lg shadow-lg mb-6 p-6">
            <div class="flex justify-between items-center">
                <div class="flex items-center">
                    <div class="bg-purple-600 rounded-lg p-3 mr-4">
                        <i class="fas fa-list-ol text-3xl text-white"></i>
                    </div>
                    <h1 class="text-3xl font-bold">Queue Display</h1>
                </div>
                <a href="{{ route('reception.queues.index') }}"
                   class="inline-flex items-center px-5 py-3 bg-red-600 hover:bg-red-700 text-white text-lg font-semibold rounded-lg transition">
                    <i class="fas fa-arrow-left mr-2"></i> Back to Queue Management
                </a>
            </div>
        </div>

        <!-- Queue Display Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Pending Queue Column -->
            <div class="bg-blue-700 text-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-blue-900 px-5 py-4 border-b border-blue-400">
                    <h2 class="text-2xl font-bold">Pending</h2>
                </div>
                <div class="divide-y divide-blue-500 max-h-[600px] overflow-y-auto">
                    @forelse($queues->where('status', 'pending') as $queue)
                        <div class="p-5 hover:bg-blue-800 transition">
                            <div class="flex flex-col">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-semibold bg-blue-300 text-blue-900">
                                        Queue #{{ $queue->queuing_number }}
                                    </span>
                                    <span class="text-lg font-medium text-gray-200">
                                        {{ $queue->created_at->format('h:i A') }}
                                    </span>
                                </div>
                                <p class="text-xl font-semibold">{{ $queue->transaction->patient->first_name }} {{ $queue->transaction->patient->last_name }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center text-lg font-semibold">No pending patients</div>
                    @endforelse
                </div>
            </div>

            <!-- In Progress Queue Column -->
            <div class="bg-yellow-600 text-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-yellow-800 px-5 py-4 border-b border-yellow-400">
                    <h2 class="text-2xl font-bold">In Progress</h2>
                </div>
                <div class="divide-y divide-yellow-500 max-h-[600px] overflow-y-auto">
                    @forelse($queues->where('status', 'in_progress') as $queue)
                        <div class="p-5 hover:bg-yellow-700 transition">
                            <div class="flex flex-col">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-semibold bg-yellow-300 text-yellow-900">
                                        Queue #{{ $queue->queuing_number }}
                                    </span>
                                    <span class="text-lg font-medium text-gray-200">
                                        Started: {{ $queue->updated_at->format('h:i A') }}
                                    </span>
                                </div>
                                <p class="text-xl font-semibold">{{ $queue->transaction->patient->first_name }} {{ $queue->transaction->patient->last_name }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center text-lg font-semibold">No patients in progress</div>
                    @endforelse
                </div>
            </div>

            <!-- Completed Queue Column -->
            <div class="bg-green-700 text-white rounded-lg shadow-lg overflow-hidden">
                <div class="bg-green-900 px-5 py-4 border-b border-green-400">
                    <h2 class="text-2xl font-bold">Completed</h2>
                </div>
                <div class="divide-y divide-green-500 max-h-[600px] overflow-y-auto">
                    @forelse($queues->where('status', 'done') as $queue)
                        <div class="p-5 hover:bg-green-800 transition">
                            <div class="flex flex-col">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-semibold bg-green-300 text-green-900">
                                        Queue #{{ $queue->queuing_number }}
                                    </span>
                                    <span class="text-lg font-medium text-gray-200">
                                        {{ $queue->created_at->format('h:i A') }}
                                    </span>
                                </div>
                                <p class="text-xl font-semibold">{{ $queue->transaction->patient->first_name }} {{ $queue->transaction->patient->last_name }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="p-5 text-center text-lg font-semibold">No completed patients</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom scrollbar styling for better visibility */
    .overflow-y-auto::-webkit-scrollbar {
        width: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 5px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.6);
        border-radius: 5px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.9);
    }
</style>
@endsection
