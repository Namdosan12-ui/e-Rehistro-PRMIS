@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">{{ __('Patient Details') }}</div>
                <div class="card-body">
                    <!-- Basic Information Section -->
                    <div class="section">
                        <h5>{{ __('Basic Information') }}</h5>
                        <p><strong>{{ __('First Name') }}:</strong> {{ $patient->first_name }}</p>
                        <p><strong>{{ __('Last Name') }}:</strong> {{ $patient->last_name }}</p>
                        <p><strong>{{ __('Date of Birth') }}:</strong> {{ $patient->date_of_birth }}</p>
                        <p><strong>{{ __('Gender') }}:</strong> {{ $patient->gender }}</p>
                        <p><strong>{{ __('Contact Information') }}:</strong> {{ $patient->contact_information }}</p>
                        <p><strong>{{ __('Email Address') }}:</strong> {{ $patient->email_address }}</p>
                        <p><strong>{{ __('Address') }}:</strong> {{ $patient->address }}</p>
                        <p><strong>{{ __('Civil Status') }}:</strong> {{ $civilStatusOptions[$patient->civil_status] }}</p>
                        <p><strong>{{ __('Philhealth Number') }}:</strong> {{ $patient->philhealth_number ?? 'None' }}</p>
                        <p><strong>{{ __('PWD ID Number') }}:</strong> {{ $patient->pwd_id_number ?? 'None' }}</p>
                        <p><strong>{{ __('Occupation') }}:</strong> {{ $patient->occupation ?? 'None' }}</p>
                        <p><strong>{{ __('Senior Citizen Card Number') }}:</strong> {{ $patient->senior_citizen_card_number ?? 'None' }}</p>
                    </div>

                    <!-- Medical Information Section -->
                    <div class="section">
                        <h5>{{ __('Emergency Contact Information') }}</h5>
                        <p><strong>{{ __('Emergency Contact Name') }}:</strong> {{ $patient->emergency_contact_name }}</p>
                        <p><strong>{{ __('Emergency Contact Mobile') }}:</strong> {{ $patient->emergency_contact_mobile }}</p>
                    </div>

                    <!-- Vaccination Information Section -->
                    <div class="section">
                        <h5>{{ __('Vaccination Information') }}</h5>
                        <p><strong>{{ __('Vaccine Type') }}:</strong> {{ $patient->vaccine_type }}</p>
                        <p><strong>{{ __('First Dose Date') }}:</strong> {{ $patient->first_dose_date }}</p>
                        <p><strong>{{ __('Second Dose Date') }}:</strong> {{ $patient->second_dose_date }}</p>
                        <p><strong>{{ __('Booster Type') }}:</strong> {{ $patient->booster_type }}</p>
                        <p><strong>{{ __('First Booster Date') }}:</strong> {{ $patient->first_booster_date }}</p>
                        <p><strong>{{ __('Second Booster Date') }}:</strong> {{ $patient->second_booster_date }}</p>
                    </div>

                    <!-- Navigation -->
                    <a href="{{ route('patients.index') }}" class="btn btn-cancel">{{ __('Back') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
