<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\CustomerSurvey;
use Illuminate\Support\Facades\Auth;

class MySurveyController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'My Surveys';
        $vendor_id = Auth::guard('vendor')->user()->id;

        $customers = CustomerSurvey::where('vendor_id', $vendor_id)
            ->with('customer')
            ->get()
            ->pluck('customer')
            ->unique('id')
            ->filter();

        $statuses = CustomerSurvey::where('vendor_id', $vendor_id)->select('status')->distinct()->pluck('status')->filter();
        $surveys = CustomerSurvey::where('vendor_id', $vendor_id)->select('survey_name')->distinct()->pluck('survey_name')->filter();
        
        $status_filter = $request->query('status');
        $date_filter = $request->query('date');

        return view('vendor.my-survey.list', compact('page_title', 'customers', 'statuses', 'surveys', 'status_filter', 'date_filter'));
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {

            $vendor_id = Auth::guard('vendor')->user()->id;

            $query = CustomerSurvey::with('customer')->where('vendor_id', $vendor_id)->orderBy('assigned_at', 'desc');

            // Filter by Date Range
            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('survey_date', [$request->from_date, $request->to_date]);
            } elseif ($request->filled('from_date')) {
                $query->whereDate('survey_date', '>=', $request->from_date);
            } elseif ($request->filled('to_date')) {
                $query->whereDate('survey_date', '<=', $request->to_date);
            }

            if ($request->filled('customer_id')) {
                $query->where('customer_id', $request->customer_id);
            }
            if ($request->filled('survey_name')) {
                $query->where('survey_name', $request->survey_name);
            }
            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            return DataTables::of($query)
                ->addIndexColumn() 

                ->addColumn('assigned_date', function ($row) {
                    $assigned = $row->assigned_at ? \Carbon\Carbon::parse($row->assigned_at)->format('d M Y | h:i A') : 'N/A';
                    $html = "<div><small class='text-muted'>Assigned At</small><br><strong>{$assigned}</strong></div>";
                    if (!empty($row->completed_at)) {
                        $completed = \Carbon\Carbon::parse($row->completed_at)->format('d M Y | h:i A');
                        $html .= "<div class='mt-2'><small class='text-muted'>Completed At</small><br><strong class='text-success'>{$completed}</strong></div>";
                    }
                    return $html;
                })

                ->addColumn('customer_details', function ($row) {
                    $name = $row->customer->name ?? 'N/A';
                    $phone = $row->customer->phone_no ?? 'N/A';
                    
                    $fallbackImg = 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&background=random';
                    $image = $row->customer->profile_image 
                            ? asset($row->customer->profile_image) 
                            : $fallbackImg;

                    return '<div class="d-flex align-items-center gap-3">
                                <img src="' . $image . '" alt="' . $name . '" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <strong class="text-primary">' . $name . '</strong>
                                    <div><small><i class="fa-solid fa-phone text-muted"></i> ' . $phone . '</small></div>
                                </div>
                            </div>';
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
                    return '<span class="badge bg-' . $color . ' rounded-pill px-3 py-2">' . $status . '</span>';
                })

                ->addColumn('action', function ($row) {
                        return '<a href="'.route('vendor.my-survey.chat', $row->id).'" class="btn btn-sm btn-info text-white rounded-pill px-3"><i class="fa-regular fa-comments"></i> Chat</a>';
                    return '';
                })

                ->rawColumns(['assigned_date', 'status', 'customer_details', 'survey_details', 'amount', 'location_details', 'action'])
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function chatPage($id)
    {
        $vendor_id = Auth::guard('vendor')->user()->id;
        $survey = CustomerSurvey::with('customer')->where('id', $id)->where('vendor_id', $vendor_id)->firstOrFail();
        
        $page_title = 'Chat - ' . ($survey->customer->name ?? 'Customer');
        return view('vendor.my-survey.chat', compact('page_title', 'survey'));
    }

    public function getChatHistory($id)
    {
        $vendor_id = Auth::guard('vendor')->user()->id;
        $survey = CustomerSurvey::where('id', $id)->where('vendor_id', $vendor_id)->first();
        
        if (!$survey) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $chatService = new \App\Services\ChatService();
        $chats = $chatService->getChatHistory($id);

        return response()->json([
            'status' => true,
            'data' => $chats->map(function ($chat) {
                return [
                    'id' => $chat->id,
                    'sender_type' => $chat->sender_type,
                    'message' => $chat->message,
                    'attachment_url' => $chat->attachment_path ? asset($chat->attachment_path) : null,
                    'attachment_type' => $chat->attachment_type,
                    'created_at' => $chat->created_at->format('M d, Y h:i A'),
                    'is_me' => $chat->sender_type === 'vendor'
                ];
            })
        ]);
    }

    public function sendChatMessage(Request $request, $id)
    {
        $vendor_id = Auth::guard('vendor')->user()->id; 
        $survey = CustomerSurvey::where('id', $id)->where('vendor_id', $vendor_id)->first();
        
        if (!$survey) {
            return response()->json(['status' => false, 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'message' => 'nullable|string',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,pdf|max:10240',
        ]);

        if (!$request->filled('message') && !$request->hasFile('file')) {
            return response()->json(['status' => false, 'message' => 'Message or file is required.'], 422);
        }

        $chatService = new \App\Services\ChatService();
        $chat = $chatService->sendMessage($id, 'vendor', $vendor_id, $request->message, $request->file('file'));

        return response()->json([
            'status' => true,
            'data' => [
                'id' => $chat->id,
                'sender_type' => $chat->sender_type,
                'message' => $chat->message,
                'attachment_url' => $chat->attachment_path ? asset($chat->attachment_path) : null,
                'attachment_type' => $chat->attachment_type,
                'created_at' => $chat->created_at->format('M d, Y h:i A'),
                'is_me' => true
            ]
        ]);
    }
}
