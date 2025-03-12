<?php
namespace App\Http\Controllers\Reception;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function show()
    {
        return view('Reception.dashboard'); // Ensure you have this view file
    }
}
