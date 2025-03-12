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
</style>

<form method="POST" action="{{ route('admin.patients.store') }}">
    @csrf

    <div class="card">
        <div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-8 py-12 overflow-hidden">
            <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
            <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
            <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>
            <div class="relative flex justify-between items-center">
        <h1 class="all-header">
            <i class="fas fa-user-injured text-2xl text-green-600 bg-green-100 p-3 rounded-lg mr-4"></i>
            {{ __('Add Patient') }}
        </h1>

        <div class="flex space-x-4">
            <!-- Save Button -->
            <div class="flex justify-end space-x-4 mt-4">
                <button type="submit" class="px-6 py-3 bg-white text-blue-600 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-save"></i><span>Save</span>
                </button>

                <!-- Cancel Button -->
                <a href="{{ route('admin.patients.index') }}" class="bg-red-500 text-white px-6 py-3 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                    {{ __('Cancel') }}
                </a>
            </div>
        </div>
            </div>
    </div>

    <div class="all">
            <!-- Personal Information Section -->
            <div class="section-container mb-8 bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <h2 class="text-[30px] font-bold text-gray-800 mb-4 border-b pb-2">{{ __('Personal Information') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="first_name">{{ __('First Name') }}</label>
                        <input id="first_name" type="text" class="form-control1 @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus>
                        @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="last_name">{{ __('Last Name') }}</label>
                        <input id="last_name" type="text" class="form-control1 @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">
                        @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">{{ __('Date of Birth') }}</label>
                        <input id="date_of_birth" type="date" class="form-control1 @error('date_of_birth') is-invalid @enderror" name="date_of_birth" value="{{ old('date_of_birth') }}" required autocomplete="date_of_birth">
                        @error('date_of_birth')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="gender">{{ __('Gender') }}</label>
                        <select id="gender" class="form-control1 @error('gender') is-invalid @enderror" name="gender" required>
                            <option value="">{{ __('Select Gender') }}</option>
                            <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>{{ __('Male') }}</option>
                            <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>{{ __('Female') }}</option>
                        </select>
                        @error('gender')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="contact_information">{{ __('Contact Information') }}</label>
                        <input id="contact_information" type="text" class="form-control1 @error('contact_information') is-invalid @enderror" name="contact_information" value="{{ old('contact_information') }}" required autocomplete="contact_information">
                        @error('contact_information')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="patient_type_id">{{ __('Patient Type') }}</label>
                        <select id="patient_type_id" class="form-control1 @error('patient_type_id') is-invalid @enderror" name="patient_type_id" required>
                            <option value="">{{ __('Select Patient Type') }}</option>
                            @foreach($patientTypes as $patientType)
                                <option value="{{ $patientType['id'] }}" {{ old('patient_type_id') == $patientType['id'] ? 'selected' : '' }}>
                                    {{ $patientType['type_name'] }}
                                </option>
                            @endforeach
                        </select>
                        @error('patient_type_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email_address">{{ __('Email Address') }}</label>
                        <input id="email_address" type="email" class="form-control1 @error('email_address') is-invalid @enderror" name="email_address" value="{{ old('email_address') }}" required autocomplete="email_address">
                        @error('email_address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="address">{{ __('Address') }}</label>
                        <input id="address" type="text" class="form-control1 @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">
                        @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="civil_status">{{ __('Civil Status') }}</label>
                        <select id="civil_status" class="form-control1 @error('civil_status') is-invalid @enderror" name="civil_status" required autocomplete="civil_status">
                            <option value="">{{ __('Select Civil Status') }}</option>
                            <option value="single" {{ old('civil_status') == 'single' ? 'selected' : '' }}>{{ __('Single') }}</option>
                            <option value="married" {{ old('civil_status') == 'married' ? 'selected' : '' }}>{{ __('Married') }}</option>
                            <option value="separated" {{ old('civil_status') == 'separated' ? 'selected' : '' }}>{{ __('Separated') }}</option>
                            <option value="divorced" {{ old('civil_status') == 'divorced' ? 'selected' : '' }}>{{ __('Divorced') }}</option>
                            <option value="widowed" {{ old('civil_status') == 'widowed' ? 'selected' : '' }}>{{ __('Widowed') }}</option>
                        </select>
                        @error('civil_status')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="occupation">{{ __('Occupation') }}</label>
                        <input id="occupation" type="text" class="form-control1 @error('occupation') is-invalid @enderror" name="occupation" value="{{ old('occupation') }}" required autocomplete="occupation">
                        @error('occupation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
                <!-- Vital Signs Section -->
                <div class="section-container mb-8 bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h2 class="text-[30px] font-bold text-gray-800 mb-4 border-b pb-2">{{ __('Vital Signs') }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Weight -->
                        <div class="form-group">
                            <label for="patient_weight">{{ __('Weight (kg)') }}</label>
                            <input id="patient_weight" type="number" step="0.01"
                                class="form-control1 @error('patient_weight') is-invalid @enderror"
                                name="patient_weight"
                                value="{{ old('patient_weight') }}"
                                onchange="calculateBMI()">
                            @error('patient_weight')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Height -->
                        <div class="form-group">
                            <label for="patient_height">{{ __('Height (m)') }}</label>
                            <input id="patient_height" type="number" step="0.01"
                                class="form-control1 @error('patient_height') is-invalid @enderror"
                                name="patient_height"
                                value="{{ old('patient_height') }}"
                                onchange="calculateBMI()">
                            @error('patient_height')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- BMI -->
                        <div class="form-group">
                            <label for="patient_bmi">{{ __('BMI') }}</label>
                            <input id="patient_bmi" type="number" step="0.01"
                                class="form-control1 @error('patient_bmi') is-invalid @enderror"
                                name="patient_bmi"
                                value="{{ old('patient_bmi') }}"
                                readonly>
                            @error('patient_bmi')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Blood Pressure -->
                        <div class="form-group">
                            <label for="patient_bp">{{ __('Blood Pressure') }}</label>
                            <input id="patient_bp" type="text"
                                class="form-control1 @error('patient_bp') is-invalid @enderror"
                                name="patient_bp"
                                value="{{ old('patient_bp') }}"
                                placeholder="120/80"
                                pattern="\d{2,3}\/\d{2,3}"
                                title="Format: 120/80">
                            @error('patient_bp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Heart Rate -->
                        <div class="form-group">
                            <label for="patient_heart_rate">{{ __('Heart Rate (bpm)') }}</label>
                            <input id="patient_heart_rate" type="number"
                                class="form-control1 @error('patient_heart_rate') is-invalid @enderror"
                                name="patient_heart_rate"
                                value="{{ old('patient_heart_rate') }}">
                            @error('patient_heart_rate')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <!-- Temperature -->
                        <div class="form-group">
                            <label for="patient_temperature">{{ __('Temperature (°C)') }}</label>
                            <input id="patient_temperature" type="number" step="0.1"
                                class="form-control1 @error('patient_temperature') is-invalid @enderror"
                                name="patient_temperature"
                                value="{{ old('patient_temperature') }}">
                            @error('patient_temperature')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                </div>


            <!-- Emergency Contact Section -->
            <div class="section-container mb-8">
                <h2 class="text-[30px] font-bold text-gray-800 mb-4 border-b pb-2">{{ __('Emergency Contact') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="emergency_contact_name">{{ __('Emergency Contact Name') }}</label>
                        <input id="emergency_contact_name" type="text" class="form-control1 @error('emergency_contact_name') is-invalid @enderror" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" required autocomplete="emergency_contact_name">
                        @error('emergency_contact_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="emergency_contact_mobile">{{ __('Emergency Contact Mobile') }}</label>
                        <input id="emergency_contact_mobile" type="text" class="form-control1 @error('emergency_contact_mobile') is-invalid @enderror" name="emergency_contact_mobile" value="{{ old('emergency_contact_mobile') }}" required autocomplete="emergency_contact_mobile">
                        @error('emergency_contact_mobile')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="emergency_contact_relation">{{ __('Emergency Contact Relation') }}</label>
                        <input id="emergency_contact_relation" type="text" class="form-control1 @error('emergency_contact_relation') is-invalid @enderror" name="emergency_contact_relation" value="{{ old('emergency_contact_relation') }}" required autocomplete="emergency_contact_relation">
                        @error('emergency_contact_relation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Verification ID Section -->
            <div class="section-container mb-8 bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <h2 class="text-[30px] font-bold text-gray-800 mb-4 border-b pb-2">{{ __('Verification ID') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="philhealth_number">{{ __('Philhealth Number (Optional)') }}</label>
                        <input id="philhealth_number" type="text" class="form-control1 @error('philhealth_number') is-invalid @enderror" name="philhealth_number" value="{{ old('philhealth_number', 'NONE') }}" autocomplete="philhealth_number">
                        @error('philhealth_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="pwd_id_number">{{ __('PWD ID Number (Optional)') }}</label>
                        <input id="pwd_id_number" type="text" class="form-control1 @error('pwd_id_number') is-invalid @enderror" name="pwd_id_number" value="{{ old('pwd_id_number', 'NONE') }}" autocomplete="pwd_id_number">
                        @error('pwd_id_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="senior_citizen_card_number">{{ __('Senior Citizen Card Number (Optional)') }}</label>
                        <input id="senior_citizen_card_number" type="text" class="form-control1 @error('senior_citizen_card_number') is-invalid @enderror" name="senior_citizen_card_number" value="{{ old('senior_citizen_card_number', 'NONE') }}" autocomplete="senior_citizen_card_number">
                        @error('senior_citizen_card_number')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>


            <!-- Vaccination Section -->
            <div class="section-container mb-8">
                <h2 class="text-[30px] font-bold text-gray-800 mb-4 border-b pb-2">{{ __('Vaccination') }}</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="vaccine_type">{{ __('Vaccine Type') }}</label>
                        <select id="vaccine_type" class="form-control1 @error('vaccine_type') is-invalid @enderror" name="vaccine_type" required>
                            <option value="">{{ __('Select Vaccine Type') }}</option>
                            @foreach($vaccineTypes as $type)
                                <option value="{{ $type }}" {{ old('vaccine_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('vaccine_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="first_dose_date">{{ __('First Dose Date') }}</label>
                        <input id="first_dose_date" type="date" class="form-control1 @error('first_dose_date') is-invalid @enderror" name="first_dose_date" value="{{ old('first_dose_date') }}" required autocomplete="first_dose_date">
                        @error('first_dose_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="second_dose_date">{{ __('Second Dose Date') }}</label>
                        <input id="second_dose_date" type="date" class="form-control1 @error('second_dose_date') is-invalid @enderror" name="second_dose_date" value="{{ old('second_dose_date') }}" required autocomplete="second_dose_date">
                        @error('second_dose_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="booster_type">{{ __('Booster Type') }}</label>
                        <select id="booster_type" class="form-control1 @error('booster_type') is-invalid @enderror" name="booster_type" required>
                            <option value="">{{ __('Select Booster Type') }}</option>
                            @foreach($boosterTypes as $type)
                                <option value="{{ $type }}" {{ old('booster_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('booster_type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="first_booster_date">{{ __('First Booster Date') }}</label>
                        <input id="first_booster_date" type="date" class="form-control1 @error('first_booster_date') is-invalid @enderror" name="first_booster_date" value="{{ old('first_booster_date') }}" autocomplete="first_booster_date">
                        @error('first_booster_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="second_booster_date">{{ __('Second Booster Date') }}</label>
                        <input id="second_booster_date" type="date" class="form-control1 @error('second_booster_date') is-invalid @enderror" name="second_booster_date" value="{{ old('second_booster_date') }}" autocomplete="second_booster_date">
                        @error('second_booster_date')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
            </div>
    </div>
</div>
</form>
@endsection

<script>
    function calculateBMI() {
        const weight = document.getElementById('patient_weight').value;
        const height = document.getElementById('patient_height').value;

        if (weight && height) {
            const bmi = (weight / (height * height)).toFixed(2);
            document.getElementById('patient_bmi').value = bmi;
        }
    }
</script>
