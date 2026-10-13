<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\BuildServiceBooking;

class BuildServiceBookingController extends Controller
{
    public function index()
    {
        $page_title = 'Build Service Bookings';
        return view('admin.build_service_booking.list', compact('page_title'));
    }

    public function getRecords(Request $request)
    {
        $query = BuildServiceBooking::with('service')->orderByDesc('id');

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('service', function ($row) {
                return $row->service ? '<strong style="color:#1e293b;">' . e($row->service->title) . '</strong>' : '—';
            })
            ->editColumn('customer_name', function ($row) {
                return '<strong>' . e($row->customer_name ?? '—') . '</strong><br><small class="text-muted">' . e($row->contact_mobile) . '</small>';
            })
            ->editColumn('site_location', function ($row) {
                return '<small>' . e($row->site_location) . '</small>';
            })
            ->editColumn('budget_range', function ($row) {
                return '<span class="badge bg-info-subtle text-info">' . e($row->budget_range ?? '—') . '</span>'
                    . '<br><small class="text-muted">' . e($row->target_timeline ?? '') . '</small>';
            })
            ->editColumn('status', function ($row) {
                $colors = [
                    'pending'     => 'warning',
                    'assigned'    => 'info',
                    'in_progress' => 'primary',
                    'completed'   => 'success',
                    'cancelled'   => 'danger',
                ];
                $color = $colors[$row->status] ?? 'secondary';
                return '<span class="badge bg-' . $color . '">' . ucfirst(str_replace('_', ' ', $row->status)) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $viewUrl = route('admin.build-booking.view', $row->id);
                return '<a href="' . $viewUrl . '" class="btn btn-sm btn-info me-1">
                            <i class="fas fa-eye me-1"></i>View
                        </a>';
            })
            ->rawColumns(['service', 'customer_name', 'site_location', 'budget_range', 'status', 'action'])
            ->make(true);
    }

    public function view($id)
    {
        $booking    = BuildServiceBooking::with('service.category')->findOrFail($id);
        $page_title = 'Booking #' . $id . ' Details';
        return view('admin.build_service_booking.view', compact('booking', 'page_title'));
    }

    public function updateStatus(Request $request)
    {
        $booking = BuildServiceBooking::find($request->id);
        if (!$booking) {
            return response()->json(['status' => false, 'message' => 'Booking not found'], 404);
        }
        $booking->status      = $request->status;
        $booking->admin_notes = $request->admin_notes ?? $booking->admin_notes;
        $booking->save();
        return response()->json(['status' => true, 'message' => 'Status updated successfully']);
    }
}
