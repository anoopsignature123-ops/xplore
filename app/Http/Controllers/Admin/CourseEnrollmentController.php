<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use Yajra\DataTables\DataTables;
use App\Models\CourseEnrollment;
use App\Models\Customer;
use App\Models\Course;
use App\Models\CourseCategory;

class CourseEnrollmentController extends Controller {

    public function index(Request $request) {
         $page_title = 'Course Enrollment List';
         $user_id = $request->user_id;
         $id = $request->id;
         $customers = Customer::select('id', 'name', 'phone_no')->orderBy('name', 'asc')->get();
         $courses = Course::select('id', 'course_name')->orderBy('course_name', 'asc')->get();
         $categories = CourseCategory::select('id', 'name')->orderBy('name', 'asc')->get();
         return view('admin.course-enrollment.list', compact('page_title', 'user_id', 'id', 'customers', 'courses', 'categories'));
    }

    public function getRecords(Request $request) 
    {
        if ($request->ajax()) {     
            $query = CourseEnrollment::with('customer')->select([
                'id',
                'customer_id',
                'course_id',
                'course_name',
                'course_category_name',
                'duration',
                'status',
                'payment_status',
                'amount',
                'created_at'
            ]);
            
            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }
            
            // Filter by Customer
            if ($request->filled('customer_id')) {
                $query->where('customer_id', $request->customer_id);
            }
            if ($request->filled('id')) {
                $query->where('id', $request->id);
            }
            // Optional fallback if frontend sends customer instead of customer_id
            if ($request->filled('customer')) {
                $customerName = $request->customer;
                $query->whereHas('customer', function($q) use ($customerName) {
                    $q->where('name', 'like', '%' . $customerName . '%');
                });
            }

            // Filter by course_name
            if ($request->filled('course_name')) {
                $query->where('course_name', 'like', '%' . $request->course_name . '%');
            }

            // Filter by course_category_name
            if ($request->filled('course_category_name')) {
                $query->where('course_category_name', 'like', '%' . $request->course_category_name . '%');
            }

            // Filter by date range (created_at)
            if ($request->filled('date_from')) {
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if ($request->filled('date_to')) {
                $query->whereDate('created_at', '<=', $request->date_to);
            }
 
            $query->orderBy('id', 'desc');

            return DataTables::of($query) 
                ->addIndexColumn()
                ->addColumn('customer_details', function ($row) {
                    if ($row->customer) {
                        $img = !empty($row->customer->profile_image) ? asset($row->customer->profile_image) : asset('assets/images/default-user.png');
                        return '
                            <div class="d-flex align-items-center">
                                <img src="'.$img.'" alt="Profile" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
                                <div>
                                    <strong>'.$row->customer->name.'</strong><br>
                                    <small>'.$row->customer->email_id.'</small><br>
                                    <small>'.$row->customer->phone_no.'</small>
                                </div>
                            </div>
                        ';
                    }
                    return 'N/A';
                })
                ->editColumn('amount', function($row){
                    return '₹' . number_format($row->amount, 2);
                })
                ->editColumn('created_at', function($row){
                    return $row->created_at ? $row->created_at->format('d M Y, h:i A') : 'N/A';
                })
                ->editColumn('payment_status', function($row){
                    $class = strtolower($row->payment_status) === 'success' ? 'success' : (strtolower($row->payment_status) === 'pending' ? 'warning' : 'danger');
                    return '<span class="badge bg-' . $class . '">' . $row->payment_status . '</span>';
                })
                ->editColumn('status', function($row){
                    $class = strtolower($row->status) === 'active' ? 'success' : (strtolower($row->status) === 'completed' ? 'info' : 'warning');
                    return '<span class="badge bg-' . $class . '">' . $row->status . '</span>';
                })
                ->rawColumns(['customer_details', 'payment_status', 'status'])
                ->make(true);
        }
    } 
}
