<!-- resources/views/registration-slip.blade.php -->
@extends('layouts.public')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8">
    <div class="max-w-3xl mx-auto">
        <!-- Back Button (hidden in print) -->
        <div class="mb-4 px-4 no-print">
            <a href="{{ url('/') }}" class="inline-flex items-center text-gray-700 hover:text-gray-900">
                <i class="fas fa-arrow-left mr-2"></i> Back to Home
            </a>
        </div>

        <!-- Registration Slip Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <!-- Header -->
            <div class="relative bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3">
                <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
                <div class="relative flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo.png') }}" alt="EPH Logo" class="h-10 w-10">
                        <div>
                            <h1 class="text-lg font-bold text-white">Patient Registration Slip</h1>
                            <p class="text-sm text-blue-100">e-Rehistro EPH</p>
                        </div>
                    </div>
                    <div class="text-right text-white">
                        <p class="text-xs">Registration Date:</p>
                        <p class="text-sm font-semibold">{{ now()->format('F d, Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Success Message (hidden in print) -->
            <div class="bg-green-50 p-3 border-b border-green-100 no-print">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400 text-lg"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-green-800">Registration Successful</h3>
                        <p class="text-sm text-green-700">Your registration has been successfully processed.</p>
                    </div>
                </div>
            </div>

            <!-- Patient Information -->
            <div class="p-4">
                <div class="mb-4">
                    <h2 class="text-base font-semibold text-gray-900 mb-3">Personal Information</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @if($patient->profile_picture)
                        <div class="md:col-span-2 flex justify-center mb-2">
                            <img src="{{ asset('storage/' . $patient->profile_picture) }}"
                                 alt="Profile Picture"
                                 class="w-24 h-24 rounded-full object-cover border-2 border-blue-100">
                        </div>
                        @endif

                        <!-- Two-column grid for patient details -->
                        <div class="grid grid-cols-2 md:col-span-2 gap-3">
                            <!-- Name -->
                            <div class="info-group">
                                <label class="text-xs font-medium text-gray-500">Full Name</label>
                                <p class="text-sm text-gray-900">{{ $patient->first_name }} {{ $patient->last_name }}</p>
                            </div>

                            <!-- Date of Birth -->
                            <div class="info-group">
                                <label class="text-xs font-medium text-gray-500">Date of Birth</label>
                                <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') }}</p>
                            </div>

                              <!-- Age (New Field) -->
                            <div class="info-group">
                                <label class="text-xs font-medium text-gray-500">Age</label>
                                <p class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($patient->date_of_birth)->age }} years old</p>
                            </div>
                            <!-- Gender -->
                            <div class="info-group">
                                <label class="text-xs font-medium text-gray-500">Gender</label>
                                <p class="text-sm text-gray-900">{{ ucfirst($patient->gender) }}</p>
                            </div>

                            <!-- Civil Status -->
                            <div class="info-group">
                                <label class="text-xs font-medium text-gray-500">Civil Status</label>
                                <p class="text-sm text-gray-900">{{ ucfirst($patient->civil_status) }}</p>
                            </div>

                            <!-- Contact Information -->
                            <div class="info-group">
                                <label class="text-xs font-medium text-gray-500">Contact Number</label>
                                <p class="text-sm text-gray-900">{{ $patient->contact_information }}</p>
                            </div>

                            <!-- Email -->
                            <div class="info-group">
                                <label class="text-xs font-medium text-gray-500">Email Address</label>
                                <p class="text-sm text-gray-900">{{ $patient->email_address }}</p>
                            </div>

                            <!-- Occupation -->
                            <div class="info-group">
                                <label class="text-xs font-medium text-gray-500">Occupation</label>
                                <p class="text-sm text-gray-900">{{ $patient->occupation }}</p>
                            </div>

                            <!-- Patient ID -->
                            <div class="info-group">
                                <label class="text-xs font-medium text-gray-500">Patient ID</label>
                                <p class="text-sm font-mono font-bold text-gray-900">{{ str_pad($patient->id, 8, '0', STR_PAD_LEFT) }}</p>
                            </div>

                            <!-- Address (full width) -->
                            <div class="col-span-2 info-group">
                                <label class="text-xs font-medium text-gray-500">Complete Address</label>
                                <p class="text-sm text-gray-900">{{ $patient->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons (hidden in print) -->
                <div class="flex justify-between items-center pt-3 border-t border-gray-200 no-print">
                    <button onclick="window.print()"
                            class="inline-flex items-center px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors text-sm">
                        <i class="fas fa-print mr-2"></i>
                        Print Slip
                    </button>
                    <div class="flex space-x-3">
                        <a href="{{ route('patient-registration') }}"
                           class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm">
                            <i class="fas fa-user-plus mr-2"></i>
                            Register Another
                        </a>
                        <a href="{{ url('/') }}"
                           class="inline-flex items-center px-3 py-1.5 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors text-sm">
                            <i class="fas fa-home mr-2"></i>
                            Home
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Note (hidden in print) -->
        <div class="text-center mt-4 text-sm text-gray-600 no-print">
            <p>Please keep this registration slip for your records.</p>
            <p>For any inquiries, please contact our support team.</p>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Print styles */
    @media print {
        @page {
            margin: 0.5cm;
            size: A4 portrait;
        }

        /* Hide topbar in print */
        .topbar {
            display: none !important;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .no-print {
            display: none !important;
        }

        .min-h-screen {
            min-height: 0 !important;
            padding-top: 0 !important; /* Remove top padding since topbar is hidden */
        }

        .py-8 {
            padding: 0 !important;
        }

        .bg-white {
            box-shadow: none !important;
            border: none !important;
        }

        .rounded-xl {
            border-radius: 0 !important;
        }

        .bg-gradient-to-r {
            background: #2563eb !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .text-white, .text-blue-100 {
            color: #fff !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* Ensure content fits on one page */
        .max-w-3xl {
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .grid {
            row-gap: 0.5rem !important;
        }

        .info-group {
            margin-bottom: 0.25rem !important;
        }

        .mb-4 {
            margin-bottom: 0.5rem !important;
        }

        .p-4 {
            padding: 0.75rem !important;
        }
    }

    /* Rest of the styles remain the same */
    .bg-grid-white {
        background-image: linear-gradient(to right, rgba(255,255,255,0.1) 1px, transparent 1px),
                         linear-gradient(to bottom, rgba(255,255,255,0.1) 1px, transparent 1px);
    }

    .info-group {
        @apply space-y-0.5;
    }
</style>
@endpush
@endsection
