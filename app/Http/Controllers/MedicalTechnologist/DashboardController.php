<?php
namespace App\Http\Controllers\MedicalTechnologist;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function show()
    {
        return view('MedicalTechnologist.dashboard'); // Ensure you have this view file
    }
}
