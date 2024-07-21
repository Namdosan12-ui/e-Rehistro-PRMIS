@extends('layouts.app')

@section('content')

<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="header-background1">
    <h2 class="all-header1">
        <i class="fas fa-user"></i>
        {{ __('Create New Transaction') }}
    </h2>
</div>

<div class="all-container1">
    <div class="card-body1">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="patient_id" class="form-label">Patient</label>
                <select name="patient_id" id="patient_id" class="form-select" required>
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="physician" class="form-label">Physician (Optional)</label>
                <input type="text" name="physician" id="physician" class="form-control" placeholder="Enter Physician Name (Optional)">
            </div>

            <div class="form-group">
                <label for="radiologic_technologist" class="form-label">Radiologic Technologist (Optional)</label>
                <input type="text" name="radiologic_technologist" id="radiologic_technologist" class="form-control" placeholder="Enter Radiologic Technologist Name (Optional)">
            </div>

 

            <div class="form-group">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label for="last_meal" class="form-label">Last Meal</label>
                <input type="datetime-local" class="form-control" id="last_meal" name="last_meal" value="{{ old('last_meal') }}" required>
            </div>

            <div class="form-group">
                <label for="total_payments" class="form-label">Total Payments</label>
                <input type="number" step="0.01" name="total_payments" id="total_payments" class="form-control" readonly>
            </div>

            <div class="form-group">
            <div id="servicesContainer">
                @foreach($categories as $category)
                    <div class="mb-3">
                        <h3>{{ $category->name }}</h3>
                        <div id="category{{ $category->id }}">
                            @foreach($category->services as $service)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="laboratory_services[]" value="{{ $service->id }}" data-fee="{{ $service->fee }}" id="service{{ $service->id }}">
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
           <!-- Drug Test Consent Form -->
           <div class="form-group">
            <h3>Consent Form for Drug Testing</h3>

            <div class="form-group">
                <label for="drug_test_purpose" class="form-label">Purpose of Drug Test</label>
                <select name="drug_test_purpose" id="drug_test_purpose" class="form-select">
                    <option value="">Select Purpose</option>
                    <option value="Employment">Employment (Private/Government)</option>
                    <option value="Driver's License">Driver's License</option>
                    <option value="Student">Student (Secondary School/Tertiary School)</option>
                    <option value="Firearms License">Firearms License</option>
                    <option value="Candidate for Public Office">Candidate for Public Office (Appointee or Elected)</option>
                    <option value="Persons Apprehended or Arrested">Persons Apprehended or Arrested for Violating the Law</option>
                    <option value="Persons Charged with Criminal Offenses">Persons Charged with Criminal Offenses (Imprisonment of not less than 6 years and 1 day)</option>
                    <option value="Others">Others (please specify)</option>
                </select>
                <input type="text" name="other_purpose_specify" class="form-control mt-2" placeholder="Specify other purpose">
            </div>

            <div class="form-group">
                <label class="form-check-label" for="medication_past_30_days">Have you taken any medication/drugs in the past 30 days?</label>
                <select name="medication_past_30_days" id="medication_past_30_days" class="form-select">
                    <option value="">Select</option>
                    <option value="accepted">Yes</option>
                    <option value="none">No</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-check-label" for="alcohol_past_24_hours">Have you ingested any alcoholic beverages in the past 24 hours?</label>
                <select name="alcohol_past_24_hours" id="alcohol_past_24_hours" class="form-select">
                    <option value="">Select</option>
                    <option value="accepted">Yes</option>
                    <option value="none">No</option>
                </select>
            </div>

            <div class="form-group">
                <label for="sample_type" class="form-label">I hereby consent and agree to give a sample of my</label>
                <select name="sample_type" id="sample_type" class="form-select">
                    <option value="">Select Sample Type</option>
                    <option value="Urine">Urine</option>
                    <option value="Blood">Blood</option>
                    <option value="Saliva">Saliva</option>
                    <option value="Hair">Hair</option>
                    <option value="Sweat">Sweat</option>
                    <option value="Tissues">Tissues</option>
                </select>
            </div>
            

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="confirmatory_testing_agreement" id="confirmatory_testing_agreement" value="accepted">
                <label class="form-check-label" for="confirmatory_testing_agreement">I hereby consent and agree that if my specimen is found positive, it will be sent to a duly accredited/licensed Confirmatory Laboratory for confirmatory testing.</label>
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="sample_acknowledgement" id="sample_acknowledgement" value="accepted">
                <label class="form-check-label" for="sample_acknowledgement">I hereby acknowledge that the sample is my own and that the samples were sealed in my presence.</label>
            </div>
        </div>

        <div class="form-group mt-4">
            <button type="submit" class="btn btn-primary">Create Transaction</button>
            <a href="{{ route('transactions.index') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
        </div>
    </form>
</div>
</div>


<script>
    // Update total payments based on selected services
    function updateTotalPayments() {
        let totalPayments = 0;
        document.querySelectorAll('input[name="laboratory_services[]"]:checked').forEach(function(service) {
            totalPayments += parseFloat(service.getAttribute('data-fee'));
        });
        document.getElementById('total_payments').value = totalPayments.toFixed(2);
    }

    // Event listener for service checkboxes
    document.addEventListener('change', function(e) {
        if (e.target && e.target.matches('input[name="laboratory_services[]"]')) {
            updateTotalPayments();
        }
    });

    // Trigger update on page load
    updateTotalPayments();
</script>
@endsection
