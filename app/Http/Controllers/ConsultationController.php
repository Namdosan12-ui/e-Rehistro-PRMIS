<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\Transaction;
use App\Models\Patient;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    public function index()
    {
        $consultations = Consultation::with('patient')->get();
        return view('consultations.index', compact('consultations'));
    }

    public function create()
    {
        $patients = Patient::select('id', 'first_name', 'last_name')->get();
        return view('consultations.create', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
            'symptoms' => 'required|string',
            'diagnoses' => 'required|string',
            'treatment_plan' => 'required|string',
        ]);

        Consultation::create($request->all());
        return redirect()->route('consultations.index')->with('success', 'Consultation created successfully.');
    }

    public function show($id)
    {
        $consultation = Consultation::findOrFail($id);
        return view('consultations.show', compact('consultation'));
    }
    

    public function edit($id)
    {
        $consultation = Consultation::findOrFail($id);
        $patients = Patient::all(); // Fetch all patients
    
        return view('consultations.edit', compact('consultation', 'patients'));
    }
    

    public function update(Request $request, $id)
    {
        // Validate input
        $validatedData = $request->validate([
            'date' => 'required|date',
            'symptoms' => 'required|string',
            'diagnoses' => 'nullable|string',
            'treatment_plan' => 'nullable|string',
        ]);
    
        // Find the consultation
        $consultation = Consultation::findOrFail($id);
    
        // Update consultation data
        $consultation->date = $request->input('date');
        $consultation->symptoms = $request->input('symptoms');
        $consultation->diagnoses = $request->input('diagnoses');
        $consultation->treatment_plan = $request->input('treatment_plan');
        // Note: Patient ID should not be updated if it's not editable
        // $consultation->patient_id = $request->input('patient_id'); 
    
        // Save changes
        $consultation->save();
    
        // Redirect or return response
        return redirect()->route('consultations.index')->with('success', 'Consultation updated successfully.');
    }
    
    public function destroy($id)
    {
        // Find the consultation
        $consultation = Consultation::findOrFail($id);
    
        // Delete the consultation
        $consultation->delete();
    
        // Redirect or return response
        return redirect()->route('consultations.index')->with('success', 'Consultation deleted successfully.');
    }

    public function forward($id)
    {
        // Find the consultation by ID
        $consultation = Consultation::findOrFail($id);
        
        // Update the status of the consultation
        $consultation->status = 'forwarded'; // Update status
        $consultation->save();
    
        // Create a new transaction and link it to the consultation
        $transaction = new Transaction();
        $transaction->patient_id = $consultation->patient_id;
        $transaction->date = $consultation->date;
        $transaction->total_payments = 0; // Adjust this as needed
        $transaction->payment_status = 'unpaid'; // Default status
        $transaction->consultation_id = $consultation->id; // Link consultation to the transaction
        $transaction->save();
    
        // Redirect with success message
        return redirect()->route('consultations.index')->with('success', 'Consultation forwarded to Receptions.');
    }
    
    
    
}
