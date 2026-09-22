<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\ProductOrder;
use App\Models\Transaction;
use App\Models\CustomerSurvey;
use App\Models\CourseEnrollment;
use App\Models\HelpQuery;
use App\Models\User;
use App\Models\Order;

class Dashboard extends Controller
{
    public function index()
    {
        $data = [
            'totalCustomer'            => Customer::count(),
            'totalVendor'              => Vendor::count(),
            'totalProduct'             => Product::count(),
            'pendingOrders'            => ProductOrder::where('order_status', 'pending')->count(),
            'totalProductSuccessOrder' => ProductOrder::where('order_status', 'delivered')->count(),
            'totalTransaction'         => Transaction::count(),
            'transactionSuccessAmount' => Transaction::where('status', 'success')->sum('amount'),
            'transactionPendingAmount' => Transaction::where('status', 'pending')->sum('amount'),
            'totalCustomerSurvey'      => CustomerSurvey::count(),
            'totalCourseEnrollments'   => CourseEnrollment::count(),
            'totalHelpQueries'         => HelpQuery::count(),
            'totalSystemUsers'         => User::count(),
            'latestCourseEnrollments'  => CourseEnrollment::with('customer')->latest()->take(5)->get(),
            'latestCustomerSurveys'    => CustomerSurvey::with('customer')->latest()->take(5)->get(),
            'latestProductOrders'      => ProductOrder::with('user')->latest()->take(5)->get(),
            'latestTransactions'       => Transaction::with('customer')->latest()->take(5)->get(),
            'latestGatewayOrders'      => Order::with('customer')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard.dashboard', $data);
    }
}