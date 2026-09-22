<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomerSurvey;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $page_title = 'Dashboard';
        $vendor = Auth::guard('vendor')->user();
        
        $totalSurveys = CustomerSurvey::where('vendor_id', $vendor->id)->count();
        $todaySurveys = CustomerSurvey::where('vendor_id', $vendor->id)->whereDate('survey_date', Carbon::today())->count();
        $totalCompletedSurveys = CustomerSurvey::where('vendor_id', $vendor->id)->where('status', 'Completed')->count();
        $totalOngoingSurveys = CustomerSurvey::where('vendor_id', $vendor->id)->where('status', 'Ongoing')->count();

        $latestOngoingSurveys = CustomerSurvey::with('customer')
            ->where('vendor_id', $vendor->id)
            ->where('status', 'Ongoing')
            ->latest('assigned_at')
            ->take(5)
            ->get();

        $latestCompletedSurveys = CustomerSurvey::with('customer')
            ->where('vendor_id', $vendor->id)
            ->where('status', 'Completed')
            ->latest('assigned_at')
            ->take(5)
            ->get();

        return view('vendor.dashboard.dashboard', compact(
            'page_title', 
            'vendor',
            'totalSurveys',
            'todaySurveys',
            'totalCompletedSurveys',
            'totalOngoingSurveys',
            'latestOngoingSurveys',
            'latestCompletedSurveys'
        ));
    }
}
