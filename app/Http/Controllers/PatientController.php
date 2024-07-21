<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::all();
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        $vaccineTypes = [
            'Pfizer–BioNTech',
            'Oxford–AstraZeneca',
            'Sinopharm BIBP',
            'Moderna',
            'Janssen',
            'CoronaVac',
            'Covaxin',
            'Novavax',
            'Convidecia',
            'Sanofi–GSK',
        ];

        $boosterTypes = [
            'Pfizer–BioNTech',
            'Oxford–AstraZeneca',
            'Sinopharm BIBP',
            'Moderna',
            'Janssen',
            'CoronaVac',
            'Covaxin',
            'Novavax',
            'Convidecia',
            'Sanofi–GSK',
        ];

        $civilStatusOptions = [
            'single' => 'Single',
            'married' => 'Married',
            'separated' => 'Separated',
            'divorced' => 'Divorced',
            'widowed' => 'Widowed',
        ];

        return view('patients.create', compact('vaccineTypes', 'boosterTypes', 'civilStatusOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:10',
            'contact_information' => 'required|string|max:255',
            'email_address' => 'required|email|max:255',
            'address' => 'required|string|max:255',
            'civil_status' => 'required|in:single,married,separated,divorced,widowed',
            'philhealth_number' => 'nullable|string|max:255',
            'pwd_id_number' => 'nullable|string|max:255',
            'occupation' => 'required|string|max:255',
            'senior_citizen_card_number' => 'nullable|string|max:255',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_mobile' => 'required|string|max:255',
            'emergency_contact_relation' => 'required|string|max:255',
            'vaccine_type' => 'required|string|max:255',
            'first_dose_date' => 'required|date|nullable',
            'second_dose_date' => 'required|date|nullable',
            'booster_type' => 'required|string|max:255',
            'first_booster_date' => 'required|date|nullable',
            'second_booster_date' => 'required|date|nullable',
        ]);

        $data = $request->all();
        $data['philhealth_number'] = $data['philhealth_number'] ?? 'NONE';
        $data['pwd_id_number'] = $data['pwd_id_number'] ?? 'NONE';
        $data['senior_citizen_card_number'] = $data['senior_citizen_card_number'] ?? 'NONE';

        Patient::create($data);

        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }

    public function show($id)
    {
        $patient = Patient::findOrFail($id);
    
        $civilStatusOptions = [
            'single' => 'Single',
            'married' => 'Married',
            'widowed' => 'Widowed',
            'divorced' => 'Divorced',
            // Add other options as needed
        ];
    
        return view('patients.show', compact('patient', 'civilStatusOptions'));
    }

    public function edit($id)
    {
        $patient = Patient::findOrFail($id);

        $vaccineTypes = [
            'Pfizer–BioNTech',
            'Oxford–AstraZeneca',
            'Sinopharm BIBP',
            'Moderna',
            'Janssen',
            'CoronaVac',
            'Covaxin',
            'Novavax',
            'Convidecia',
            'Sanofi–GSK',
        ];

        $boosterTypes = [
            'Pfizer–BioNTech',
            'Oxford–AstraZeneca',
            'Sinopharm BIBP',
            'Moderna',
            'Janssen',
            'CoronaVac',
            'Covaxin',
            'Novavax',
            'Convidecia',
            'Sanofi–GSK',
        ];

        $civilStatusOptions = [
            'single' => 'Single',
            'married' => 'Married',
            'separated' => 'Separated',
            'divorced' => 'Divorced',
            'widowed' => 'Widowed',
        ];

        return view('patients.edit', compact('patient', 'vaccineTypes', 'boosterTypes', 'civilStatusOptions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'contact_information' => 'required|string|max:255',
            'email_address' => 'required|string|email|max:255|unique:patients,email_address,'.$id,
            'address' => 'required|string|max:255',
            'civil_status' => 'required|in:single,married,separated,divorced,widowed',
            'occupation' => 'required|string|max:255',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_mobile' => 'required|string|max:255',
            'emergency_contact_relation' => 'required|string|max:255',
            'philhealth_number' => 'nullable|string|max:255',
            'pwd_id_number' => 'nullable|string|max:255',
            'senior_citizen_card_number' => 'nullable|string|max:255',
        ]);

        $patient = Patient::findOrFail($id);

        $data = $request->all();
        $data['philhealth_number'] = $data['philhealth_number'] ?? 'NONE';
        $data['pwd_id_number'] = $data['pwd_id_number'] ?? 'NONE';
        $data['senior_citizen_card_number'] = $data['senior_citizen_card_number'] ?? 'NONE';

        $patient->update($data);

        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy($id)
    {
        $patient = Patient::findOrFail($id);
        $patient->delete();

        return redirect()->route('patients.index')->with('success', 'Patient has been deleted successfully.');
    }

    public function showTransactions($id)
    {
        $patient = Patient::findOrFail($id);
        $transactions = $patient->transactions()->orderBy('created_at', 'desc')->paginate(10); // Example: Paginate by 10 transactions per page

        return view('patients.transactions', compact('patient', 'transactions'));
    }
    
}
