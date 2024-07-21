<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\LaboratoryService;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Queue;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->paginate(10);
        return view('transactions.index', compact('transactions'));
    }
    

    public function create()
    {
        $patients = Patient::all();
        $categories = Category::with('services')->get();

        return view('transactions.create', compact('patients', 'categories'));
    }
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'patient_id' => 'required',
            'date' => 'required|date',
            'total_payments' => 'required|numeric',
            'laboratory_services' => 'required|array',
            'last_meal' => 'nullable|date',
            'physician' => 'nullable|string|max:255',
            'radiologic_technologist' => 'nullable|string|max:255',
            'drug_test_purpose' => 'nullable|string|max:255',
            'confirmatory_testing_agreement' => 'nullable|string|max:255',
            'sample_acknowledgement' => 'nullable|string|max:255',
            'medication_past_30_days' => 'nullable|string|max:255',
            'alcohol_past_24_hours' => 'nullable|string|max:255',
            'sample_type' => 'nullable|string',
        ]);
    
        // Create new Transaction instance
        $transaction = new Transaction();
        $transaction->patient_id = $request->patient_id;
        $transaction->date = $request->date;
        $transaction->total_payments = $request->total_payments;
    
        // Check and format last meal if provided
        if ($request->has('last_meal')) {
            $transaction->last_meal = date('Y-m-d H:i:s', strtotime($request->last_meal));
        }
    
        // Add optional fields
            
            $transaction->physician = $request->physician;
            $transaction->radiologic_technologist = $request->radiologic_technologist;
            $transaction->drug_test_purpose = $request->drug_test_purpose;
            $transaction->confirmatory_testing_agreement = $request->confirmatory_testing_agreement;
            $transaction->sample_acknowledgement = $request->sample_acknowledgement;
            $transaction->medication_past_30_days = $request->medication_past_30_days;
            $transaction->alcohol_past_24_hours = $request->alcohol_past_24_hours;
            $transaction->sample_type = $request->sample_type;
            
            
            
        // Get the category from the first selected service
        $services = $request->input('laboratory_services', []);
        if (!empty($services)) {
            $firstServiceId = $services[0];
            $firstService = LaboratoryService::findOrFail($firstServiceId);
            $transaction->category_id = $firstService->category_id;
        }
    
        // Save transaction to database
        $transaction->save();
    
        // Attach selected laboratory services to the transaction
        $transaction->services()->attach($services);
    
        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }
    



public function show($id)
{
    $transaction = Transaction::with('patient', 'services')->find($id);

    return view('transactions.show', compact('transaction'));
}

public function destroy($id)
{
    $transaction = Transaction::findOrFail($id);
    $transaction->delete();

    return redirect()->route('transactions.index')
        ->with('success', 'Transaction deleted successfully.');
}


    public function markPaid($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->payment_status = 'paid';
        $transaction->save();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction marked as paid.');
    }

    public function currency($value)
    {
        // Replace this logic with your desired currency formatting
        return '€' . number_format($value, 2);
    }

    public function transactions(Patient $patient)
    {
        // Fetch only 'paid' transactions
        $transactions = Transaction::where('patient_id', $patient->id)
                                   ->where('payment_status', 'paid')
                                   ->paginate(3); // Limit to 3 transactions per page
    
        return view('transactions.transactions', [
            'patient' => $patient,
            'transactions' => $transactions,
        ]);
    }

    public function search(Request $request, $patient_id)
    {
        $searchTerm = $request->input('search');
    
        // Load the patient
        $patient = Patient::findOrFail($patient_id);
    
        $transactions = Transaction::where('patient_id', $patient_id)
                                    ->whereHas('laboratoryServices', function ($query) use ($searchTerm) {
                                        $query->where('service_name', 'like', '%'.$searchTerm.'%');
                                    })
                                    ->paginate(10);
    
        // Return the view with both $patient and $transactions variables
        return view('patients.transactions', compact('patient', 'transactions'));
    }
    
    public function queue()
    {
        return $this->hasOne(Queue::class);
    }

}

    

