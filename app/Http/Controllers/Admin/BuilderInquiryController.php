<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\BuilderInquiry;
use Illuminate\Support\Facades\Validator;

class BuilderInquiryController extends Controller
{
    public function index()
    {
        $page_title = 'Customer Inquiries (Build)';
        return view('admin.builder_inquiry.list', compact('page_title'));
    }

    public function getRecords(Request $request)
    {
        $query = BuilderInquiry::with(['builder', 'customer'])->orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('customer_name', function ($row) {
                return '<strong><i class="fas fa-user me-1 text-primary"></i>' . e($row->customer_name) . '</strong><br><small class="text-muted"><i class="fas fa-phone-alt me-1 text-success"></i> ' . e($row->customer_phone) . '</small>';
            })
            ->editColumn('builder', function ($row) {
                return $row->builder ? '<i class="fas fa-building me-1 text-info"></i>' . e($row->builder->firm_name . ' (' . $row->builder->name . ')') : 'N/A';
            })
            ->editColumn('inquiry_type', function ($row) {
                $badges = [
                    'call' => '<span class="badge bg-success"><i class="fas fa-phone me-1"></i> Call Request</span>',
                    'chat' => '<span class="badge bg-primary"><i class="fas fa-comments me-1"></i> Chat Request</span>',
                    'general' => '<span class="badge bg-info"><i class="fas fa-info-circle me-1"></i> General Inquiry</span>',
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
            ->rawColumns(['customer_name', 'inquiry_type', 'status', 'action'])
            ->make(true);
    }

    public function updateStatus(Request $request)
    {
        $inquiry = BuilderInquiry::find($request->id);
        if ($inquiry) {
            $inquiry->status = $request->status;
            $inquiry->save();
            return response()->json(['status' => true, 'message' => 'Inquiry status updated successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Inquiry not found'], 404);
    }
}
