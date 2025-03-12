<?php

// app/Http/Controllers/ReleasingController.php

namespace App\Http\Controllers;

use App\Models\Releasing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResultMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ReleasingController extends Controller
{
    public function index()
    {
        // Fetch releasings in descending order by created_at
        $releasings = Releasing::with('transaction.patient')->orderBy('created_at', 'desc')->get();
        return view('releasings.index', compact('releasings'));
    }

    public function upload(Request $request, $id)
    {
        $request->validate([
            'result_file' => 'required|mimes:pdf|max:2048',
        ]);

        $releasing = Releasing::findOrFail($id);

        if ($request->hasFile('result_file')) {
            $file = $request->file('result_file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/releasing_files', $filename);

            $releasing->update(['result_file' => $filePath]);
        }

        return redirect()->route('releasings.index')->with('success', 'Result file uploaded successfully.');
    }

    public function view($id)
    {
        $releasing = Releasing::findOrFail($id);
        $filePath = Storage::path($releasing->result_file);

        return response()->file($filePath);
    }

    public function sendEmail($id)
    {
        // Find the releasing record
        $releasing = Releasing::findOrFail($id);

        try {
            // Check if result file exists
            $filePath = 'public/' . $releasing->result_file;
            if (!Storage::exists($filePath)) {
                return redirect()->back()->with('error', 'Result file not found!');
            }

            // Send email with attachment
            Mail::to($releasing->transaction->patient->email_address)
                ->send(new ResultMail($releasing));

            // Update email_sent status
            $releasing->update(['email_sent' => true]);

            return redirect()->back()->with('success', 'Email sent successfully!');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Failed to send email: ' . $e->getMessage());

            // Provide view link in case of email send failure
            $viewLink = route('releasings.view', $releasing->id);
            return redirect()->back()->with('error', 'Failed to send email. You can view the result <a href="' . $viewLink . '" target="_blank">here</a>.');
        }
    }

    public function release(Request $request, $id)
    {
        // Validate the request inputs
        $request->validate([
            'released_via_email' => 'boolean',
            'released_physical_copy' => 'boolean',
            'released_at' => 'required|date',
        ]);
    
        try {
            // Find the Releasing entry by ID
            $releasing = Releasing::findOrFail($id);
    
            // Update the releasing details
            $releasing->released_at = $request->released_at;
            $releasing->released_via_email = $request->has('released_via_email') ? $request->released_via_email : 0;
            $releasing->released_physical_copy = $request->has('released_physical_copy') ? $request->released_physical_copy : 0;
    
            // Update the releasing status
            if ($releasing->released_via_email || $releasing->released_physical_copy) {
                $releasing->releasing_status = 'released';
            } else {
                $releasing->releasing_status = 'unreleased';
            }
    
            // Save the changes
            $releasing->save();
    
            // Redirect back with a success message
            return redirect()->route('releasings.index')->with('success', 'Release details saved successfully.');
        } catch (\Exception $e) {
            // Redirect back with an error message
            return redirect()->route('releasings.index')->with('error', 'Failed to save release details.');
        }
    }
}
