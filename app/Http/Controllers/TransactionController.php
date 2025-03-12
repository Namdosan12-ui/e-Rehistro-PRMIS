<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Category;
use App\Models\LaboratoryService;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Consultation;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index()
    {
        // Get all transactions ordered by creation date, with pagination
        $transactions = Transaction::orderBy('created_at', 'desc')->paginate(10);

        return view('transactions.index', compact('transactions'));

    }

    public function edit($id)
    {
        $transaction = Transaction::findOrFail($id);
        $categories = Category::all(); // Fetch all categories
        $patients = Patient::all(); // Fetch all patients

        return view('transactions.edit', compact('transaction', 'categories', 'patients'));
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
            'discount_id' => 'nullable|exists:discounts,id',
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
        $transaction->discount_id = $request->discount_id;

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
        // Load the transaction with related models
        $transaction = Transaction::with(['consultation', 'patient', 'services', 'queue'])->findOrFail($id);

        // Convert the date field in the consultation to a Carbon instance if necessary
        if ($transaction->consultation && is_string($transaction->consultation->date)) {
            $transaction->consultation->date = \Carbon\Carbon::parse($transaction->consultation->date);
        }

        // You might want to check if `services` or `queue` needs similar handling
        // For example, converting dates in `queue` if needed

        return view('transactions.show', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'physician' => 'nullable|string',
            'radiologic_technologist' => 'nullable|string',
            'date' => 'required|date',
            'last_meal' => 'nullable|date_format:Y-m-d\TH:i',
            'total_payments' => 'required|numeric',
            'discount_id' => 'nullable|exists:discounts,id',
            'laboratory_services' => 'nullable|array',
            'laboratory_services.*' => 'exists:laboratory_services,id',
            'drug_test_purpose' => 'nullable|string',
            'other_purpose_specify' => 'nullable|string',
            'medication_past_30_days' => 'nullable|string',
            'alcohol_past_24_hours' => 'nullable|string',
            'sample_type' => 'nullable|string',
            'confirmatory_testing_agreement' => 'nullable|string',
            'sample_acknowledgement' => 'nullable|string',
        ]);

        // Find the transaction by ID
        $transaction = Transaction::findOrFail($id);

        // Update the transaction with validated data
        $transaction->update([
            'patient_id' => $validatedData['patient_id'],
            'physician' => $validatedData['physician'],
            'radiologic_technologist' => $validatedData['radiologic_technologist'],
            'date' => $validatedData['date'],
            'last_meal' => $validatedData['last_meal'],
            'total_payments' => $validatedData['total_payments'],
           'discount_id' => $validatedData['discount_id'] ?? null, // Use null if discount_id is not present
            'drug_test_purpose' => $validatedData['drug_test_purpose'],
            'other_purpose_specify' => $validatedData['other_purpose_specify'],
            'medication_past_30_days' => $validatedData['medication_past_30_days'],
            'alcohol_past_24_hours' => $validatedData['alcohol_past_24_hours'],
            'sample_type' => $validatedData['sample_type'],
            'confirmatory_testing_agreement' => $validatedData['confirmatory_testing_agreement'] ?? null,
            'sample_acknowledgement' => $validatedData['sample_acknowledgement'] ?? null,
        ]);

        // Sync the laboratory services
        $transaction->services()->sync($validatedData['laboratory_services'] ?? []);

        // Redirect back with a success message
        return redirect()->route('transactions.index')->with('success', 'Transaction updated successfully.');
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



