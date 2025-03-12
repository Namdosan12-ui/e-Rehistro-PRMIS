<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PatientController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'contact_information' => 'required|string|max:255',
            'email_address' => 'required|email|max:255',
            'address' => 'required|string',
            'civil_status' => 'required|in:single,married,divorced,widowed',
            'occupation' => 'required|string|max:255',
            'profile_picture' => 'nullable|string',
        ]);

        // Handle profile picture
        $profilePicture = null;
        if ($request->profile_picture) {
            // Remove the "data:image/jpeg;base64," part and decode
            $image = base64_decode(explode(',', $request->profile_picture)[1]);

            // Generate unique filename
            $filename = time() . '_' . Str::random(10) . '.jpg';

            // Save file to public/storage/patient_photos
            file_put_contents(public_path('storage/patient_photos/' . $filename), $image);
            $profilePicture = 'patient_photos/' . $filename;
        }

        // Create patient record
        $patient = Patient::create([
            'profile_picture' => $profilePicture,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'contact_information' => $request->contact_information,
            'email_address' => $request->email_address,
            'address' => $request->address,
            'civil_status' => $request->civil_status,
            'occupation' => $request->occupation,
            'patient_type_id' => 2, // Set as Walk-in by default
            'philhealth_number' => 'NONE',
            'pwd_id_number' => 'NONE',
            'senior_citizen_card_number' => 'NONE',
            'emergency_contact_name' => 'Not Provided',
            'emergency_contact_mobile' => 'Not Provided',
            'emergency_contact_relation' => 'Not Provided',
            'vaccine_type' => 'Not Provided',
            'booster_type' => 'Not Provided',
            'first_dose_date' => null,
            'second_dose_date' => null,
            'first_booster_date' => null,
            'second_booster_date' => null,
        ]);

        return redirect()->route('patient.registration-slip', $patient->id);
    }

    public function showRegistrationSlip(Patient $patient)
    {
        return view('registration-slip', compact('patient'));
    }
}
