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
    .checkbox-group {
        display: flex;
        gap: 20px;
        align-items: center;
    }
    .ros-table td {
        padding: 5px;
        vertical-align: top;
    }
</style>

<form action="{{ route('physician.consultations.update', $consultation->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="relative bg-gradient-to-r from-blue-500 to-white-600 px-8 py-12 overflow-hidden">
            <div class="absolute inset-0 bg-grid-white/[0.1] bg-[length:16px_16px]"></div>
            <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -top-16 -left-16"></div>
            <div class="absolute h-32 w-32 rounded-full bg-blue-400/20 -bottom-16 -right-16"></div>
            <div class="relative flex justify-between items-center">
                <h1 class="all-header">
                    <i class="fas fa-stethoscope text-2xl text-teal-600 bg-teal-100 p-3 rounded-lg mr-4"></i>
                    {{ __('Edit Consultation') }}
                </h1>
                <div class="flex space-x-4">
                    <div class="flex justify-end space-x-4 mt-4">
                        <button type="submit" class="px-6 py-3 bg-white text-blue-600 rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-200 flex items-center space-x-2">
                            <i class="fas fa-save"></i><span>Update</span>
                        </button>
                        <a href="{{ route('physician.consultations.index') }}" class="px-6 py-3 bg-blue-400/40 text-blue rounded-xl font-semibold hover:bg-blue-400/40 transition-all duration-200 flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i><span>Back</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="all">
            <div class="section-container mb-8 bg-gray-50 rounded-2xl p-6 border border-gray-100">
                <!-- Patient Selection (Disabled) -->
                <div class="form-group mb-6">
                    <label for="patient_id" class="form-label">Patient</label>
                    <select name="patient_id" id="patient_id" class="form-control1" disabled>
                        @foreach($patients as $patient)
                            <option value="{{ $patient->id }}"
                                {{ $consultation->patient_id == $patient->id ? 'selected' : '' }}>
                                {{ $patient->first_name }} {{ $patient->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="medical-form">
                    <!-- Chief Complaint -->
                    <div class="form-group">
                        <label>CHIEF COMPLAINT:</label>
                        <input type="text" name="symptoms" class="form-control1" value="{{ $consultation->symptoms }}">
                    </div>

                    <!-- History of Present Illness -->
                    <div class="form-group">
                        <label>HISTORY OF PRESENT ILLNESS:</label>
                        <textarea name="history_of_present_illness" class="form-control1" rows="2">{{ $consultation->history_of_present_illness }}</textarea>
                    </div>

                    <!-- Past Medical History -->
                    <div class="form-group history-form">
                        <label>PAST MEDICAL HISTORY:</label>
                        <div class="checkbox-group">
                            <div>
                                <input type="checkbox" name="has_hpn" id="has_hpn" {{ $consultation->has_hpn ? 'checked' : '' }}>
                                <label for="has_hpn">HPN</label>
                            </div>
                            <div>
                                <input type="checkbox" name="has_dm" id="has_dm" {{ $consultation->has_dm ? 'checked' : '' }}>
                                <label for="has_dm">DM</label>
                            </div>
                            <div>
                                <input type="checkbox" name="has_ba" id="has_ba" {{ $consultation->has_ba ? 'checked' : '' }}>
                                <label for="has_ba">BA</label>
                            </div>
                        </div>
                        <div class="flex gap-4 mt-2">
                            <div class="flex-1">
                                <label>OTHERS:</label>
                                <input type="text" name="other_medical_history" class="form-control1" value="{{ $consultation->other_medical_history }}">
                            </div>
                            <div class="flex-1">
                                <label>MEDICATIONS:</label>
                                <input type="text" name="medications" class="form-control1" value="{{ $consultation->medications }}">
                            </div>
                        </div>
                    </div>

                    <!-- Food and Drug Allergy -->
                    <div class="form-group">
                        <div class="flex gap-4">
                            <label>( ) FOOD AND DRUG ALLERGY:</label>
                            <input type="text" name="food_drug_allergy" class="form-control1" value="{{ $consultation->food_drug_allergy }}">
                        </div>
                    </div>

                    <!-- Surgery & Hospitalization -->
                    <div class="form-group">
                        <div class="flex gap-4">
                            <div class="flex-1">
                                <label>( ) SURGERY:</label>
                                <input type="text" name="surgery_history" class="form-control1" value="{{ $consultation->surgery_history }}">
                            </div>
                            <div class="flex-1">
                                <label>( ) HOSPITALIZATION:</label>
                                <input type="text" name="hospitalization" class="form-control1" value="{{ $consultation->hospitalization }}">
                            </div>
                        </div>
                    </div>

                    <!-- Employment History -->
                    <div class="form-group">
                        <label>EMPLOYMENT HISTORY</label>
                        @php
                            $employmentHistory = json_decode($consultation->employment_history, true) ??
                            ['company' => [''], 'tenure' => [''], 'position' => [''], 'hazard' => ['']];
                        @endphp
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
                                    <td><input type="text" name="employment_history[company][]" class="form-control1" value="{{ $employmentHistory['company'][0] ?? '' }}"></td>
                                    <td><input type="text" name="employment_history[tenure][]" class="form-control1" value="{{ $employmentHistory['tenure'][0] ?? '' }}"></td>
                                    <td><input type="text" name="employment_history[position][]" class="form-control1" value="{{ $employmentHistory['position'][0] ?? '' }}"></td>
                                    <td><input type="text" name="employment_history[hazard][]" class="form-control1" value="{{ $employmentHistory['hazard'][0] ?? '' }}"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-2">
                            <label>WORK RELATED INJURY OR ILLNESS:</label>
                            <input type="text" name="work_related_injury" class="form-control1" value="{{ $consultation->work_related_injury }}">
                        </div>
                    </div>

                    <!-- Personal & Social History -->
                    <div class="form-group">
                        <label>PERSONAL & SOCIAL HISTORY</label>
                        <div class="flex gap-4 items-center">
                            <label>( ) cigarette smoking: Consumes</label>
                            <input type="number" name="cigarette_sticks_per_day" class="form-control1" style="width: 80px;" value="{{ $consultation->cigarette_sticks_per_day }}">
                            <label>sticks/day x</label>
                            <input type="number" name="cigarette_years" class="form-control1" style="width: 80px;" value="{{ $consultation->cigarette_years }}">
                            <label>yrs</label>
                        </div>
                        <div class="flex gap-4 items-center mt-2">
                            <label>( ) alcoholic beverage drinking: consumes</label>
                            <input type="text" name="alcohol_history" class="form-control1" value="{{ $consultation->alcohol_history }}">
                        </div>
                    </div>

                    <!-- Review of Systems -->
                    <div class="form-group">
                        <label>ROS:</label>
                        @php
                            $ros = json_decode($consultation->ros, true) ?? [];
                        @endphp
                        <table class="ros-table w-100">
                            <tr>
                                <td>
                                    <input type="checkbox" name="ros[wt_changes]" {{ isset($ros['wt_changes']) ? 'checked' : '' }}> wt changes<br>
                                    <input type="checkbox" name="ros[headache]" {{ isset($ros['headache']) ? 'checked' : '' }}> Headache<br>
                                    <input type="checkbox" name="ros[blurring_of_vision]" {{ isset($ros['blurring_of_vision']) ? 'checked' : '' }}> Blurring of vision<br>
                                    <input type="checkbox" name="ros[chest_discomfort]" {{ isset($ros['chest_discomfort']) ? 'checked' : '' }}> Chest discomfort<br>
                                    <input type="checkbox" name="ros[palpitations]" {{ isset($ros['palpitations']) ? 'checked' : '' }}> Palpitations<br>
                                    <input type="checkbox" name="ros[cough]" {{ isset($ros['cough']) ? 'checked' : '' }}> Cough<br>
                                    <input type="checkbox" name="ros[diarrhea]" {{ isset($ros['diarrhea']) ? 'checked' : '' }}> Diarrhea<br>
                                    <input type="checkbox" name="ros[pain_on_urination]" {{ isset($ros['pain_on_urination']) ? 'checked' : '' }}> Pain on urination
                                </td>
                                <td>
                                    <input type="checkbox" name="ros[excessive_tearing]" {{ isset($ros['excessive_tearing']) ? 'checked' : '' }}> Excessive tearing<br>
                                    <input type="checkbox" name="ros[hearing_deficiency]" {{ isset($ros['hearing_deficiency']) ? 'checked' : '' }}> Hearing deficiency<br>
                                    <input type="checkbox" name="ros[tinnitus]" {{ isset($ros['tinnitus']) ? 'checked' : '' }}> Tinnitus<br>
                                    <input type="checkbox" name="ros[sob]" {{ isset($ros['sob']) ? 'checked' : '' }}> SOB<br>
                                    <input type="checkbox" name="ros[dob]" {{ isset($ros['dob']) ? 'checked' : '' }}> DOB<br>
                                    <input type="checkbox" name="ros[hyperacidity]" {{ isset($ros['hyperacidity']) ? 'checked' : '' }}> Hyperacidity<br>
                                    <input type="checkbox" name="ros[frequent_urination]" {{ isset($ros['frequent_urination']) ? 'checked' : '' }}> Frequent urination<br>
                                    <input type="checkbox" name="ros[leg_cramps]" {{ isset($ros['leg_cramps']) ? 'checked' : '' }}> Leg cramps
                                </td>
                                <td>
                                    <input type="checkbox" name="ros[naso_aural_discharges]" {{ isset($ros['naso_aural_discharges']) ? 'checked' : '' }}> Naso-aural discharges<br>
                                    <input type="checkbox" name="ros[epistaxis]" {{ isset($ros['epistaxis']) ? 'checked' : '' }}> Epistaxis<br>
                                    <input type="checkbox" name="ros[toothache]" {{ isset($ros['toothache']) ? 'checked' : '' }}> Toothache<br>
                                    <input type="checkbox" name="ros[ulcer]" {{ isset($ros['ulcer']) ? 'checked' : '' }}> Ulcer<br>
                                    <input type="checkbox" name="ros[back_pain]" {{ isset($ros['back_pain']) ? 'checked' : '' }}> Back pain<br>
                                    <input type="checkbox" name="ros[muscle_joint_pain]" {{ isset($ros['muscle_joint_pain']) ? 'checked' : '' }}> Muscle/joint pain<br>
                                    <input type="checkbox" name="ros[anxiety]" {{ isset($ros['anxiety']) ? 'checked' : '' }}> Anxiety<br>
                                    <input type="checkbox" name="ros[depression]" {{ isset($ros['depression']) ? 'checked' : '' }}> Depression
                                </td>
                                <td>
                                    <input type="checkbox" name="ros[pain_on_swallowing]" {{ isset($ros['pain_on_swallowing']) ? 'checked' : '' }}> Pain on Swallowing<br>
                                    <input type="checkbox" name="ros[neck_pain]" {{ isset($ros['neck_pain']) ? 'checked' : '' }}> Neck pain<br>
                                    <input type="checkbox" name="ros[chest_pain]" {{ isset($ros['chest_pain']) ? 'checked' : '' }}> Chest pain<br>
                                    <input type="checkbox" name="ros[abdominal_pain]" {{ isset($ros['abdominal_pain']) ? 'checked' : '' }}> Abdominal pain<br>
                                    <input type="checkbox" name="ros[hemorrhoids]" {{ isset($ros['hemorrhoids']) ? 'checked' : '' }}> Hemorrhoids<br>
                                    <input type="checkbox" name="ros[constipation]" {{ isset($ros['constipation']) ? 'checked' : '' }}> Constipation<br>
                                    <input type="checkbox" name="ros[others]" {{ isset($ros['others']) ? 'checked' : '' }}> Others
                                </td>
                            </tr>
                        </table>
                    </div>

                  <!-- Physical Examination -->
                  <div class="form-group">
                    <label>PHYSICAL EXAMINATION</label>
                    <div class="form-group">
                        <label>General Survey:</label>
                        <input type="text" name="physical_examination" class="form-control1" value="{{ $consultation->physical_examination }}">
                    </div>
                    <div class="flex gap-4 items-center">
                        <label>Vital Signs: Wt:</label>
                        <input type="number" step="0.1" name="weight" id="weight" class="form-control1" style="width: 80px;" value="{{ $consultation->weight }}">
                        <label>Ht:</label>
                        <input type="number" step="0.1" name="height" id="height" class="form-control1" style="width: 80px;" value="{{ $consultation->height }}">
                        <label>BMI:</label>
                        <input type="number" step="0.1" name="bmi" id="bmi" class="form-control1" style="width: 80px;" value="{{ $consultation->bmi }}">
                        <label>BP:</label>
                        <input type="text" name="bp" class="form-control1" style="width: 80px;" value="{{ $consultation->bp }}">
                        <label>HR:</label>
                        <input type="number" name="hr" class="form-control1" style="width: 80px;" value="{{ $consultation->hr }}">
                        <label>TEMP:</label>
                        <input type="number" step="0.1" name="temp" class="form-control1" style="width: 80px;" value="{{ $consultation->temp }}">
                    </div>

                    <table class="table table-bordered w-100 mt-3">
                        <tr>
                            <th></th>
                            <th>Normal</th>
                            <th>Abnormal Findings</th>
                        </tr>
                        <tr>
                            <td>HEENT</td>
                            <td><input type="radio" name="heent_status" value="normal" {{ $consultation->heent_status === 'normal' ? 'checked' : '' }}></td>
                            <td><input type="text" name="heent" class="form-control1" value="{{ $consultation->heent }}"></td>
                        </tr>
                        <tr>
                            <td>Neck</td>
                            <td><input type="radio" name="neck_status" value="normal" {{ $consultation->neck_status === 'normal' ? 'checked' : '' }}></td>
                            <td><input type="text" name="neck" class="form-control1" value="{{ $consultation->neck }}"></td>
                        </tr>
                        <tr>
                            <td>Chest and Lungs</td>
                            <td><input type="radio" name="chest_and_lungs_status" value="normal" {{ $consultation->chest_and_lungs_status === 'normal' ? 'checked' : '' }}></td>
                            <td><input type="text" name="chest_and_lungs" class="form-control1" value="{{ $consultation->chest_and_lungs }}"></td>
                        </tr>
                        <tr>
                            <td>Heart</td>
                            <td><input type="radio" name="heart_status" value="normal" {{ $consultation->heart_status === 'normal' ? 'checked' : '' }}></td>
                            <td><input type="text" name="heart" class="form-control1" value="{{ $consultation->heart }}"></td>
                        </tr>
                        <tr>
                            <td>Abdomen</td>
                            <td><input type="radio" name="abdomen_status" value="normal" {{ $consultation->abdomen_status === 'normal' ? 'checked' : '' }}></td>
                            <td><input type="text" name="abdomen" class="form-control1" value="{{ $consultation->abdomen }}"></td>
                        </tr>
                        <tr>
                            <td>Extremities</td>
                            <td><input type="radio" name="extremities_status" value="normal" {{ $consultation->extremities_status === 'normal' ? 'checked' : '' }}></td>
                            <td><input type="text" name="extremities" class="form-control1" value="{{ $consultation->extremities }}"></td>
                        </tr>
                    </table>
                </div>

                <!-- Diagnosis, Treatment Plan & Prescription Section -->
                <div class="prescription-section">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Diagnosis:</label>
                            <textarea name="diagnoses" class="form-control1" rows="3">{{ $consultation->diagnoses }}</textarea>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Treatment Plan:</label>
                            <textarea name="treatment_plan" class="form-control1" rows="3">{{ $consultation->treatment_plan }}</textarea>
                        </div>
                    </div>

                    <!-- Physician Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">Physician Name:</label>
                            <input type="text" name="physician_name" class="form-control1"
                                   value="{{ $consultation->physician_name ?? Auth::user()->name }}"
                                   readonly>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-2">License No.:</label>
                            <input type="text" name="license_no" class="form-control1"
                                   value="{{ $consultation->license_no ?? Auth::user()->license_no }}"
                                   readonly>
                        </div>
                    </div>

                    <!-- Prescription -->
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Prescription:</label>
                        <textarea name="prescription" class="form-control1 prescription-text" rows="10"
                                placeholder="Rx&#10;&#10;">{{ $consultation->prescription }}</textarea>
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
</div>
</form>

<script>

function calculateBMI() {
    const weight = document.getElementById('weight').value;
    const height = document.getElementById('height').value;

    if (weight && height) {
        // Convert height to meters (assuming input is in meters)
        const heightInMeters = height;
        const bmi = (weight / (heightInMeters * heightInMeters)).toFixed(1);
        document.getElementById('bmi').value = bmi;
    }
}

// Add event listeners to weight and height inputs
document.getElementById('weight').addEventListener('input', calculateBMI);
document.getElementById('height').addEventListener('input', calculateBMI);

// Initial calculation if values are present
calculateBMI();


    // Radio button handling
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

        // Initialize state
        if (radio.checked && radio.value === 'normal') {
            abnormalInput.value = '';
            abnormalInput.disabled = true;
        }
    });

    // Prescription printing functionality
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
                    body { font-family: Arial, sans-serif; padding: 20px; max-width: 800px; margin: 0 auto; }
                    .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
                    .patient-info { margin-bottom: 20px; }
                    .prescription-content { font-family: 'Courier New', monospace; white-space: pre-line; margin: 20px 0; padding: 20px; border: 1px solid #ccc; min-height: 200px; }
                    .footer { margin-top: 50px; text-align: right; }
                    .signature-line { border-top: 1px solid #000; width: 200px; margin-left: auto; margin-bottom: 10px; }
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

        // Wait for content to load
        setTimeout(() => {
            printWindow.focus();
            printWindow.print();
            printWindow.close();
        }, 250);
    }

</script>
@endsection
