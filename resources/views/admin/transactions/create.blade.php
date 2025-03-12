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

<form action="{{ route('admin.transactions.store') }}" method="POST">
    @csrf

    <div class="card">
    <div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-8 py-12 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
        <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
        <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>
        <div class="relative flex justify-between items-center">
            <h1 class="all-header">
        <i class="fas fa-vials text-2xl text-orange-600 bg-orange-100 p-3 rounded-lg mr-4"></i>
        {{ __('Create New Transaction') }}
         </h1>

         @if ($errors->any())
         <div class="alert alert-danger">
             <ul>
                 @foreach ($errors->all() as $error)
                     <li>{{ $error }}</li>
                 @endforeach
             </ul>
         </div>
        @endif

        <div class="flex space-x-4">
            <!-- Save Button -->
            <div class="flex justify-end space-x-4 mt-4">
            <button type="submit" class="px-6 py-3 bg-white text-blue-600 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                <i class="fas fa-save"></i><span>Create Transaction</span>
                </button>
        <a href="{{ route('admin.transactions.index') }}"
        class="px-6 py-3 bg-blue-400/40 text-blue rounded-xl font-semibold hover:bg-blue-400/40 transition-all duration-200 flex items-center space-x-2">
            <i class="fas fa-times"></i>
            <span>Cancel</span>
        </a>
            </div>
        </div>
        </div>
    </div>

<div class="all">
    <div class="section-container mb-8 bg-gray-50 rounded-2xl p-6 border border-gray-100">
        <h2 class="text-[30px] font-bold text-gray-800 mb-4 border-b pb-2">{{ __('Patient Transaction Details') }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div class="form-group">
                <label for="patient_id" class="form-label">Patient</label>
                <select name="patient_id" id="patient_id" class="form-control1" required>
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}">{{ $patient->first_name }} {{ $patient->last_name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="physician" class="form-label">Physician (Optional)</label>
                <input type="text" name="physician" id="physician" class="form-control1" placeholder="Enter Physician Name (Optional)">
            </div>

            <div class="form-group">
                <label for="radiologic_technologist" class="form-label">Radiologic Technologist (Optional)</label>
                <input type="text" name="radiologic_technologist" id="radiologic_technologist" class="form-control1" placeholder="Enter Radiologic Technologist Name (Optional)">
            </div>

            <div class="form-group">
                <label for="date" class="form-label">Date</label>
                <input type="date" name="date" id="date" class="form-control1" required>
            </div>

            <div class="form-group">
                <label for="last_meal" class="form-label">Last Meal</label>
                <input type="datetime-local" class="form-control1" id="last_meal" name="last_meal" value="{{ old('last_meal') }}" required>
            </div>

            <div class="form-group">
                <label for="total_payments" class="form-label">Total Payments</label>
                <input type="number" step="0.01" name="total_payments" id="total_payments" class="form-control1" readonly>
            </div>

                       <!-- Discount Selection -->
<div class="form-group">
    <label for="discount_type" class="form-label">Discount Type</label>
    <select name="discount_type" id="discount_type" class="form-control1">
        <option value="">Select Discount Type</option>
        <option value="Senior Citizen">Senior Citizen (20%)</option>
        <option value="PWD">PWD (20%)</option>
        <option value="Employee">Student (10%)</option>
        <option value="Manual">Manual Discount</option>
        <option value="None">None</option>
    </select>
</div>

        <!-- Manual Discount Entry (Initially Hidden) -->
        <div id="manualDiscountSection" class="form-group" style="display: none;">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="manual_discount_name" class="form-label">Discount Name</label>
                    <input type="text" name="manual_discount_name" id="manual_discount_name" class="form-control1" placeholder="Enter Discount Name">
                </div>
                <div>
                    <label for="manual_discount_percentage" class="form-label">Discount Percentage</label>
                    <input type="number" name="manual_discount_percentage" id="manual_discount_percentage" class="form-control1" min="0" max="100" step="0.1" placeholder="Enter Discount Percentage">
                </div>
            </div>
            <div class="form-group mt-2">
                <label for="manual_discount_remarks" class="form-label">Remarks</label>
                <textarea name="manual_discount_remarks" id="manual_discount_remarks" class="form-control1" rows="2" placeholder="Enter discount remarks (optional)"></textarea>
            </div>
        </div>
        </div>
    </div>

    <div class="section-container mb-8 bg-gray-50 rounded-2xl p-6 border border-gray-100">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @foreach($categories as $category)
                <div class="form-group">
                    <div class="mb-3">
                        <h3>{{ $category->name }}</h3>
                        <div id="category{{ $category->id }}">
                            @foreach($category->services as $service)
                                <div class="form-check">
                                        <input class="form-check-input w-6 h-6 border-2 border-black rounded-md focus:ring-2 focus:ring-blue-500" type="checkbox" name="laboratory_services[]" value="{{ $service->id }}" data-fee="{{ $service->fee }}" id="service{{ $service->id }}">
                                        <label class="form-check-label" for="service{{ $service->id }}">
                                            {{ $service->service_name }} - ₱{{ number_format($service->fee, 2) }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

            <!-- Drug Test Consent Form -->
            <div class="section-container mb-8 bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <div class="form-group">
                    <h3>Consent Form for Drug Testing</h3>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <div class="form-group">
                    <label for="drug_test_purpose" class="form-label">Purpose of Drug Test</label>
                    <select name="drug_test_purpose" id="drug_test_purpose" class="form-control1">
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
                    <input type="text" name="other_purpose_specify" class="form-control1" placeholder="Specify other purpose">
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="medication_past_30_days">Have you taken any medication/drugs in the past 30 days?</label>
                    <select name="medication_past_30_days" id="medication_past_30_days" class="form-control1">
                        <option value="">Select</option>
                        <option value="accepted">Yes</option>
                        <option value="none">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-check-label" for="alcohol_past_24_hours">Have you ingested any alcoholic beverages in the past 24 hours?</label>
                    <select name="alcohol_past_24_hours" id="alcohol_past_24_hours" class="form-control1">
                        <option value="">Select</option>
                        <option value="accepted">Yes</option>
                        <option value="none">No</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="sample_type" class="form-label">I hereby consent and agree to give a sample of my</label>
                    <select name="sample_type" id="sample_type" class="form-control1">
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
                    <input class="form-check-input w-6 h-6 border-2 border-black rounded-md focus:ring-2 focus:ring-blue-500" type="checkbox" name="confirmatory_testing_agreement" id="confirmatory_testing_agreement" value="accepted">
                    <label class="form-check-label" for="confirmatory_testing_agreement">I hereby consent and agree that if my specimen is found positive, it will be sent to a duly accredited/licensed Confirmatory Laboratory for confirmatory testing.</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input w-6 h-6 border-2 border-black rounded-md focus:ring-2 focus:ring-blue-500" type="checkbox" name="sample_acknowledgement" id="sample_acknowledgement" value="accepted">
                    <label class="form-check-label" for="sample_acknowledgement">I hereby acknowledge that the sample is my own and that the samples were sealed in my presence.</label>
                </div>
            </div>
            </div>
    </div>
    </div>
</form>

<script>
    function updateTotalPayments() {
        let totalPayments = 0;
        document.querySelectorAll('input[name="laboratory_services[]"]:checked').forEach(function(service) {
            totalPayments += parseFloat(service.getAttribute('data-fee'));
        });

        const discountType = document.getElementById('discount_type').value;
        const manualDiscountPercentage = document.getElementById('manual_discount_percentage');

        if (discountType === 'Senior Citizen' || discountType === 'PWD') {
            totalPayments *= 0.80; // Apply 20% discount
        } else if (discountType === 'Employee') {
            totalPayments *= 0.90; // Apply 10% discount
        } else if (discountType === 'Manual' && manualDiscountPercentage && manualDiscountPercentage.value) {
            // Apply manual discount percentage
            const percentage = parseFloat(manualDiscountPercentage.value);
            if (!isNaN(percentage)) {
                totalPayments *= (1 - (percentage / 100));
            }
        }

        document.getElementById('total_payments').value = totalPayments.toFixed(2);
    }

    // Event listeners for services
    document.querySelectorAll('input[name="laboratory_services[]"]').forEach(function(service) {
        service.addEventListener('change', updateTotalPayments);
    });

    // Event listeners for discount type
    document.getElementById('discount_type').addEventListener('change', function() {
        const manualDiscountSection = document.getElementById('manualDiscountSection');

        if (this.value === 'Manual') {
            manualDiscountSection.style.display = 'block';
        } else {
            manualDiscountSection.style.display = 'none';
        }

        updateTotalPayments();
    });

    // Event listener for manual discount percentage
    const manualDiscountPercentage = document.getElementById('manual_discount_percentage');
    if (manualDiscountPercentage) {
        manualDiscountPercentage.addEventListener('input', updateTotalPayments);
    }

    // Initial calculation
    updateTotalPayments();
</script>
@endsection
