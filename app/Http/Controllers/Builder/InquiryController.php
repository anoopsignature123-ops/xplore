<?php

namespace App\Http\Controllers\Builder;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Models\BuilderInquiry;

class InquiryController extends Controller
{
    public function index()
    {
        $page_title = 'Customer Inquiries';
        return view('builder.inquiry.list', compact('page_title'));
    }

    public function getRecords(Request $request)
    {
        $builder = Auth::guard('builder')->user();
        $query = BuilderInquiry::where('builder_id', $builder->id)->orderByDesc('id');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('customer_name', function ($row) {
                return '<strong><i class="fas fa-user me-1 text-primary"></i>' . e($row->customer_name) . '</strong>';
            })
            ->editColumn('customer_phone', function ($row) {
                return '<i class="fas fa-phone-alt me-1 text-success"></i><a href="tel:' . e($row->customer_phone) . '" class="text-primary fw-bold">' . e($row->customer_phone) . '</a>';
            })
            ->editColumn('inquiry_type', function ($row) {
                $badges = [
                    'call' => '<span class="badge bg-success"><i class="fas fa-phone me-1"></i> Call</span>',
                    'chat' => '<span class="badge bg-primary"><i class="fas fa-comments me-1"></i> Chat</span>',
                    'general' => '<span class="badge bg-info"><i class="fas fa-info-circle me-1"></i> General</span>',
                ];
                return $badges[$row->inquiry_type] ?? $row->inquiry_type;
            })
            ->editColumn('status', function ($row) {
                $statusBadges = [
                    'pending'   => '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Pending</span>',
                    'contacted' => '<span class="badge bg-info"><i class="fas fa-check me-1"></i> Contacted</span>',
                    'closed'    => '<span class="badge bg-success"><i class="fas fa-lock me-1"></i> Closed</span>',
                ];
                return $statusBadges[$row->status] ?? $row->status;
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('d M Y, h:i A') : 'N/A';
            })
            ->addColumn('action', function ($row) {
                return '
                    <select class="form-select form-select-sm status-select" data-id="' . $row->id . '" style="width: auto; display: inline-block;">
                        <option value="pending" ' . ($row->status == 'pending' ? 'selected' : '') . '>Pending</option>
                        <option value="contacted" ' . ($row->status == 'contacted' ? 'selected' : '') . '>Contacted</option>
                        <option value="closed" ' . ($row->status == 'closed' ? 'selected' : '') . '>Closed</option>
                    </select>
                ';
            })
            ->rawColumns(['customer_name', 'customer_phone', 'inquiry_type', 'status', 'action'])
            ->make(true);
    }

    public function updateStatus(Request $request)
    {
        $builder = Auth::guard('builder')->user();
        $inquiry = BuilderInquiry::where('builder_id', $builder->id)->where('id', $request->id)->first();
        if ($inquiry) {
            $inquiry->status = $request->status;
            $inquiry->save();
            return response()->json(['status' => true, 'message' => 'Status updated successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Inquiry not found'], 404);
    }
}
