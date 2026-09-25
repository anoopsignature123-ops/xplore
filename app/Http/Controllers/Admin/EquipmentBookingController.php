<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\EquipmentBooking;
use Illuminate\Support\Facades\Validator;

class EquipmentBookingController extends Controller
{
    public function index()
    {
        $page_title = 'Equipment Rental Bookings';
        return view('admin.equipment_booking.list', compact('page_title'));
    }

    public function getRecords(Request $request)
    {
        $query = EquipmentBooking::with(['customer', 'equipment'])->orderBy('id', 'desc');

        if ($request->has('booking_status') && !empty($request->booking_status)) {
            $query->where('booking_status', $request->booking_status);
        }

        if ($request->has('payment_status') && !empty($request->payment_status)) {
            $query->where('payment_status', $request->payment_status);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('booking_number', function ($row) {
                return '<strong>' . e($row->booking_number) . '</strong>';
            })
            ->editColumn('customer', function ($row) {
                if ($row->customer) {
                    $name = $row->customer->name ?? $row->customer->phone_no ?? 'Customer #' . $row->customer_id;
                    $phone = $row->customer->phone_no ? ' (' . $row->customer->phone_no . ')' : '';
                    return e($name . $phone);
                }
                return 'N/A';
            })

            ->editColumn('equipment', function ($row) {
                return $row->equipment ? e($row->equipment->name) : 'N/A';
            })
            ->editColumn('rental_duration_days', function ($row) {
                return $row->rental_duration_days . ' Days';
            })
            ->editColumn('total_amount', function ($row) {
                return '<strong class="text-success"><i class="fas fa-rupee-sign"></i> ' . number_format($row->total_amount, 2) . '</strong>';
            })
            ->editColumn('delivery_type', function ($row) {
                $types = [
                    'site_delivery'   => '<span class="badge bg-info"><i class="fas fa-truck me-1"></i> Site Delivery</span>',
                    'office_delivery' => '<span class="badge bg-primary"><i class="fas fa-building me-1"></i> Office Delivery</span>',
                    'self_pickup'     => '<span class="badge bg-secondary"><i class="fas fa-walking me-1"></i> Self Pickup</span>',
                ];
                return $types[$row->delivery_type] ?? $row->delivery_type;
            })
            ->editColumn('booking_status', function ($row) {
                $statusBadges = [
                    'pending'    => '<span class="badge bg-warning text-dark"><i class="fas fa-clock me-1"></i> Pending</span>',
                    'confirmed'  => '<span class="badge bg-info"><i class="fas fa-check-circle me-1"></i> Confirmed</span>',
                    'dispatched' => '<span class="badge bg-primary"><i class="fas fa-shipping-fast me-1"></i> Dispatched</span>',
                    'delivered'  => '<span class="badge bg-success"><i class="fas fa-box-open me-1"></i> Delivered</span>',
                    'returned'   => '<span class="badge bg-dark"><i class="fas fa-undo me-1"></i> Returned</span>',
                    'cancelled'  => '<span class="badge bg-danger"><i class="fas fa-times-circle me-1"></i> Cancelled</span>',
                ];
                return $statusBadges[$row->booking_status] ?? $row->booking_status;
            })
            ->editColumn('payment_status', function ($row) {
                $paymentBadges = [
                    'pending'  => '<span class="badge bg-warning text-dark"><i class="fas fa-hourglass-half me-1"></i> Pending</span>',
                    'paid'     => '<span class="badge bg-success"><i class="fas fa-check me-1"></i> Paid</span>',
                    'failed'   => '<span class="badge bg-danger"><i class="fas fa-exclamation-triangle me-1"></i> Failed</span>',
                    'refunded' => '<span class="badge bg-secondary"><i class="fas fa-hand-holding-usd me-1"></i> Refunded</span>',
                ];
                return $paymentBadges[$row->payment_status] ?? $row->payment_status;
            })
            ->addColumn('action', function ($row) {
                $viewUrl = route('admin.equipment-booking.detail', $row->id);
                return '<a href="' . $viewUrl . '" class="btn btn-sm btn-info text-white me-1"><i class="fas fa-eye me-1"></i> View Details</a>';
            })
            ->rawColumns(['booking_number', 'total_amount', 'delivery_type', 'booking_status', 'payment_status', 'action'])
            ->make(true);
    }

    public function detail($id)
    {
        $booking = EquipmentBooking::with(['customer', 'equipment', 'address'])->findOrFail($id);
        $page_title = 'Booking Details - ' . $booking->booking_number;

        return view('admin.equipment_booking.detail', compact('booking', 'page_title'));
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = EquipmentBooking::findOrFail($id);

        $rules = [
            'booking_status' => 'required|in:pending,confirmed,dispatched,delivered,returned,cancelled',
            'payment_status' => 'required|in:pending,paid,failed,refunded',
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $booking->booking_status = $request->booking_status;
        $booking->payment_status = $request->payment_status;
        $booking->save();

        return redirect()->back()->with('success', 'Booking status updated successfully!');
    }
}
