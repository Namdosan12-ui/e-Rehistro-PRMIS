<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\LaboratoryService;
use App\Models\Transaction;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $patientCount = Patient::count();
        $laboratoryServiceCount = LaboratoryService::count();
        $transactionCount = Transaction::count();

        // Convert numeric months to month names for patients
        $monthlyPatients = Patient::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->get()
            ->map(function ($item) {
                // Use Carbon to format month correctly
                $item->month = Carbon::createFromDate($item->year, $item->month, 1)->format('F');
                return $item;
            });

        // Convert numeric months to month names for revenue
        $monthlyRevenue = Transaction::selectRaw('YEAR(date) as year, MONTH(date) as month, SUM(total_payments) as revenue')
            ->groupBy('year', 'month')
            ->get()
            ->map(function ($item) {
                // Use Carbon to format month correctly
                $item->month = Carbon::createFromDate($item->year, $item->month, 1)->format('F');
                return $item;
            });

        $topLaboratoryServices = LaboratoryService::withCount('transactions')
            ->orderBy('transactions_count', 'desc')
            ->take(5)
            ->get();

        return view('dashboard.index', compact('patientCount', 'laboratoryServiceCount', 'transactionCount', 'monthlyPatients', 'monthlyRevenue', 'topLaboratoryServices'));
    }
}
