<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Order;
use App\Models\Customer;
use App\Models\CourseEnrollment;
use App\Models\CustomerSurvey;
use App\Models\ProductOrder;
use App\Models\ProductOrderItem;
use App\Models\WebSettings;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Support\Facades\Crypt;
class OrderController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Order List';
        $customers = Customer::orderBy('name')->get();
        return view('admin.order.list', compact('page_title', 'customers'));
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = Order::orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
                    if ($request->filled('user_id')) {
                        $query->where('customer_id', $request->user_id);
                    }
                    if ($request->filled('txn_for')) {
                        $query->where('order_type', $request->txn_for);
                    }
                    if ($request->filled('status')) {
                        $query->where('status', $request->status);
                    }
                    if ($request->filled('order_id')) {
                        $query->where('order_code', 'like', '%' . $request->order_id . '%');
                    }
                    if ($request->filled('amount')) {
                        $query->where('amount', $request->amount);
                    }
                    if ($request->filled('date_from')) {
                        $query->whereDate('created_at', '>=', $request->date_from);
                    }
                    if ($request->filled('date_to')) {
                        $query->whereDate('created_at', '<=', $request->date_to);
                    }

                    if ($request->has('search') && !empty($request->search['value'])) {
                        $searchValue = $request->search['value'];
                        $query->where(function ($q) use ($searchValue) {
                            $q->where('order_code', 'like', '%' . $searchValue . '%')
                              ->orWhere('customer_name', 'like', '%' . $searchValue . '%')
                              ->orWhere('customer_email', 'like', '%' . $searchValue . '%')
                              ->orWhere('customer_mobile', 'like', '%' . $searchValue . '%')
                              ->orWhere('amount', 'like', '%' . $searchValue . '%');
                        });
                    }
                })
                ->addIndexColumn() 
                ->addColumn('action', function ($row) {
                    $html = '';
                    if (strtolower($row->status) === 'success') {
                        $enc_id = base64_encode('XPL-' . ($row->id * 8888));
                        $html .= '<a href="' . route('admin.order.invoice', $enc_id) . '" target="_blank" class="btn btn-sm btn-info text-white"><i class="fas fa-file-pdf"></i> Invoice</a>';
                    }
                    return $html;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d M Y, h:i A') : 'N/A';
                })
                ->addColumn('customer_details', function ($row) { 
                    $html = '<div class="d-flex align-items-center">';
                    $html .= '<div>';
                    $html .= '<h6 class="mb-0">' . $row->customer_name . '</h6>';
                    $html .= '<small class="text-muted">' . $row->customer_email . '<br>' . $row->customer_mobile . '</small>';
                    $html .= '</div></div>';
                    return $html;
                })
                ->editColumn('amount', function ($row) {
                    return '₹' . number_format($row->amount, 2);
                })
                ->editColumn('status', function ($row) {
                    $class = strtolower($row->status) === 'success' ? 'success' : (strtolower($row->status) === 'pending' ? 'warning' : 'danger');
                    return '<span class="badge bg-' . $class . '">' . $row->status . '</span>';
                })
                ->editColumn('order_type', function ($row) { 
                    $link = 'javascript:void(0)';
                    
                    if ($row->order_type == 'product') {
                        $link = route('admin.product-order.list', ['user_id' => $row->customer_id, 'id' => $row->rel_id]);
                    } elseif ($row->order_type == 'survey') {
                        $link = route('admin.customer-survey.list', ['user_id' => $row->customer_id, 'id' => $row->rel_id]);
                    } elseif ($row->order_type == 'course') {
                        $link = route('admin.course-enrollment.list', ['user_id' => $row->customer_id, 'id' => $row->rel_id]);
                    }

                    if ($link !== 'javascript:void(0)') {
                        return '<a href="' . $link . '" target="_blank" class="text-primary fw-bold">' . ucfirst($row->order_type) . '</a>';
                    }
                    
                    return ucfirst($row->order_type) ?: 'N/A';
                })
                ->editColumn('address', function ($row) {
                    return $row->address ? $row->address . ', ' . $row->city_name . ', ' . $row->state_name . ' - ' . $row->pincode : 'N/A';
                })
                ->editColumn('notes', function ($row) {
                    return $row->notes ?: 'N/A';
                })
                ->rawColumns(['action', 'customer_details', 'status', 'order_type', 'address', 'notes'])
                ->make(true);
        }
    }

    public function generateInvoice($enc_id)
    {
        try {
            $decoded = base64_decode($enc_id);
            $idStr = str_replace('XPL-', '', $decoded);
            $id = (int)$idStr / 8888;
            $order = Order::findOrFail($id);
        } catch (\Exception $e) {
            return back()->with('error', 'Invalid Order ID');
        }

        $settings = settingData();

        $items = [];
        $subtotal = 0;

        if ($order->order_type == 'course') {
            $enrollment = CourseEnrollment::where('id', $order->rel_id)->first();
            if ($enrollment) {
                $name = $enrollment->course_name;
                if (!empty($enrollment->course_category_name)) {
                    $name .= ' <br><small style="color:#666;">Category: ' . $enrollment->course_category_name . '</small>';
                }
                $items[] = [
                    'name' => $name,
                    'quantity' => 1,
                    'unit_price' => $enrollment->amount,
                    'total' => $enrollment->amount,
                ];
                $subtotal += $enrollment->amount;
            }
        } elseif ($order->order_type == 'survey') {
            $survey = CustomerSurvey::where('id', $order->rel_id)->first();
            if ($survey) {
                $items[] = [
                    'name' => $survey->survey_name,
                    'quantity' => 1,
                    'unit_price' => $survey->amount, 
                    'total' => $survey->amount,
                ];
                $subtotal += $survey->amount;
            }
        } elseif ($order->order_type == 'product' || $order->order_type == 'rental_product') {
            $productOrder = ProductOrder::where('id', $order->rel_id)->first();
            if ($productOrder) {
                foreach ($productOrder->items as $item) {
                    $name = $item->product_name;
                    $details = [];
                    if (!empty($item->variant_name)) $details[] = 'Variant: ' . $item->variant_name;
                    if (!empty($item->category_name)) $details[] = 'Category: ' . $item->category_name;
                    if (!empty($item->sub_category_name)) $details[] = 'Sub Category: ' . $item->sub_category_name;
                    if (!empty($item->brand_name)) $details[] = 'Brand: ' . $item->brand_name;
                    
                    if (count($details) > 0) {
                        $name .= ' <br><small style="color:#666;">' . implode(' | ', $details) . '</small>';
                    }

                    $items[] = [
                        'name' => $name,
                        'quantity' => $item->quantity,
                        'unit_price' => $item->sale_price,
                        'total' => $item->line_total,
                    ];
                }
                $subtotal = $productOrder->subtotal;
            }
        }

        if (empty($subtotal)) {
            $subtotal = $order->amount;
        }

        $data = [
            'order' => $order,
            'settings' => $settings,
            'items' => $items,
            'subtotal' => $subtotal,
            'total' => $order->amount,
            'date' => $order->created_at->format('d / m / Y') 
        ];

        $pdf = Pdf::view('pdf.invoice', $data)
            ->driver('dompdf')
            ->format('a4')
            ->name('invoice-' . $order->order_code . '.pdf');

        if (request('type') == 'download') {
            return $pdf->download();
        }

        return $pdf;
    }
}
