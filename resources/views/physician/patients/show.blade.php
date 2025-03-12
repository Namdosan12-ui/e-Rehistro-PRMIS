@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="card">
    <!-- Main Card -->
    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <!-- Profile Header Card -->
<!-- Patient Profile Header Container -->
<div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-8 py-12 overflow-hidden">
    <!-- Background Grid Pattern -->
    <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>

    <!-- Decorative Circles -->
    <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
    <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>

    <!-- Content Container -->
    <div class="relative flex justify-between items-center">
        <!-- Patient Info Section -->
        <div class="flex items-center space-x-4">
            <!-- Profile Picture -->
            @if ($patient->profile_picture)
                <img src="{{ asset('storage/' . $patient->profile_picture) }}"
                     alt="Profile Picture"
                     class="w-16 h-16 rounded-full object-cover ring-4 ring-gray-50">
            @else
                <div class="w-16 h-16 rounded-full bg-gradient-to-r from-blue-500 to-indigo-500 flex items-center justify-center text-white text-2xl font-bold ring-4 ring-gray-50">
                    {{ strtoupper(substr($patient->first_name, 0, 1)) }}
                </div>
            @endif

            <!-- Patient Details -->
            <div>
                <!-- Patient Name -->
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ $patient->first_name }} {{ $patient->last_name }}
                </h1>

                <!-- Patient ID Badge -->
                <div class="flex items-center mt-1 space-x-10">
                    <span class="px-3 py-1 text-sm font-medium text-blue-600 bg-blue-50 rounded-full">
                        {{ __('Patient ID: ') }} {{ $patient->id }}
                    </span>
                </div>
            </div>
        </div>



        <!-- Back Button -->
        <a href="{{ route('physician.patients.index') }}"
           class="px-6 py-3 bg-blue-400/40 text-blue rounded-xl font-semibold hover:bg-blue-400/40 transition-all duration-200 flex items-center space-x-2">
            <i class="fas fa-arrow-left"></i>
            <span>Back</span>
        </a>
    </div>
</div>




    <!-- Content -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-3">
        <!-- Basic Information -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-2 bg-blue-100 rounded-lg">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-800">{{ __('Basic Information') }}</h2>
            </div>
            <ul class="space-y-3 text-gray-700">
                <li><strong>{{ __('First Name') }}:</strong> {{ $patient->first_name }}</li>
                <li><strong>{{ __('Last Name') }}:</strong> {{ $patient->last_name }}</li>
                <li><strong>{{ __('Date of Birth') }}:</strong> {{ $patient->date_of_birth }}</li>
                <li><strong>{{ __('Gender') }}:</strong> {{ $patient->gender }}</li>
                <li><strong>{{ __('Contact Information') }}:</strong> {{ $patient->contact_information }}</li>
                <li><strong>{{ __('Email Address') }}:</strong> {{ $patient->email_address }}</li>
                <li><strong>{{ __('Address') }}:</strong> {{ $patient->address }}</li>
                <li><strong>{{ __('Civil Status') }}:</strong> {{ $civilStatusOptions[$patient->civil_status] }}</li>
                <li><strong>{{ __('Philhealth Number') }}:</strong> {{ $patient->philhealth_number ?? 'None' }}</li>
                <li><strong>{{ __('PWD ID Number') }}:</strong> {{ $patient->pwd_id_number ?? 'None' }}</li>
                <li><strong>{{ __('Occupation') }}:</strong> {{ $patient->occupation ?? 'None' }}</li>
                <li><strong>{{ __('Senior Citizen Card Number') }}:</strong> {{ $patient->senior_citizen_card_number ?? 'None' }}</li>
            </ul>
        </div>

        <!-- Vital Signs -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-2 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-800">{{ __('Vital Signs') }}</h2>
            </div>
            <ul class="space-y-2 text-gray-700">
                <li><strong>{{ __('Weight') }}:</strong> {{ $patient->patient_weight ? $patient->patient_weight . ' kg' : 'Not recorded' }}</li>
                <li><strong>{{ __('Height') }}:</strong> {{ $patient->patient_height ? $patient->patient_height . ' m' : 'Not recorded' }}</li>
                <li><strong>{{ __('BMI') }}:</strong> {{ $patient->patient_bmi ?? 'Not recorded' }}</li>
                <li><strong>{{ __('Blood Pressure') }}:</strong> {{ $patient->patient_bp ?? 'Not recorded' }}</li>
                <li><strong>{{ __('Heart Rate') }}:</strong> {{ $patient->patient_heart_rate ? $patient->patient_heart_rate . ' bpm' : 'Not recorded' }}</li>
                <li><strong>{{ __('Temperature') }}:</strong> {{ $patient->patient_temperature ? $patient->patient_temperature . ' °C' : 'Not recorded' }}</li>
            </ul>
        </div>

        <!-- Emergency Contact -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-2 bg-red-100 rounded-lg">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-800">{{ __('Emergency Contact') }}</h2>
            </div>
            <ul class="space-y-3 text-gray-700">
                <li><strong>{{ __('Emergency Contact Name') }}:</strong> {{ $patient->emergency_contact_name }}</li>
                <li><strong>{{ __('Emergency Contact Mobile') }}:</strong> {{ $patient->emergency_contact_mobile }}</li>
            </ul>
        </div>

        <!-- Vaccination Information -->
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 hover:shadow-md transition-shadow duration-300">
            <div class="flex items-center space-x-3 mb-4">
                <div class="p-2 bg-indigo-100 rounded-lg">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-lg font-semibold text-gray-800">{{ __('Vaccination Information') }}</h2>
            </div>
            <ul class="space-y-3 text-gray-700">
                <li><strong>{{ __('Vaccine Type') }}:</strong> {{ $patient->vaccine_type }}</li>
                <li><strong>{{ __('First Dose Date') }}:</strong> {{ $patient->first_dose_date }}</li>
                <li><strong>{{ __('Second Dose Date') }}:</strong> {{ $patient->second_dose_date }}</li>
                <li><strong>{{ __('Booster Type') }}:</strong> {{ $patient->booster_type }}</li>
                <li><strong>{{ __('First Booster Date') }}:</strong> {{ $patient->first_booster_date }}</li>
                <li><strong>{{ __('Second Booster Date') }}:</strong> {{ $patient->second_booster_date }}</li>
            </ul>
        </div>
    </div>
</div>
</div>

@endsection
