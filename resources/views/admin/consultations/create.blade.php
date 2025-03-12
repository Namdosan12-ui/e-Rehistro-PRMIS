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
    .form-group {
        margin-bottom: 1rem;
    }
    .form-label {
        margin-bottom: 0.5rem;
    }
    .form-control1 {
        width: 100%;
        padding: 0.375rem 0.75rem;
        border: 1px solid #ddd;
        border-radius: 0.25rem;
    }
    .table-bordered {
        border: 1px solid #dee2e6;
    }
    .medical-form {
        padding: 20px;
        background: white;
        border-radius: 8px;
    }
    .medical-form label {
        font-weight: 500;
    }
    .checkbox-group {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    .history-form {
        margin-bottom: 20px;
    }
    .ros-table td {
        padding: 5px;
        vertical-align: top;
    }
    .patient-info-box {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .patient-info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-top: 10px;
    }
    .info-item {
        background: white;
        padding: 8px 12px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
    }
    .info-label {
        font-size: 0.875rem;
        color: #64748b;
        margin-bottom: 4px;
    }
    .info-value {
        font-weight: 500;
        color: #1e293b;
    }
</style>

<form action="{{ route('admin.consultations.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-8 py-12 overflow-hidden">
            <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
            <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
            <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>
            <div class="relative flex justify-between items-center">
                <h1 class="all-header">
                    <i class="fas fa-stethoscope text-2xl text-teal-600 bg-teal-100 p-3 rounded-lg mr-4"></i>
                    {{ __('Create Consultation') }}
                </h1>
                <div class="flex space-x-4">
                    <div class="flex justify-end space-x-4 mt-4">
                        <button type="submit" class="px-6 py-3 bg-white text-blue-600 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                            <i class="fas fa-save"></i><span>Save</span>
                        </button>
                        <a href="{{ route('admin.consultations.index') }}" class="px-6 py-3 bg-blue-400/40 text-blue rounded-xl font-semibold hover:bg-blue-400/40 transition-all duration-200 flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i><span>Back</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="all">
            <div class="section-container mb-8 bg-gray-50 rounded-2xl p-6 border border-gray-100">
            <!-- Patient Selection -->
            <div class="form-group mb-6">
                <label for="patient_id" class="form-label">Patient</label>
                <select name="patient_id" id="patient_id" class="form-control1" required>
                    <option value="">Select Patient</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}"
                            data-dob="{{ $patient->date_of_birth }}"
                            data-gender="{{ $patient->gender }}"
                            data-address="{{ $patient->address }}"
                            data-civil-status="{{ $patient->civil_status }}"
                            data-contact="{{ $patient->contact_information }}"
                            data-email="{{ $patient->email_address }}"
                            data-vaccine-type="{{ $patient->vaccine_type }}"
                            data-booster-type="{{ $patient->booster_type }}"
                            data-first-dose="{{ $patient->first_dose_date }}"
                            data-second-dose="{{ $patient->second_dose_date }}"
                            data-first-booster="{{ $patient->first_booster_date }}"
                            data-second-booster="{{ $patient->second_booster_date }}">
                            {{ $patient->first_name }} {{ $patient->last_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Patient Information Box -->
            <div class="patient-info-box" id="patientInfo" style="display: none;">
                <h3 class="text-lg font-semibold mb-2">Patient Information</h3>
                <div class="grid grid-cols-3 gap-4">
                    <div class="info-item bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-600">Age</div>
                        <div class="font-medium" id="patientAge">-</div>
                    </div>
                    <div class="info-item bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-600">Gender</div>
                        <div class="font-medium" id="patientGender">-</div>
                    </div>
                    <div class="info-item bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-600">Date of Birth</div>
                        <div class="font-medium" id="patientDOB">-</div>
                    </div>
                    <div class="info-item bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-600">Civil Status</div>
                        <div class="font-medium" id="patientCivilStatus">-</div>
                    </div>
                    <div class="info-item bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-600">Contact</div>
                        <div class="font-medium" id="patientContact">-</div>
                    </div>
                    <div class="info-item bg-white p-3 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-600">Email</div>
                        <div class="font-medium" id="patientEmail">-</div>
                    </div>
                    <div class="info-item bg-white p-3 rounded-lg shadow-sm col-span-3">
                        <div class="text-sm text-gray-600">Address</div>
                        <div class="font-medium" id="patientAddress">-</div>
                    </div>
                    <!-- New Vaccination Information Section -->
                    <div class="info-item bg-white p-3 rounded-lg shadow-sm col-span-3">
                        <div class="text-sm text-gray-600">Vaccination Information</div>
                        <div class="grid grid-cols-2 gap-4 mt-2">
                            <div>
                                <p class="text-sm text-gray-500">COVID-19 Vaccine Type:</p>
                                <p class="font-medium" id="patientVaccineType">-</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">Booster Type:</p>
                                <p class="font-medium" id="patientBoosterType">-</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">1st Dose Date:</p>
                                <p class="font-medium" id="patientFirstDose">-</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">2nd Dose Date:</p>
                                <p class="font-medium" id="patientSecondDose">-</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">1st Booster Date:</p>
                                <p class="font-medium" id="patientFirstBooster">-</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500">2nd Booster Date:</p>
                                <p class="font-medium" id="patientSecondBooster">-</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div class="medical-form">
                    <!-- Chief Complaint & Marital Status -->
                    <div class="form-group">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label>CHIEF COMPLAINT:</label>
                                <input type="text" name="symptoms" class="form-control1">
                            </div>
                        </div>
                    </div>

                    <!-- History of Present Illness -->
                    <div class="form-group">
                        <label>HISTORY OF PRESENT ILLNESS:</label>
                        <textarea name="history_of_present_illness" class="form-control1" rows="2"></textarea>
                    </div>

                    <!-- Past Medical History -->
                    <div class="form-group history-form">
                        <label>PAST MEDICAL HISTORY:</label>
                        <div class="checkbox-group">
                            <div>
                                <input type="checkbox" name="has_hpn" id="has_hpn">
                                <label for="has_hpn">HPN</label>
                            </div>
                            <div>
                                <input type="checkbox" name="has_dm" id="has_dm">
                                <label for="has_dm">DM</label>
                            </div>
                            <div>
                                <input type="checkbox" name="has_ba" id="has_ba">
                                <label for="has_ba">BA</label>
                            </div>
                        </div>
                        <div class="flex gap-4 mt-2">
                            <div class="flex-1">
                                <label>OTHERS:</label>
                                <input type="text" name="other_medical_history" class="form-control1">
                            </div>
                            <div class="flex-1">
                                <label>MEDICATIONS:</label>
                                <input type="text" name="medications" class="form-control1">
                            </div>
                        </div>
                    </div>

                    <!-- Food and Drug Allergy -->
                    <div class="form-group">
                        <div class="flex gap-4">
                            <label>( ) FOOD AND DRUG ALLERGY:</label>
                            <input type="text" name="food_drug_allergy" class="form-control1">
                        </div>
                    </div>

                                        <!-- Surgery & Hospitalization -->
                        <div class="form-group">
                            <div class="flex gap-4">
                                <div class="flex-1">
                                    <label>( ) SURGERY:</label>
                                    <input type="text" name="surgery_history" class="form-control1">
                                </div>
                                <div class="flex-1">
                                    <label>( ) HOSPITALIZATION:</label>
                                    <input type="text" name="hospitalization" class="form-control1">
                                </div>
                            </div>
                        </div>

                    <!-- Employment History -->
                    <div class="form-group">
                        <label>EMPLOYMENT HISTORY</label>
                        <table class="table table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>COMPANY</th>
                                    <th>TENURE</th>
                                    <th>POSITION</th>
                                    <th>HAZARD EXPOSURE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="text" name="employment_history[company][]" class="form-control1"></td>
                                    <td><input type="text" name="employment_history[tenure][]" class="form-control1"></td>
                                    <td><input type="text" name="employment_history[position][]" class="form-control1"></td>
                                    <td><input type="text" name="employment_history[hazard][]" class="form-control1"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-2">
                            <label>WORK RELATED INJURY OR ILLNESS:</label>
                            <input type="text" name="work_related_injury" class="form-control1">
                        </div>
                    </div>

                         <!-- Personal & Social History -->
                <div class="form-group">
                    <label>PERSONAL & SOCIAL HISTORY</label>
                    <div class="flex gap-4 items-center">
                        <label>( ) cigarette smoking: Consumes</label>
                        <input type="number" name="cigarette_sticks_per_day" class="form-control1" style="width: 80px;">
                        <label>sticks/day x</label>
                        <input type="number" name="cigarette_years" class="form-control1" style="width: 80px;">
                        <label>yrs</label>
                    </div>
                    <div class="flex gap-4 items-center mt-2">
                        <label>( ) alcoholic beverage drinking: consumes</label>
                        <input type="text" name="alcohol_history" class="form-control1">
                    </div>
                </div>

                    <!-- Review of Systems -->
                    <div class="form-group">
                        <label>ROS:</label>
                        <table class="ros-table w-100">
                            <tr>
                                <td>
                                    <input type="checkbox" name="ros[wt_changes]"> wt changes<br>
                                    <input type="checkbox" name="ros[headache]"> Headache<br>
                                    <input type="checkbox" name="ros[blurring_of_vision]"> Blurring of vision<br>
                                    <input type="checkbox" name="ros[chest_discomfort]"> Chest discomfort<br>
                                    <input type="checkbox" name="ros[palpitations]"> Palpitations<br>
                                    <input type="checkbox" name="ros[cough]"> Cough<br>
                                    <input type="checkbox" name="ros[diarrhea]"> Diarrhea<br>
                                    <input type="checkbox" name="ros[pain_on_urination]"> Pain on urination
                                </td>
                                <td>
                                    <input type="checkbox" name="ros[excessive_tearing]"> Excessive tearing<br>
                                    <input type="checkbox" name="ros[hearing_deficiency]"> Hearing deficiency<br>
                                    <input type="checkbox" name="ros[tinnitus]"> Tinnitus<br>
                                    <input type="checkbox" name="ros[sob]"> SOB<br>
                                    <input type="checkbox" name="ros[dob]"> DOB<br>
                                    <input type="checkbox" name="ros[hyperacidity]"> Hyperacidity<br>
                                    <input type="checkbox" name="ros[frequent_urination]"> Frequent urination<br>
                                    <input type="checkbox" name="ros[leg_cramps]"> Leg cramps
                                </td>
                                <td>
                                    <input type="checkbox" name="ros[naso_aural_discharges]"> Naso-aural discharges<br>
                                    <input type="checkbox" name="ros[epistaxis]"> Epistaxis<br>
                                    <input type="checkbox" name="ros[toothache]"> Toothache<br>
                                    <input type="checkbox" name="ros[ulcer]"> Ulcer<br>
                                    <input type="checkbox" name="ros[back_pain]"> Back pain<br>
                                    <input type="checkbox" name="ros[muscle_joint_pain]"> Muscle/joint pain<br>
                                    <input type="checkbox" name="ros[anxiety]"> Anxiety<br>
                                    <input type="checkbox" name="ros[depression]"> Depression
                                </td>
                                <td>
                                    <input type="checkbox" name="ros[pain_on_swallowing]"> Pain on Swallowing<br>
                                    <input type="checkbox" name="ros[neck_pain]"> Neck pain<br>
                                    <input type="checkbox" name="ros[chest_pain]"> Chest pain<br>
                                    <input type="checkbox" name="ros[abdominal_pain]"> Abdominal pain<br>
                                    <input type="checkbox" name="ros[hemorrhoids]"> Hemorrhoids<br>
                                    <input type="checkbox" name="ros[constipation]"> Constipation<br>
                                    <input type="checkbox" name="ros[others]"> Others
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Physical Examination -->
                    <div class="form-group">
                        <label>PHYSICAL EXAMINATION</label>
                        <div class="form-group">
                            <label>General Survey:</label>
                            <input type="text" name="physical_examination" class="form-control1">
                        </div>
                        <div class="flex gap-4 items-center">
                            <label>Vital Signs: Wt:</label>
                            <input type="number" step="0.1" name="weight" id="weight" class="form-control1" style="width: 80px;">
                            <label>Ht:</label>
                            <input type="number" step="0.1" name="height" id="height" class="form-control1" style="width: 80px;">
                            <label>BMI:</label>
                            <input type="number" step="0.1" name="bmi" id="bmi" class="form-control1" style="width: 80px;">
                            <label>BP:</label>
                            <input type="text" name="bp" class="form-control1" style="width: 80px;">
                            <label>HR:</label>
                            <input type="number" name="hr" class="form-control1" style="width: 80px;">
                            <label>TEMP:</label>
                            <input type="number" step="0.1" name="temp" class="form-control1" style="width: 80px;">
                        </div>

                        <table class="table table-bordered w-100 mt-3">
                            <tr>
                                <th></th>
                                <th>Normal</th>
                                <th>Abnormal Findings</th>
                            </tr>
                            <tr>
                                <td>HEENT</td>
                                <td><input type="radio" name="heent_status" value="normal"></td>
                                <td><input type="text" name="heent" class="form-control1"></td>
                            </tr>
                            <tr>
                                <td>Neck</td>
                                <td><input type="radio" name="neck_status" value="normal"></td>
                                <td><input type="text" name="neck" class="form-control1"></td>
                            </tr>
                            <tr>
                                <td>Chest and Lungs</td>
                                <td><input type="radio" name="chest_and_lungs_status" value="normal"></td>
                                <td><input type="text" name="chest_and_lungs" class="form-control1"></td>
                            </tr>
                            <tr>
                                <td>Heart</td>
                                <td><input type="radio" name="heart_status" value="normal"></td>
                                <td><input type="text" name="heart" class="form-control1"></td>
                            </tr>
                            <tr>
                                <td>Abdomen</td>
                                <td><input type="radio" name="abdomen_status" value="normal"></td>
                                <td><input type="text" name="abdomen" class="form-control1"></td>
                            </tr>
                            <tr>
                                <td>Extremities</td>
                                <td><input type="radio" name="extremities_status" value="normal"></td>
                                <td><input type="text" name="extremities" class="form-control1"></td>
                            </tr>
                        </table>
                    </div>
                      <!-- Diagnosis, Treatment Plan & Prescription Section -->
                      <div class="prescription-section">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Diagnosis:</label>
                                <textarea name="diagnoses" class="form-control1" rows="3"></textarea>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Treatment Plan:</label>
                                <textarea name="treatment_plan" class="form-control1" rows="3"></textarea>
                            </div>
                        </div>
                                              <!-- Physician Information -->
                                              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                                <div>
                                                    <label class="block text-gray-700 font-medium mb-2">Physician Name:</label>
                                                    <input type="text" name="physician_name" class="form-control1" value="{{ Auth::user()->name }}" readonly>
                                                </div>
                                                <div>
                                                    <label class="block text-gray-700 font-medium mb-2">License No.:</label>
                                                    <input type="text" name="license_no" class="form-control1" value="{{ Auth::user()->license_no }}" readonly>
                                                </div>
                                            </div>

                                            <!-- Prescription -->
                                            <div class="mb-4">
                                                <label class="block text-gray-700 font-medium mb-2">Prescription:</label>
                                                <textarea name="prescription" class="form-control1 prescription-text" rows="10"
                                                        placeholder="Rx&#10;&#10;"></textarea>
                                            </div>

                                            <!-- Print Button -->
                                            <div class="text-right">
                                                <button type="button" onclick="printPrescription()"
                                                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors">
                                                    <i class="fas fa-print mr-2"></i>Print Prescription
                                                </button>
                                            </div>
                </div>
            </div>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const patientSelect = document.getElementById('patient_id');
        const patientInfo = document.getElementById('patientInfo');

        patientSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];

            if (this.value) {
                // Calculate age from DOB
                const dob = selectedOption.getAttribute('data-dob');
                const birthDate = dob ? new Date(dob) : null;
                let age = '-';

                if (birthDate) {
                    const today = new Date();
                    age = today.getFullYear() - birthDate.getFullYear();
                    const monthDiff = today.getMonth() - birthDate.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                        age--;
                    }
                }

                // Update patient information
                document.getElementById('patientAge').textContent = age;
                document.getElementById('patientGender').textContent =
                    selectedOption.getAttribute('data-gender') ?
                    selectedOption.getAttribute('data-gender').charAt(0).toUpperCase() +
                    selectedOption.getAttribute('data-gender').slice(1) : '-';
                document.getElementById('patientDOB').textContent =
                    selectedOption.getAttribute('data-dob') || '-';
                document.getElementById('patientCivilStatus').textContent =
                    selectedOption.getAttribute('data-civil-status') || '-';
                document.getElementById('patientContact').textContent =
                    selectedOption.getAttribute('data-contact') || '-';
                document.getElementById('patientEmail').textContent =
                    selectedOption.getAttribute('data-email') || '-';
                document.getElementById('patientAddress').textContent =
                    selectedOption.getAttribute('data-address') || '-';

                // Update vaccination information
                document.getElementById('patientVaccineType').textContent =
                    selectedOption.getAttribute('data-vaccine-type') || '-';
                document.getElementById('patientBoosterType').textContent =
                    selectedOption.getAttribute('data-booster-type') || '-';
                document.getElementById('patientFirstDose').textContent =
                    selectedOption.getAttribute('data-first-dose') || '-';
                document.getElementById('patientSecondDose').textContent =
                    selectedOption.getAttribute('data-second-dose') || '-';
                document.getElementById('patientFirstBooster').textContent =
                    selectedOption.getAttribute('data-first-booster') || '-';
                document.getElementById('patientSecondBooster').textContent =
                    selectedOption.getAttribute('data-second-booster') || '-';

                patientInfo.style.display = 'block';
            } else {
                patientInfo.style.display = 'none';
            }
        });

        // Set today's date as default
        document.getElementById('date').valueAsDate = new Date();

        // BMI calculation
        const weightInput = document.getElementById('weight');
        const heightInput = document.getElementById('height');
        const bmiInput = document.getElementById('bmi');

        function calculateBMI() {
            if (weightInput.value && heightInput.value) {
                const heightInMeters = heightInput.value / 100;
                const bmi = weightInput.value / (heightInMeters * heightInMeters);
                bmiInput.value = bmi.toFixed(2);
            }
        }

        if (weightInput && heightInput && bmiInput) {
            weightInput.addEventListener('input', calculateBMI);
            heightInput.addEventListener('input', calculateBMI);
        }
    });
    function printPrescription() {
            const prescription = document.querySelector('textarea[name="prescription"]').value;
            const physicianName = document.querySelector('input[name="physician_name"]').value;
            const licenseNo = document.querySelector('input[name="license_no"]').value;
            const patientSelect = document.getElementById('patient_id');
            const patientName = patientSelect.options[patientSelect.selectedIndex].text;
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
                        <p><strong>Date:<p><strong>Date:</strong> ${today}</p>
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

        // Wait for content to load
        setTimeout(() => {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }, 250);
    }

    // Add event listeners for radio buttons to handle normal/abnormal status
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
        const row = radio.closest('tr');
        const abnormalInput = row.querySelector('input[type="text"]');

        radio.addEventListener('change', function() {
            if (this.value === 'normal') {
                abnormalInput.value = '';
                abnormalInput.disabled = true;
            } else {
                abnormalInput.disabled = false;
            }
        });
    });

    // Initialize radio buttons' state
    document.querySelectorAll('input[type="radio"][value="normal"]').forEach(radio => {
        if (radio.checked) {
            const row = radio.closest('tr');
            const abnormalInput = row.querySelector('input[type="text"]');
            abnormalInput.value = '';
            abnormalInput.disabled = true;
        }
    });
</script>
@endsection
