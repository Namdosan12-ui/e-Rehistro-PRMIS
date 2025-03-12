@extends('layouts.app')

@section('content')
<head>
    <link href="https://fonts.googleapis.com/css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<style>
    .form-grid6 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
    }

    .form-group6 {
        margin-top: 30px;
        background-color: #ffffff;
        padding: 30px;
        border: 1px solid #dcdcdc;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
        margin-left: 20px;
        max-width: 500px;
        font-family: 'Arial', sans-serif;
        transition: all 0.3s ease;
    }

    .form-group6:hover {
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
    }

    .form-group6 h5 {
        font-size: 24px;
        color: #343a40;
        margin-bottom: 15px;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 8px;
        font-weight: bold;
    }

    .info-item {
        margin-bottom: 10px;
    }

    .info-label {
        font-weight: bold;
        color: #495057;
    }

    .info-value {
        color: #6c757d;
    }

    .status-badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: 500;
    }

    .status-normal {
        background-color: #28a745;
        color: white;
    }

    .status-abnormal {
        background-color: #dc3545;
        color: white;
    }
</style>

<div class="card">
    <!-- Header -->
    <div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-8 py-12 overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
        <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
        <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>
        <div class="relative flex justify-between items-center">
            <h1 class="all-header">
                <i class="fas fa-stethoscope text-2xl text-teal-600 bg-teal-100 p-3 rounded-lg mr-4"></i>
                {{ __('Consultation Details') }}
            </h1>
            <div class="flex space-x-4">
                <a href="{{ route('physician.consultations.index') }}" class="px-6 py-3 bg-blue-400/40 text-blue rounded-xl font-semibold hover:bg-blue-400/50 transition-all duration-200 flex items-center space-x-2">
                    <i class="fas fa-arrow-left"></i><span>{{ __('Back to List') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="all">
        <div class="form-grid6">
            <!-- Basic Information -->
            <div class="form-group6">
                <h5>Basic Information</h5>
                <div class="info-item">
                    <span class="info-label">Consultation ID:</span>
                    <span class="info-value">{{ $consultation->id }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Patient Name:</span>
                    <span class="info-value">
                        {{ $consultation->patient->first_name ?? 'N/A' }} {{ $consultation->patient->last_name ?? '' }}
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Date:</span>
                    <span class="info-value">{{ $consultation->date }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Symptoms:</span>
                    <span class="info-value">{{ $consultation->symptoms }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">History of Present Illness:</span>
                    <span class="info-value">{{ $consultation->history_of_present_illness ?? 'None' }}</span>
                </div>
            </div>

            <!-- Medical History -->
            <div class="form-group6">
                <h5>Medical History</h5>
                <div class="info-item">
                    <span class="info-label">HPN:</span>
                    <span class="info-value">{{ $consultation->has_hpn ? 'Yes' : 'No' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">DM:</span>
                    <span class="info-value">{{ $consultation->has_dm ? 'Yes' : 'No' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">BA:</span>
                    <span class="info-value">{{ $consultation->has_ba ? 'Yes' : 'No' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Other Medical History:</span>
                    <span class="info-value">{{ $consultation->other_medical_history ?? 'None' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Medications:</span>
                    <span class="info-value">{{ $consultation->medications ?? 'None' }}</span>
                </div>
            </div>

            <!-- Allergies and Surgeries -->
            <div class="form-group6">
                <h5>Allergies & Surgical History</h5>
                <div class="info-item">
                    <span class="info-label">Food/Drug Allergy:</span>
                    <span class="info-value">{{ $consultation->food_drug_allergy ?? 'None' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Surgery History:</span>
                    <span class="info-value">{{ $consultation->surgery_history ?? 'None' }}</span>
                </div>
            </div>

            <!-- Employment History -->
            <div class="form-group6">
                <h5>Employment History</h5>
                @if($consultation->employment_history)
                    @foreach(json_decode($consultation->employment_history, true) as $key => $values)
                        <div class="info-item">
                            <span class="info-label">{{ ucfirst($key) }}:</span>
                            <span class="info-value">{{ implode(', ', array_filter($values) ?: ['None']) }}</span>
                        </div>
                    @endforeach
                @endif
                <div class="info-item">
                    <span class="info-label">Work Related Injury:</span>
                    <span class="info-value">{{ $consultation->work_related_injury ?? 'None' }}</span>
                </div>
            </div>

            <!-- Personal Habits -->
            <div class="form-group6">
                <h5>Personal Habits</h5>
                <div class="info-item">
                    <span class="info-label">Smoking:</span>
                    <span class="info-value">
                        @if($consultation->is_smoker)
                            {{ $consultation->cigarette_sticks_per_day }} sticks/day for {{ $consultation->cigarette_years }} years
                        @else
                            Non-smoker
                        @endif
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">Alcohol Consumption:</span>
                    <span class="info-value">{{ $consultation->alcohol_history ?? 'None' }}</span>
                </div>
            </div>

            <!-- Physical Examination -->
            <div class="form-group6">
                <h5>Physical Examination</h5>
                <div class="info-item">
                    <span class="info-label">Weight:</span>
                    <span class="info-value">{{ $consultation->weight ?? 'N/A' }} kg</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Height:</span>
                    <span class="info-value">{{ $consultation->height ?? 'N/A' }} m</span>
                </div>
                <div class="info-item">
                    <span class="info-label">BMI:</span>
                    <span class="info-value">{{ $consultation->bmi ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Blood Pressure:</span>
                    <span class="info-value">{{ $consultation->bp ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Heart Rate:</span>
                    <span class="info-value">{{ $consultation->hr ?? 'N/A' }} bpm</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Temperature:</span>
                    <span class="info-value">{{ $consultation->temp ?? 'N/A' }} °C</span>
                </div>
            </div>

            <!-- Physical Findings -->
            <div class="form-group6">
                <h5>Physical Findings</h5>
                @php
                    $findings = [
                        'HEENT' => ['status' => $consultation->heent_status, 'notes' => $consultation->heent],
                        'Neck' => ['status' => $consultation->neck_status, 'notes' => $consultation->neck],
                        'Chest and Lungs' => ['status' => $consultation->chest_and_lungs_status, 'notes' => $consultation->chest_and_lungs],
                        'Heart' => ['status' => $consultation->heart_status, 'notes' => $consultation->heart],
                        'Abdomen' => ['status' => $consultation->abdomen_status, 'notes' => $consultation->abdomen],
                        'Extremities' => ['status' => $consultation->extremities_status, 'notes' => $consultation->extremities],
                    ];
                @endphp

                @foreach($findings as $area => $data)
                    <div class="info-item">
                        <span class="info-label">{{ $area }}:</span>
                        <span class="status-badge {{ $data['status'] === 'normal' ? 'status-normal' : 'status-abnormal' }}">
                            {{ ucfirst($data['status']) }}
                        </span>
                        @if($data['notes'])
                            <div class="info-value mt-1">Notes: {{ $data['notes'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Review of Systems -->
            <div class="form-group6">
                <h5>Review of Systems</h5>
                @if($consultation->ros)
                    @foreach(json_decode($consultation->ros, true) as $system => $status)
                        <div class="info-item">
                            <span class="info-label">{{ ucfirst($system) }}:</span>
                            <span class="info-value">{{ $status }}</span>
                        </div>
                    @endforeach
                @else
                    <div class="info-item">
                        <span class="info-value">No review of systems recorded</span>
                    </div>
                @endif
            </div>

            <!-- Transaction Details -->
            @if($consultation->transaction)
            <div class="form-group6">
                <h5>Transaction Details</h5>
                <div class="info-item">
                    <span class="info-label">Transaction ID:</span>
                    <span class="info-value">{{ $consultation->transaction->id }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Payment Status:</span>
                    <span class="info-value">{{ $consultation->transaction->payment_status }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Total Payment:</span>
                    <span class="info-value">{{ $consultation->transaction->total_payments }}</span>
                </div>
            </div>
            @endif

            <!-- Diagnosis and Treatment Plan -->
            <div class="form-group6">
                <h5>Diagnosis & Treatment</h5>
                <div class="info-item">
                    <span class="info-label">Diagnosis:</span>
                    <span class="info-value">{{ $consultation->diagnoses ?? 'None documented' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Treatment Plan:</span>
                    <span class="info-value">{{ $consultation->treatment_plan ?? 'None documented' }}</span>
                </div>
            </div>

            <!-- Prescription Details -->
            <div class="form-group6">
                <h5>Prescription Details</h5>
                <div class="info-item">
                    <span class="info-label">Physician:</span>
                    <span class="info-value">{{ $consultation->physician_name ?? Auth::user()->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">License No.:</span>
                    <span class="info-value">{{ $consultation->license_no ?? Auth::user()->license_no }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Prescription:</span>
                    <div class="info-value" style="white-space: pre-line; font-family: 'Courier New', monospace; margin-top: 10px; padding: 15px; border: 1px solid #ddd; border-radius: 4px;">
                        {{ $consultation->prescription ?? 'No prescription provided' }}
                    </div>
                </div>
                <!-- Print Button -->
                <div class="text-right mt-4">
                    <button type="button" onclick="printPrescription()"
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors">
                        <i class="fas fa-print mr-2"></i>Print Prescription
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script>
    function printPrescription() {
        const prescription = "{{ $consultation->prescription }}";
        const physicianName = "{{ $consultation->physician_name ?? Auth::user()->name }}";
        const licenseNo = "{{ $consultation->license_no ?? Auth::user()->license_no }}";
        const patientName = "{{ $consultation->patient->first_name ?? 'N/A' }} {{ $consultation->patient->last_name ?? '' }}";
        const today = new Date().toLocaleDateString();

        const printWindow = window.open('', '', 'width=800,height=600');
        printWindow.document.write(`
            <html>
            <head>
                <title>Medical Prescription</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                        max-width: 800px;
                        margin: 0 auto;
                    }
                    .header {
                        text-align: center;
                        margin-bottom: 30px;
                        border-bottom: 2px solid #333;
                        padding-bottom: 10px;
                    }
                    .patient-info {
                        margin-bottom: 20px;
                    }
                    .prescription-content {
                        font-family: 'Courier New', monospace;
                        white-space: pre-line;
                        margin: 20px 0;
                        padding: 20px;
                        border: 1px solid #ccc;
                        min-height: 200px;
                    }
                    .footer {
                        margin-top: 50px;
                        text-align: right;
                    }
                    .signature-line {
                        border-top: 1px solid #000;
                        width: 200px;
                        margin-left: auto;
                        margin-bottom: 10px;
                    }
                </style>
            </head>
            <body>
                <div class="header">
                    <h2>Medical Prescription</h2>
                </div>
                <div class="patient-info">
                    <p><strong>Date:</strong> ${today}</p>
                    <p><strong>Patient Name:</strong> ${patientName}</p>
                </div>
                <div class="prescription-content">
                    ${prescription}
                </div>
                <div class="footer">
                    <div class="signature-line"></div>
                    <p><strong>${physicianName}</strong></p>
                    <p>License No.: ${licenseNo}</p>
                </div>
            </body>
            </html>
        `);
        printWindow.document.close();

        setTimeout(() => {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }, 250);
    }
    </script>
