<?php

namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;
use Illuminate\Support\Facades\Mail;
use App\Mail\Reception\MedicalResultsMail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use App\Models\Patient;
use App\Models\LaboratoryService;
use App\Models\Transaction;
use App\Models\Queue;
use App\Models\Releasing;
use App\Models\Category;
use Carbon\Carbon;
use App\Models\PatientType;
use App\Models\Consultation;

class ReceptionController extends Controller
{
    public function index()
    {
        // Basic counts
        $patientCount = Patient::count();
        $laboratoryServiceCount = LaboratoryService::count();
        $transactionCount = Transaction::count();

        // Monthly patient statistics
        $monthlyPatients = Patient::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->get()
            ->map(function ($item) {
                $item->month = Carbon::createFromDate($item->year, $item->month, 1)->format('F');
                return $item;
            });

        // Monthly revenue analysis
        $monthlyRevenue = Transaction::selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(total_payments) as revenue')
            ->groupBy('year', 'month')
            ->get()
            ->map(function ($item) {
                $item->month = Carbon::createFromDate($item->year, $item->month, 1)->format('F');
                return $item;
            });

        // Top laboratory services
        $topLaboratoryServices = LaboratoryService::withCount('transactions')
            ->orderBy('transactions_count', 'desc')
            ->take(5)
            ->get();

        // Pending queues with related data
        $pendingQueues = Queue::with(['transaction.patient', 'transaction.services'])
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('created_at', 'asc')
            ->take(5)
            ->get();

        // Return view with all required data
        return view('reception.index', compact(
            'patientCount',
            'laboratoryServiceCount',
            'transactionCount',
            'monthlyPatients',
            'monthlyRevenue',
            'topLaboratoryServices',
            'pendingQueues'
        ));
    }

// Users Management

public function usersIndex()
{
    $users = User::with('role')->get(); // Eager load roles to avoid N+1 problem
    return view('reception.users.index', compact('users'));
}

public function usersCreate()
{
    $roles = Role::all();
    return view('reception.users.create', compact('roles'));
}

public function usersStore(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8',
        'role_id' => 'required|exists:roles,id',
        'birthday' => 'nullable|date',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'license_no' => 'nullable|string|max:255',
    ]);

    // Handle file upload
    $profilePicturePath = null;
    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        // Store directly in public/storage/profile_pictures
        $file->move(public_path('storage/profile_pictures'), $filename);
        $profilePicturePath = 'profile_pictures/' . $filename;
    }

    // Create the user
    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $request->role_id,
        'birthday' => $request->birthday,
        'profile_picture' => $profilePicturePath,
        'license_no' => $request->license_no,
    ]);

    return redirect()->route('reception.users.index')->with('success', 'User created successfully.');
}

public function usersEdit($id)
{
    $user = User::findOrFail($id);
    $roles = Role::all();
    return view('reception.users.edit', compact('user', 'roles'));
}

public function usersUpdate(Request $request, $id)
{
    $user = User::findOrFail($id);
    $validatedData = $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'nullable|min:6',
        'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'role_id' => 'required',
        'birthday' => 'nullable|date',
        'license_no' => 'nullable|string|max:255',
    ]);

    // Update user data
    $user->name = $validatedData['name'];
    $user->email = $validatedData['email'];
    if ($request->filled('password')) {
        $user->password = bcrypt($validatedData['password']);
    }
    $user->role_id = $validatedData['role_id'];
    $user->birthday = $validatedData['birthday'];
    $user->license_no = $validatedData['license_no'];

    // Handle profile picture upload
    if ($request->hasFile('profile_picture')) {
        // Delete old picture if exists
        if ($user->profile_picture) {
            $oldPath = public_path('storage/' . $user->profile_picture);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        $file = $request->file('profile_picture');
        $filename = time() . '_' . $file->getClientOriginalName();
        // Store directly in public/storage/profile_pictures
        $file->move(public_path('storage/profile_pictures'), $filename);
        $user->profile_picture = 'profile_pictures/' . $filename;
    }

    $user->save();

    return redirect()->route('reception.users.index')->with('success', 'User updated successfully');
}

public function usersDestroy(User $user)
{
    // Delete profile picture if exists
    if ($user->profile_picture) {
        $path = public_path('storage/' . $user->profile_picture);
        if (file_exists($path)) {
            unlink($path);
        }
    }

    $user->delete();
    return redirect()->route('reception.users.index')->with('success', 'User deleted successfully.');
}

    // Laboratory Services Management


    public function laboratoryServicesIndex(Request $request)
    {
        $query = LaboratoryService::query();

        // Check if there's a search query
        if ($request->has('search')) {
            $searchTerm = $request->get('search');
            $searchBy = $request->get('search_by');

            // Perform search based on selected field
            if ($searchBy === 'service_name') {
                $query->where('service_name', 'like', '%' . $searchTerm . '%');
            } elseif ($searchBy === 'descriptions') {
                $query->where('descriptions', 'like', '%' . $searchTerm . '%');
            } elseif ($searchBy === 'fee') {
                $query->where('fee', 'like', '%' . $searchTerm . '%');
            }
        }

        // Retrieve filtered services with their categories
        $services = $query->with('category')->get();

        return view('reception.laboratory_services.index', compact('services'));
    }

    public function laboratoryServicesCreate()
    {
        $categories = Category::all();
        return view('reception.laboratory_services.create', compact('categories'));
    }

    public function laboratoryServicesStore(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'descriptions' => 'required|string',
            'fee' => 'required|numeric|between:0,999999.99',
            'category_id' => 'required|exists:categories,id',
        ]);

        $service = new LaboratoryService();
        $service->service_name = $request->service_name;
        $service->descriptions = $request->descriptions;
        $service->fee = $request->fee;
        $service->category_id = $request->category_id;

        $service->save();

        return redirect()->route('reception.laboratory_services.index')
            ->with('success', 'Laboratory Service created successfully.');
    }

    public function laboratoryServicesShow($id)
    {
        $laboratoryService = LaboratoryService::findOrFail($id);

        return view('reception.laboratory_services.show', compact('laboratoryService'));
    }

    public function laboratoryServicesEdit( $id)
    {
        $laboratoryService = LaboratoryService::findOrFail($id);
        $categories = Category::all();

        return view('reception.laboratory_services.edit', compact('laboratoryService', 'categories'));
    }


    public function laboratoryServicesUpdate( Request $request, $id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'descriptions' => 'nullable|string',
            'fee' => 'required|numeric|between:0,999999.99',
            'category_id' => 'required|exists:categories,id',
        ]);

        $service = LaboratoryService::findOrFail($id);
        $service->service_name = $request->service_name;
        $service->descriptions = $request->descriptions;
        $service->fee = $request->fee;
        $service->category_id = $request->category_id;

        $service->save();

        return redirect()->route('reception.laboratory_services.index')
            ->with('success', 'Laboratory service updated successfully.');
    }

    public function laboratoryServicesDestroy( $id)
    {
        $laboratoryService = LaboratoryService::findOrFail($id);
        $laboratoryService->delete();

        return redirect()->route('reception.laboratory_services.index')
            ->with('success', 'Laboratory service has been deleted successfully.');
    }

    public function laboratoryServicesGetAmount( $service)
    {
        $service = LaboratoryService::findOrFail($service);
        return response()->json(['data' => ['amount' => $service->fee]]);
    }

    public function categoryStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($request->all());

        return redirect()->back()->with('success', 'Category added successfully.');
    }


    // Patients Management


    public function patientsIndex(Request $request)
    {
        $query = Patient::query();

        // Check if there's a search query
        if ($request->has('search')) {
            $searchTerm = $request->get('search');
            $searchBy = $request->get('search_by');

            // Perform search based on selected field
            switch ($searchBy) {
                case 'first_name':
                    $query->where('first_name', 'like', '%' . $searchTerm . '%');
                    break;
                case 'last_name':
                    $query->where('last_name', 'like', '%' . $searchTerm . '%');
                    break;
                case 'contact_information':
                    $query->where('contact_information', 'like', '%' . $searchTerm . '%');
                    break;
                case 'address':
                    $query->where('address', 'like', '%' . $searchTerm . '%');
                    break;
                case 'email_address':
                    $query->where('email_address', 'like', '%' . $searchTerm . '%');
                    break;
            }
        }

        $patients = $query->get();
        return view('reception.patients.index', compact('patients'));
    }

    public function patientsCreate()
    {
        $vaccineTypes = [
            'Pfizer–BioNTech', 'Oxford–AstraZeneca', 'Sinopharm BIBP', 'Moderna', 'Janssen',
            'CoronaVac', 'Covaxin', 'Novavax', 'Convidecia', 'Sanofi–GSK',
        ];
        $boosterTypes = $vaccineTypes;
        $civilStatusOptions = [
            'single' => 'Single', 'married' => 'Married', 'separated' => 'Separated',
            'divorced' => 'Divorced', 'widowed' => 'Widowed',
        ];
        $patientTypes = [
            ['id' => 1, 'type_name' => 'HMO Walk-In'],
            ['id' => 2, 'type_name' => 'APE Walk-In'],
            ['id' => 3, 'type_name' => 'Walk-In'],
        ];
        return view('reception.patients.create', compact('vaccineTypes', 'boosterTypes', 'civilStatusOptions', 'patientTypes'));
    }

    public function patientsStore(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|max:10',
            'patient_type_id' => 'required|exists:patient_types,id',
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
            'first_dose_date' => 'nullable|date',
            'second_dose_date' => 'nullable|date',
            'booster_type' => 'required|string|max:255',
            'first_booster_date' => 'nullable|date',
            'second_booster_date' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
             // Vital Signs validation (both old and new fields)
             'patient_weight' => 'nullable|numeric|between:0,999.99',
             'patient_height' => 'nullable|numeric|between:0,9.99',
             'patient_bmi' => 'nullable|numeric|between:0,99.99',
             'patient_bp' => ['nullable', 'regex:/^\d{2,3}\/\d{2,3}$/'],
             'patient_heart_rate' => 'nullable|integer|between:0,999',
             'patient_temperature' => 'nullable|numeric|between:25,45',
        ]);

        // Handle profile picture
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/patient_photos', $filename);
            $validatedData['profile_picture'] = 'patient_photos/' . $filename;
        }

        // Handle base64 profile picture from camera
        if ($request->has('camera_profile_picture') && $request->camera_profile_picture) {
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->camera_profile_picture));
            $filename = time() . '_camera.jpg';
            file_put_contents(storage_path('app/public/patient_photos/' . $filename), $image);
            $validatedData['profile_picture'] = 'patient_photos/' . $filename;
        }
        if ($request->has('privacy_consent')) {
            $data['privacy_consent'] = true;
            $data['consent_date'] = now();
        }

        $patient = Patient::create($validatedData);

        return redirect()->route('reception.patients.index')->with('success', 'Patient created successfully.');
    }

    public function patientsShow(Patient $patient)
    {
        $civilStatusOptions = [
            'single' => 'Single', 'married' => 'Married', 'widowed' => 'Widowed',
            'divorced' => 'Divorced', 'separated' => 'Separated',
        ];
        return view('reception.patients.show', compact('patient', 'civilStatusOptions'));
    }

    public function patientsEdit(Patient $patient)
    {
        $vaccineTypes = [
            'Pfizer–BioNTech', 'Oxford–AstraZeneca', 'Sinopharm BIBP', 'Moderna', 'Janssen',
            'CoronaVac', 'Covaxin', 'Novavax', 'Convidecia', 'Sanofi–GSK',
        ];
        $boosterTypes = $vaccineTypes;
        $civilStatusOptions = [
            'single' => 'Single', 'married' => 'Married', 'separated' => 'Separated',
            'divorced' => 'Divorced', 'widowed' => 'Widowed',
        ];
       // Fetch patient types from database instead of hardcoding
    $patientTypes = PatientType::all();
        return view('reception.patients.edit', compact('patient', 'vaccineTypes', 'boosterTypes', 'civilStatusOptions', 'patientTypes'));
    }

    public function patientsUpdate(Request $request, Patient $patient)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
            'patient_type_id' => 'required|exists:patient_types,id',
            'contact_information' => 'required|string|max:255',
            'email_address' => 'required|string|email|max:255|unique:patients,email_address,'.$patient->id,
            'address' => 'required|string|max:255',
            'civil_status' => 'required|in:single,married,separated,divorced,widowed',
            'occupation' => 'required|string|max:255',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_mobile' => 'required|string|max:255',
            'emergency_contact_relation' => 'required|string|max:255',
            'philhealth_number' => 'nullable|string|max:255',
            'pwd_id_number' => 'nullable|string|max:255',
            'senior_citizen_card_number' => 'nullable|string|max:255',
            'vaccine_type' => 'required|string|max:255',
            'first_dose_date' => 'nullable|date',
            'second_dose_date' => 'nullable|date',
            'booster_type' => 'required|string|max:255',
            'first_booster_date' => 'nullable|date',
            'second_booster_date' => 'nullable|date',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
              // Vital Signs validation (both old and new fields)
        'patient_weight' => 'nullable|numeric|between:0,999.99',
        'patient_height' => 'nullable|numeric|between:0,9.99',
        'patient_bmi' => 'nullable|numeric|between:0,99.99',
        'patient_bp' => ['nullable', 'regex:/^\d{2,3}\/\d{2,3}$/'],
        'patient_heart_rate' => 'nullable|integer|between:0,999',
        'patient_temperature' => 'nullable|numeric|between:25,45'
        ]);

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($patient->profile_picture) {
                Storage::delete('public/' . $patient->profile_picture);
            }

            $file = $request->file('profile_picture');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/patient_photos', $filename);
            $validatedData['profile_picture'] = 'patient_photos/' . $filename;
        } else {
            // Keep existing profile picture if no new one is uploaded
            $validatedData['profile_picture'] = $patient->profile_picture;
        }

        // Handle base64 profile picture from camera
        if ($request->has('camera_profile_picture') && $request->camera_profile_picture) {
            // Delete old profile picture if it exists
            if ($patient->profile_picture) {
                Storage::delete('public/' . $patient->profile_picture);
            }

            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $request->camera_profile_picture));
            $filename = time() . '_camera.jpg';
            file_put_contents(storage_path('app/public/patient_photos/' . $filename), $image);
            $validatedData['profile_picture'] = 'patient_photos/' . $filename;
        }

            // Copy old vital signs to new fields for compatibility
        $patient->update($validatedData);

        return redirect()->route('reception.patients.index')->with('success', 'Patient updated successfully.');
    }

    public function patientsDestroy(Patient $patient)
    {
        // Delete profile picture if exists
        if ($patient->profile_picture) {
            Storage::delete('public/' . $patient->profile_picture);
        }

        $patient->delete();
        return redirect()->route('reception.patients.index')->with('success', 'Patient has been deleted successfully.');
    }

    public function showPatientTransactions(Patient $patient)
    {
        $transactions = $patient->transactions()->orderBy('created_at', 'desc')->paginate(10);
        return view('reception.patients.transactions', compact('patient', 'transactions'));
    }

public function searchPatientTransactions(Request $request, $patient_id)
{
    $patient = Patient::findOrFail($patient_id);
    $query = $patient->transactions();

    if ($request->has('start_date') && $request->has('end_date')) {
        $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
    }

    $transactions = $query->orderBy('created_at', 'desc')->paginate(10);
    return view('reception.patients.transactions', compact('patient', 'transactions'));
}



    // Queues Management
    public function queuesIndex()
    {
        $queues = Queue::with(['transaction.patient', 'transaction.services'])
            ->whereIn('status', ['pending', 'in_progress', 'done'])
            ->orderBy('updated_at', 'desc')
            ->get();
        return view('reception.queues.index', compact('queues'));
    }

    // Add this method for starting the process
    public function queuesStartProcess(Queue $queue)
    {
        // Only allow pending queues to move to in_progress
        if ($queue->status === 'pending') {
            $queue->status = 'in_progress';
            $queue->save();
            return redirect()->route('reception.queues.index')
                ->with('success', 'Patient moved to In Progress.');
        }
        return redirect()->back()->with('error', 'Invalid queue status transition.');
    }
    // Add this method for updating service status
    public function queuesUpdateService(Request $request, Queue $queue)
    {
        $request->validate([
            'service_id' => 'required|exists:laboratory_services,id',
            'completed' => 'required|boolean'
        ]);

        // Update service completion status in the pivot table
        $queue->transaction->services()->updateExistingPivot(
            $request->service_id,
            ['completed' => $request->completed]
        );

        return response()->json(['success' => true]);
    }

    // Update your existing markAsDone method to check service completion
    public function queuesMarkAsDone(Queue $queue)
{
    // Only allow in_progress queues to move to done
    if ($queue->status === 'in_progress') {
        $queue->status = 'done';
        $queue->save();

        return redirect()->route('reception.queues.index')
            ->with('success', 'Queue marked as completed.');
    }
    return redirect()->back()->with('error', 'Invalid queue status transition.');
}



public function queuesRelease(Queue $queue)
{
    // Only allow done queues to move to releasing
    if ($queue->status === 'done') {
        // Create releasing record
        Releasing::create([
            'transaction_id' => $queue->transaction_id,
        ]);

        // Optionally, update queue status to releasing
        $queue->status = 'releasing';
        $queue->save();

        return redirect()->route('reception.queues.index')
            ->with('success', 'Queue released for final processing.');
    }
    return redirect()->back()->with('error', 'Invalid queue status transition.');
}
   //Releasing Management
   public function releasingsIndex()
   {
       $releasings = Releasing::with('transaction.patient')->orderBy('created_at', 'desc')->get();
       return view('reception.releasings.index', compact('releasings'));
   }
   public function releasingsDestroy($id)
   {
       try {
           $releasing = Releasing::findOrFail($id);

           // Delete the result file if it exists
           if ($releasing->result_file && Storage::exists($releasing->result_file)) {
               Storage::delete($releasing->result_file);
           }

           // Delete the releasing record
           $releasing->delete();

           return redirect()->route('reception.releasings.index')
               ->with('success', 'Releasing record deleted successfully.');

       } catch (\Exception $e) {
           return redirect()->route('reception.releasings.index')
               ->with('error', 'Error deleting releasing record: ' . $e->getMessage());
       }
   }
   public function releasingsUpload(Request $request, $id)
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

       return redirect()->route('reception.releasings.index')->with('success', 'Result file uploaded successfully.');
   }

   public function releasingsView($id)
   {
       $releasing = Releasing::findOrFail($id);
       $filePath = Storage::path($releasing->result_file);

       return response()->file($filePath);
   }

   public function releasingsSendEmail($id)
{
   try {
       $releasing = Releasing::findOrFail($id);

       // Check if result file exists in database
       if (!$releasing->result_file) {
           Log::error('No result file path stored in database for releasing ID: ' . $id);
           return redirect()->back()->with('error', 'Result file not found in database!');
       }

       // Check if file exists in storage
       if (!Storage::exists($releasing->result_file)) {
           Log::error('File not found in storage: ' . $releasing->result_file);
           return redirect()->back()->with('error', 'Result file not found in storage!');
       }

       // Check if patient has email address
       if (!$releasing->transaction->patient->email_address) {
           Log::error('No email address found for patient in releasing ID: ' . $id);
           $viewLink = route('reception.releasings.view', $releasing->id);
           return redirect()->back()
               ->with('error', 'Patient email address not found! You can view the result <a href="' . $viewLink . '" target="_blank">here</a>.');
       }

       // Attempt to send email
       Mail::to($releasing->transaction->patient->email_address)
           ->send(new MedicalResultsMail($releasing));

       // Update all relevant fields
       $releasing->update([
           'released_at' => now(),
           'released_via_email' => true,
           'releasing_status' => 'released'
       ]);

       Log::info('Email sent successfully for releasing ID: ' . $id);
       return redirect()->back()->with('success', 'Email sent successfully!');

   } catch (\Exception $e) {
       Log::error('Failed to send email for releasing ID ' . $id . ': ' . $e->getMessage());
       Log::error('Stack trace: ' . $e->getTraceAsString());

       $viewLink = route('reception.releasings.view', $releasing->id);
       return redirect()->back()
           ->with('error', $this->getErrorMessage($e));
   }
}

private function getErrorMessage(\Exception $e): string
{
   $baseMessage = 'Unable to send medical results.';

   if (app()->environment('local', 'staging')) {
       return $baseMessage . ' Error: ' . $e->getMessage();
   }

   return $baseMessage . ' Please try again or contact support.';
}



   public function releasingsRelease(Request $request, $id)
   {
       $request->validate([
           'released_via_email' => 'nullable|boolean',
           'released_physical_copy' => 'nullable|boolean',
           'released_at' => 'required|date',
       ]);

       try {
           $releasing = Releasing::findOrFail($id);

           // Update all release-related fields
           $releasing->update([
               'released_at' => $request->released_at,
               'released_via_email' => $request->has('released_via_email'),
               'released_physical_copy' => $request->has('released_physical_copy'),
               'releasing_status' => ($request->has('released_via_email') || $request->has('released_physical_copy')) ? 'released' : 'unreleased'
           ]);

           return redirect()->route('reception.releasings.index')
               ->with('success', 'Release details saved successfully.');

       } catch (\Exception $e) {
           Log::error('Release save error: ' . $e->getMessage());
           return redirect()->route('reception.releasings.index')
               ->with('error', 'Failed to save release details.');
       }

   }



    // Transactions Management
    public function transactionsIndex()
    {
        $transactions = Transaction::orderBy('created_at', 'desc')->paginate(10);
        return view('reception.transactions.index', compact('transactions'));
    }

    public function transactionsCreate()
    {
        $patients = Patient::all();
        $categories = Category::with('services')->get();
        return view('reception.transactions.create', compact('patients', 'categories'));
    }

    public function transactionsStore(Request $request)
    {
        $validatedData = $request->validate([
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

        $transaction = Transaction::create($validatedData);

        $services = $request->input('laboratory_services', []);
        if (!empty($services)) {
            $firstService = LaboratoryService::findOrFail($services[0]);
            $transaction->category_id = $firstService->category_id;
            $transaction->save();
        }

        $transaction->services()->attach($services);

        return redirect()->route('reception.transactions.index')->with('success', 'Transaction created successfully.');
    }

    public function transactionsShow(Transaction $transaction)
    {
        $transaction->load(['consultation', 'patient', 'services', 'queue']);
        return view('reception.transactions.show', compact('transaction'));
    }

    public function transactionsEdit(Transaction $transaction)
    {
        $categories = Category::all();
        $patients = Patient::all();
        return view('reception.transactions.edit', compact('transaction', 'categories', 'patients'));
    }

    public function transactionsUpdate(Request $request, Transaction $transaction)
    {
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

        $transaction->update($validatedData);
        $transaction->services()->sync($validatedData['laboratory_services'] ?? []);

        return redirect()->route('reception.transactions.index')->with('success', 'Transaction updated successfully.');
    }

    public function transactionsDestroy(Transaction $transaction)
    {
        $transaction->delete();
        return redirect()->route('reception.transactions.index')->with('success', 'Transaction deleted successfully.');
    }

    public function transactionsMarkPaid(Transaction $transaction)
    {
        $transaction->payment_status = 'paid';
        $transaction->save();
        return redirect()->route('reception.transactions.index')->with('success', 'Transaction marked as paid, please proceed to Queuing.');
    }

    public function transactionsSearch(Request $request, $patient_id)
    {
        $searchTerm = $request->input('search');
        $patient = Patient::findOrFail($patient_id);
        $transactions = Transaction::where('patient_id', $patient_id)
                                    ->whereHas('services', function ($query) use ($searchTerm) {
                                        $query->where('service_name', 'like', '%'.$searchTerm.'%');
                                    })
                                    ->paginate(10);
        return view('reception.patients.transactions', compact('patient', 'transactions'));
    }


// Consultations Management
public function consultationsIndex()
{
    $consultations = Consultation::with(['patient', 'patient.patientType'])->get();
    return view('reception.consultations.index', compact('consultations'));
}

public function consultationsCreate()
{
    $patients = Patient::select(
        'id',
        'first_name',
        'last_name',
        'date_of_birth',
        'gender',
        'address',
        'civil_status',
        'contact_information',
        'email_address',
        'vaccine_type',
        'booster_type',
        'first_dose_date',
        'second_dose_date',
        'first_booster_date',
        'second_booster_date',
        'patient_type_id'  // Added patient_type_id
    )->with('patientType')->get();  // Eager load patient type

    return view('reception.consultations.create', compact('patients'));
}

public function consultationsStore(Request $request)
{
    // Create the base consultation data
    $consultationData = [
        'patient_id' => $request->patient_id,
        'date' => now(),
        'symptoms' => $request->symptoms,
        // Updated to use actual request values instead of empty strings
        'diagnoses' => $request->diagnoses,
        'treatment_plan' => $request->treatment_plan,
        'prescription' => $request->prescription,
        'physician_name' => $request->physician_name ?? auth()->user()->name,
        'license_no' => $request->license_no ?? auth()->user()->license_no,
        'history_of_present_illness' => $request->history_of_present_illness,
        'status' => 'pending',


        // Rest of the fields remain the same...
        'has_hpn' => $request->has('has_hpn') ? 1 : 0,
        'has_dm' => $request->has('has_dm') ? 1 : 0,
        'has_ba' => $request->has('has_ba') ? 1 : 0,
        'other_medical_history' => $request->other_medical_history,
        'medications' => $request->medications,

        // Allergy information
        'has_food_allergy' => !empty($request->food_drug_allergy),
        'food_drug_allergy' => $request->food_drug_allergy,

        // Surgery and hospitalization
        'has_surgery' => !empty($request->surgery_history),
        'surgery_history' => $request->surgery_history,
        'has_hospitalization' => !empty($request->hospitalization),

        // Employment and work history
        'employment_history' => json_encode([
            'company' => $request->input('employment_history.company', []),
            'tenure' => $request->input('employment_history.tenure', []),
            'position' => $request->input('employment_history.position', []),
            'hazard' => $request->input('employment_history.hazard', [])
        ]),
        'work_related_injury' => $request->work_related_injury,

        // Smoking and alcohol history
        'is_smoker' => !empty($request->cigarette_sticks_per_day),
        'cigarette_sticks_per_day' => $request->cigarette_sticks_per_day,
        'cigarette_years' => $request->cigarette_years,
        'is_alcoholic' => !empty($request->alcohol_history),
        'alcohol_history' => $request->alcohol_history,

        // Review of systems
        'ros' => json_encode($request->input('ros', [])),

        // Physical examination
        'physical_examination' => $request->physical_examination,
        'weight' => $request->weight,
        'height' => $request->height,
        'bmi' => $request->bmi,
        'bp' => $request->bp,
        'hr' => $request->hr,
        'temp' => $request->temp,

        // Physical examination findings
        'heent_status' => $request->heent_status ?? 'normal',
        'heent' => $request->heent,
        'neck_status' => $request->neck_status ?? 'normal',
        'neck' => $request->neck,
        'chest_and_lungs_status' => $request->chest_and_lungs_status ?? 'normal',
        'chest_and_lungs' => $request->chest_and_lungs,
        'heart_status' => $request->heart_status ?? 'normal',
        'heart' => $request->heart,
        'abdomen_status' => $request->abdomen_status ?? 'normal',
        'abdomen' => $request->abdomen,
        'extremities_status' => $request->extremities_status ?? 'normal',
        'extremities' => $request->extremities,

    ];

    // Create the consultation record
    $consultation = Consultation::create($consultationData);

    return redirect()->route('reception.consultations.index')
        ->with('success', 'Consultation created successfully.');
}

public function consultationsShow($id)
{
    $consultation = Consultation::with(['patient', 'patient.patientType'])->findOrFail($id);
    return view('reception.consultations.show', compact('consultation'));
}

public function consultationsEdit($id)
{
    $consultation = Consultation::with(['patient', 'patient.patientType'])->findOrFail($id);
    $patients = Patient::with('patientType')->get();
    return view('reception.consultations.edit', compact('consultation', 'patients'));
}

public function consultationsUpdate(Request $request, $id)
{
    $consultation = Consultation::findOrFail($id);

    // Validate basic fields
    $validatedData = $request->validate([
        'symptoms' => 'nullable|string',
        'diagnoses' => 'nullable|string',
        'treatment_plan' => 'nullable|string',
        'prescription' => 'nullable|string',
        'history_of_present_illness' => 'nullable|string',
        'physical_examination' => 'nullable|string',
        'weight' => 'nullable|numeric|between:0,999.99',
        'height' => 'nullable|numeric|between:0,9.99',
        'bmi' => 'nullable|numeric|between:0,99.99',
        'bp' => ['nullable', 'regex:/^\d{2,3}\/\d{2,3}$/'],
        'hr' => 'nullable|integer|between:0,999',
        'temp' => 'nullable|numeric|between:25,45',


        // Added new fields
        'vaccination_history' => 'nullable|string',
        'covid_vaccine_doses' => 'nullable|string',
    ]);

    // Medical history flags
    $validatedData['has_hpn'] = $request->has('has_hpn') ? 1 : 0;
    $validatedData['has_dm'] = $request->has('has_dm') ? 1 : 0;
    $validatedData['has_ba'] = $request->has('has_ba') ? 1 : 0;
    $validatedData['has_booster'] = $request->has('has_booster') ? 1 : 0;

    // Other medical details
    $validatedData['other_medical_history'] = $request->input('other_medical_history');
    $validatedData['medications'] = $request->input('medications');

    // Allergy information
    $validatedData['food_drug_allergy'] = $request->input('food_drug_allergy');
    $validatedData['has_food_allergy'] = !empty($request->input('food_drug_allergy'));

    // Surgery and hospitalization
    $validatedData['surgery_history'] = $request->input('surgery_history');
    $validatedData['has_surgery'] = !empty($request->input('surgery_history'));
    $validatedData['has_hospitalization'] = !empty($request->input('hospitalization'));

    // Employment history
    $validatedData['employment_history'] = json_encode([
        'company' => $request->input('employment_history.company', []),
        'tenure' => $request->input('employment_history.tenure', []),
        'position' => $request->input('employment_history.position', []),
        'hazard' => $request->input('employment_history.hazard', [])
    ]);
    $validatedData['work_related_injury'] = $request->input('work_related_injury');

    // Smoking and alcohol history
    $validatedData['is_smoker'] = !empty($request->input('cigarette_sticks_per_day'));
    $validatedData['cigarette_sticks_per_day'] = $request->input('cigarette_sticks_per_day');
    $validatedData['cigarette_years'] = $request->input('cigarette_years');
    $validatedData['is_alcoholic'] = !empty($request->input('alcohol_history'));
    $validatedData['alcohol_history'] = $request->input('alcohol_history');

    // Review of systems
    $validatedData['ros'] = json_encode($request->input('ros', []));

    // Physical examination status and findings
    $physicalExamFields = [
        'heent', 'neck', 'chest_and_lungs', 'heart',
        'abdomen', 'extremities'
    ];

    foreach ($physicalExamFields as $field) {
        $validatedData[$field] = $request->input($field);
        $validatedData[$field . '_status'] = $request->input($field . '_status', 'normal');
    }

    // Update the consultation
    $consultation->update($validatedData);

    return redirect()->route('reception.consultations.index')
        ->with('success', 'Consultation updated successfully.');
}

public function consultationsDestroy($id)
{
    $consultation = Consultation::findOrFail($id);
    $consultation->delete();

    return redirect()->route('reception.consultations.index')->with('success', 'Consultation deleted successfully.');
}
public function queuesDisplay()
{
    $queues = Queue::all(); // Adjust this query as needed
    return view('reception.queues.queue_display', compact('queues'));
}


public function consultationsForward($id)
{
    $consultation = Consultation::findOrFail($id);

    // Create transaction with comprehensive consultation details
    $transaction = new Transaction([
        // Patient and Basic Information
        'patient_id' => $consultation->patient_id,
        'date' => $consultation->date,
        'consultation_id' => $consultation->id,

        // Consultation Core Details
        'symptoms' => $consultation->symptoms,
        'diagnoses' => $consultation->diagnoses,
        'treatment_plan' => $consultation->treatment_plan,
        'physician' => $consultation->physician_name,

        // Medical History
        'medication_past_30_days' => $consultation->medications,

        // Physical Examination Details
        'last_meal' => null, // You might want to add this field if needed
        'radiologic_technologist' => null,

        // Drug Test and Sample Related Fields (added from create blade)
        'drug_test_purpose' => null,
        'other_purpose_specify' => null,
        'medication_past_30_days' => $consultation->medications,
        'alcohol_past_24_hours' => null,
        'sample_type' => null,
        'confirmatory_testing_agreement' => null,
        'sample_acknowledgement' => null,

        // Payment Information
        'total_payments' => 0,
        'payment_status' => 'unpaid',
        'discount_id' => null
    ]);

    // Save the transaction
    $transaction->save();

    // Update consultation status
    $consultation->status = 'forwarded';
    $consultation->save();

    return redirect()->route('reception.consultations.index')
        ->with('success', 'Consultation successfully forwarded to Reception.');
}
    public function queuesShowTransaction(Transaction $transaction)
    {
        return view('reception.queues.show_from_queue', compact('transaction'));
    }
}


