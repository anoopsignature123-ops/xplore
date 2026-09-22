<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Customer;
use App\Models\Vendor;
use App\Models\Survey;
use App\Models\CustomerSurvey;

class CustomerSurveyController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Customer Survey List';
        $user_id = $request->user_id;
        $id = $request->id;
        $customer_list = Customer::select('id', 'name', 'phone_no')->get();
        $survey_list = Survey::select('id', 'name')->get();
        $vendor_list = Vendor::select('id', 'name', 'email_id')->get();
        return view('admin.customer-survey.list', compact('page_title', 'user_id', 'id', 'customer_list', 'survey_list', 'vendor_list'));
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {

            $query = CustomerSurvey::with(['customer', 'vendor'])->select('customer_surveys.*')->orderBy('id', 'desc');

 
            // Filter by Customer (id)
            if ($request->filled('customer_id')) {
                $query->where('customer_id', $request->customer_id);
            }

            if ($request->filled('id')) {
                $query->where('id', $request->id);
            }

            // Filter by Status
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            // Filter by Payment Status
            if ($request->filled('payment_status')) {
                $query->where('payment_status', $request->payment_status);
            }

            // Filter by Survey
            if ($request->filled('survey_id')) {
                $query->where('survey_id', $request->survey_id);
            }

            // Filter by Date Range
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('survey_date', [$request->from_date, $request->to_date]);
            } elseif ($request->filled('from_date')) {
                $query->whereDate('survey_date', '>=', $request->from_date);
            } elseif ($request->filled('to_date')) {
                $query->whereDate('survey_date', '<=', $request->to_date);
            }

            // Filter by Latitude
            if ($request->filled('latitude')) {
                $query->where('latitude', 'like', '%' . $request->latitude . '%');
            }

            // Filter by Longitude
            if ($request->filled('longitude')) {
                $query->where('longitude', 'like', '%' . $request->longitude . '%');
            }

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



                ->addColumn('survey_details', function ($row) {
                    $name = $row->survey_name ?? 'N/A';
                    $date = $row->survey_date ? \Carbon\Carbon::parse($row->survey_date)->format('d M Y') : 'N/A';
                    $time = $row->survey_time ? \Carbon\Carbon::parse($row->survey_time)->format('h:i A') : 'N/A';
                    return "<div><strong>{$name}</strong></div><div><small class='text-muted'><i class='fa-regular fa-calendar'></i> {$date} | <i class='fa-regular fa-clock'></i> {$time}</small></div>";
                })

                ->editColumn('amount', function ($row) {
                    $amount = $row->amount ? number_format($row->amount, 2) : '0.00';
                    return "<strong class='text-success'><i class='fa-solid fa-indian-rupee-sign'></i> {$amount}</strong>";
                })

                ->addColumn('location_details', function ($row) {
                    $lat = $row->latitude ?? 'N/A';
                    $long = $row->longitude ?? 'N/A';
                    $address = $row->address ?? 'N/A';
                    return "<div><small class='text-muted'><i class='fa-solid fa-location-dot'></i> {$address}</small></div>
                            <div><small class='text-muted'>Lat: {$lat}, Long: {$long}</small></div>";
                })

                ->editColumn('status', function ($row) {
                    $status = $row->status ?? 'Pending';
                    $color = match ($status) {
                        'Active', 'Completed', 'Approved' => 'success',
                        'Ongoing' => 'info',
                        'Inactive', 'Rejected', 'Cancelled' => 'danger',
                        'Pending' => 'warning',
                        default => 'secondary',
                    };
                    return '<span class="badge bg-' . $color . '">' . $status . '</span>';
                })

                ->editColumn('payment_status', function ($row) {
                    $payment_status = $row->payment_status ?? 'pending';
                    $class = strtolower($payment_status) === 'success' ? 'success' : (strtolower($payment_status) === 'pending' ? 'warning' : 'danger');
                    return '<span class="badge bg-' . $class . '">' . ucfirst($payment_status) . '</span>';
                })
                
                ->addColumn('action', function ($row) {
                    if ($row->status === 'Ongoing' || $row->vendor_id) {
                        $vendorName = $row->vendor->name ?? 'N/A';
                        $vendorEmail = $row->vendor->email_id ?? 'N/A';
                        $assignedAt = $row->assigned_at ? \Carbon\Carbon::parse($row->assigned_at)->format('d M Y | h:i A') : 'N/A';
                        $html = "<div class='text-start'>
                                    <div><strong><i class='fa-solid fa-user-tie text-primary'></i> {$vendorName}</strong></div>
                                    <div><small class='text-muted'><i class='fa-solid fa-envelope'></i> {$vendorEmail}</small></div>
                                    <div><small class='text-info'><i class='fa-solid fa-clock'></i> {$assignedAt}</small></div>";
                        
                        if (!empty($row->completed_at)) {
                            $completedAt = \Carbon\Carbon::parse($row->completed_at)->format('d M Y | h:i A');
                            $html .= "<div><small class='text-success fw-bold'><i class='fa-solid fa-check-circle'></i> {$completedAt}</small></div>";
                        }
 
                        $html .= "</div>";
                        return $html;
                    }


                    $date = $row->survey_date ? \Carbon\Carbon::parse($row->survey_date)->format('d M Y') : 'N/A';
                    $time = $row->survey_time ? \Carbon\Carbon::parse($row->survey_time)->format('h:i A') : 'N/A';
                    
                    return '<button type="button" class="btn btn-primary btn-sm btn-assign" 
                                data-id="'.$row->id.'"
                                data-cname="'.($row->customer->name ?? 'N/A').'"
                                data-cphone="'.($row->customer->phone_no ?? 'N/A').'"
                                data-sname="'.($row->survey_name ?? 'N/A').'"
                                data-sdate="'.$date.'"
                                data-stime="'.$time.'"
                                data-amt="'.($row->amount ?? '0').'"
                                data-addr="'.($row->address ?? 'N/A').'"
                                data-lat="'.($row->latitude ?? 'N/A').'"
                                data-lng="'.($row->longitude ?? 'N/A').'"
                            >
                                <i class="fa-solid fa-user-check"></i> Assign
                            </button>';
                })

                ->rawColumns(['status', 'payment_status', 'customer_details', 'survey_details', 'amount', 'location_details', 'action'])
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function assignVendor(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:customer_surveys,id',
            'vendor_id' => 'required|exists:vendors,id'
        ]);

        $survey = CustomerSurvey::find($request->id);
        $survey->vendor_id = $request->vendor_id;
        $survey->status = 'Ongoing';
        $survey->assigned_at = now();
        $survey->save();

        return response()->json(['status' => true, 'message' => 'Vendor assigned successfully']);
    }
}