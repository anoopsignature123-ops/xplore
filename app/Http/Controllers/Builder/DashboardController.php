<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\BuilderInquiry;
use App\Models\BuilderPortfolio;
use App\Models\BuilderCompletedProject;

class DashboardController extends Controller
{
    public function index()
    {
        $builder = Auth::guard('builder')->user();

        $totalInquiries = BuilderInquiry::where('builder_id', $builder->id)->count();
        $pendingInquiries = BuilderInquiry::where('builder_id', $builder->id)->where('status', 'pending')->count();
        $totalPortfolios = BuilderPortfolio::where('builder_id', $builder->id)->count();
        $totalProjects = BuilderCompletedProject::where('builder_id', $builder->id)->count();

        $recentInquiries = BuilderInquiry::where('builder_id', $builder->id)->orderByDesc('id')->take(5)->get();

        $page_title = 'Builder Dashboard';

        return view('builder.dashboard', compact('builder', 'totalInquiries', 'pendingInquiries', 'totalPortfolios', 'totalProjects', 'recentInquiries', 'page_title'));
    }
}
