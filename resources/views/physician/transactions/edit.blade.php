@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<div class="card">
    <h2 class="all-header">
        <i class="fas fa-user"></i>
        {{ __('Edit Transaction') }}
    </h2>

<div class="card-body">
    <div class="table-container">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('physician.transactions.update', $transaction->id) }}" method="POST">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="patient_id" class="form-label">Patient</label>
                <select name="patient_id" id="patient_id" class="form-select" required>
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}" {{ $transaction->patient_id == $patient->id ? 'selected' : '' }}>{{ $patient->first_name }} {{ $patient->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="physician" class="form-label">Physician (Optional)</label>
                <input type="text" name="physician" id="physician" class="form-control" value="{{ old('physician', $transaction->physician) }}" placeholder="Enter Physician Name (Optional)">
            </div>

            <div class="form-group">
                <label for="radiologic_technologist" class="form-label">Radiologic Technologist (Optional)</label>
                <input type="text" name="radiologic_technologist" id="radiologic_technologist" class="form-control" value="{{ old('radiologic_technologist', $transaction->radiologic_technologist) }}" placeholder="Enter Radiologic Technologist Name (Optional)">
            </div>
            <div class="form-group">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control"
                       value="{{ old('date', $transaction->date ? \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') : '') }}"
                       required>
            </div>

            <div class="form-group">
                <label for="last_meal" class="form-label">Last Meal</label>
                <input type="datetime-local" class="form-control" id="last_meal" name="last_meal" value="{{ old('last_meal', $transaction->last_meal) }}" required>
            </div>

            <div class="form-group">
                <label for="total_payments" class="form-label">Total Payments</label>
                <input type="number" step="0.01" name="total_payments" id="total_payments" class="form-control" value="{{ old('total_payments', $transaction->total_payments) }}" readonly>
            </div>

            <div class="form-group">
                <div id="servicesContainer">
                    @foreach($categories as $category)
                        <div class="mb-3">
                            <h3>{{ $category->name }}</h3>
                            <div id="category{{ $category->id }}">
                                @foreach($category->services as $service)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="laboratory_services[]" value="{{ $service->id }}" {{ $transaction->services->contains($service->id) ? 'checked' : '' }} data-fee="{{ $service->fee }}" id="service{{ $service->id }}">
                                        <label class="form-check-label" for="service{{ $service->id }}">
                                            {{ $service->service_name }} - ${{ number_format($service->fee, 2) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- Discount Selection -->
            <div class="form-group">
                <label for="discount_type" class="form-label">Discount Type</label>
                <select name="discount_type" id="discount_type" class="form-select">
                    <option value="">Select Discount Type</option>
                    <option value="Senior Citizen">Senior Citizen (20%)</option>
                    <option value="PWD">PWD (20%)</option>
                    <option value="Employee">Student (10%)</option>
                    <option value="None">None</option>
                </select>
            </div>



            <!-- Drug Test Consent Form -->
            <div class="form-group">
                <h3>Consent Form for Drug Testing</h3>

                <div class="form-group">
                    <label for="drug_test_purpose" class="form-label">Purpose of Drug Test</label>
                    <select name="drug_test_purpose" id="drug_test_purpose" class="form-select">
                        <option value="">Select Purpose</option>
                        @foreach (['Employment', 'Driver\'s License', 'Student', 'Firearms License', 'Candidate for Public Office', 'Persons Apprehended or Arrested', 'Persons Charged with Criminal Offenses', 'Others'] as $option)
                            <option value="{{ $option }}" {{ $transaction->drug_test_purpose == $option ? 'selected' : '' }}>{{ $option }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="other_purpose_specify" class="form-control mt-2" value="{{ old('other_purpose_specify', $transaction->other_purpose_specify) }}" placeholder="Specify other purpose">
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="medication_past_30_days">Have you taken any medication/drugs in the past 30 days?</label>
                    <select name="medication_past_30_days" id="medication_past_30_days" class="form-select">
                        <option value="">Select</option>
                        <option value="accepted" {{ $transaction->medication_past_30_days == 'accepted' ? 'selected' : '' }}>Yes</option>
                        <option value="none" {{ $transaction->medication_past_30_days == 'none' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="alcohol_past_24_hours">Have you ingested any alcoholic beverages in the past 24 hours?</label>
                    <select name="alcohol_past_24_hours" id="alcohol_past_24_hours" class="form-select">
                        <option value="">Select</option>
                        <option value="accepted" {{ $transaction->alcohol_past_24_hours == 'accepted' ? 'selected' : '' }}>Yes</option>
                        <option value="none" {{ $transaction->alcohol_past_24_hours == 'none' ? 'selected' : '' }}>No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sample_type" class="form-label">I hereby consent and agree to give a sample of my</label>
                    <select name="sample_type" id="sample_type" class="form-select">
                        <option value="">Select Sample Type</option>
                        @foreach (['Urine', 'Blood', 'Saliva', 'Hair', 'Sweat', 'Tissues'] as $type)
                            <option value="{{ $type }}" {{ $transaction->sample_type == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="confirmatory_testing_agreement" id="confirmatory_testing_agreement" value="accepted" {{ $transaction->confirmatory_testing_agreement == 'accepted' ? 'checked' : '' }}>
                    <label class="form-check-label" for="confirmatory_testing_agreement">I hereby consent and agree that if my specimen is found positive, it will be sent to a duly accredited/licensed Confirmatory Laboratory for confirmatory testing.</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="sample_acknowledgement" id="sample_acknowledgement" value="accepted" {{ $transaction->sample_acknowledgement == 'accepted' ? 'checked' : '' }}>
                    <label class="form-check-label" for="sample_acknowledgement">I hereby acknowledge that the sample is my own and that the samples were sealed in my presence.</label>
                </div>
            </div>

    </div>
        <button type="submit" class="btn btn-success4">Update Transaction</button>
        <a href="{{ route('physician.transactions.index') }}" class="btn btn-cancel4">{{ __('Cancel') }}</a>
    </form>
    </div>

<script>
    function updateTotalPayments() {
        let totalPayments = 0;
        document.querySelectorAll('input[name="laboratory_services[]"]:checked').forEach(function(service) {
            totalPayments += parseFloat(service.getAttribute('data-fee'));
        });

        const discountType = document.getElementById('discount_type').value;
        if (discountType === 'Senior Citizen' || discountType === 'PWD') {
            totalPayments *= 0.80; // Apply 20% discount
        } else if (discountType === 'Employee') {
            totalPayments *= 0.90; // Apply 10% discount
        }

        document.getElementById('total_payments').value = totalPayments.toFixed(2);
    }

    document.querySelectorAll('input[name="laboratory_services[]"]').forEach(function(service) {
        service.addEventListener('change', updateTotalPayments);
    });

    document.getElementById('discount_type').addEventListener('change', updateTotalPayments);
</script>
@endsection
