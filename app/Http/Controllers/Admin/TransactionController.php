<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Transaction;
use App\Models\Customer;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Transaction List';
        $status = $request->status;
        $customers = Customer::orderBy('name')->get();
        return view('admin.transaction.list', compact('page_title', 'customers', 'status'));
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = Transaction::with(['customer', 'order'])->orderBy('created_at', 'desc');

            return DataTables::of($query)
                ->filter(function ($query) use ($request) {
                    if ($request->filled('user_id')) {
                        $query->where('transactions.user_id', $request->user_id);
                    }
                    if ($request->filled('txn_for')) {
                        $query->where('transactions.txn_for', $request->txn_for);
                    }
                    if ($request->filled('status')) {
                        $query->where('transactions.status', $request->status);
                    }
                    if ($request->filled('order_id')) {
                        $query->whereHas('order', function ($q) use ($request) {
                            $q->where('order_code', 'like', '%' . $request->order_id . '%');
                        });
                    }
                    if ($request->filled('amount')) {
                        $query->where('transactions.amount', $request->amount);
                    }

                    if ($request->has('search') && !empty($request->search['value'])) {
                        $searchValue = $request->search['value'];
                        $query->where(function ($q) use ($searchValue) {
                            $q->where('transactions.order_id', 'like', '%' . $searchValue . '%')
                              ->orWhere('transactions.razorpay_order_id', 'like', '%' . $searchValue . '%')
                              ->orWhere('transactions.transaction_id', 'like', '%' . $searchValue . '%')
                              ->orWhere('transactions.razorpay_payment_id', 'like', '%' . $searchValue . '%')
                              ->orWhere('transactions.amount', 'like', '%' . $searchValue . '%')
                              ->orWhereHas('order', function ($qOrder) use ($searchValue) {
                                  $qOrder->where('order_code', 'like', '%' . $searchValue . '%');
                              })
                              ->orWhereHas('customer', function ($qCustomer) use ($searchValue) {
                                  $qCustomer->where('name', 'like', '%' . $searchValue . '%')
                                            ->orWhere('email_id', 'like', '%' . $searchValue . '%')
                                            ->orWhere('phone_no', 'like', '%' . $searchValue . '%');
                              });
                        });
                    }
                })
                ->addColumn('order_code', function ($row) {
                    return $row->order ? $row->order->order_code : 'N/A';
                })
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d M Y, h:i A') : 'N/A';
                })
                ->addColumn('customer_details', function ($row) {
                    if ($row->customer) {
                        $image = $row->customer->profile_image ? asset($row->customer->profile_image) : asset('assets/images/user.png');
                        $html = '<div class="d-flex align-items-center">';
                        $html .= '<img src="' . $image . '" alt="avatar" class="rounded-circle me-2" width="40" height="40" style="object-fit:cover;">';
                        $html .= '<div>';
                        $html .= '<h6 class="mb-0">' . $row->customer->name . '</h6>';
                        $html .= '<small class="text-muted">' . $row->customer->email_id . '<br>' . $row->customer->phone_no . '</small>';
                        $html .= '</div></div>';
                        return $html;
                    }
                    return 'N/A';
                })
                ->editColumn('amount', function ($row) {
                    return '₹' . number_format($row->amount, 2);
                })
                ->editColumn('status', function ($row) {
                    $class = strtolower($row->status) === 'success' || strtolower($row->status) === 'paid' ? 'success' : (strtolower($row->status) === 'pending' ? 'warning' : 'danger');
                    return '<span class="badge bg-' . $class . '">' . $row->status . '</span>';
                })
                ->editColumn('final_status', function ($row) {
                    $class = strtolower($row->final_status) === 'success' || strtolower($row->final_status) === 'paid' ? 'success' : (strtolower($row->final_status) === 'pending' ? 'warning' : 'danger');
                    return '<span class="badge bg-' . $class . '">' . $row->final_status . '</span>';
                })
                ->editColumn('txn_for', function ($row) {
                    $link = 'javascript:void(0)';
                    
                    if ($row->txn_for == 'product') {
                        $link = route('admin.product-order.list', ['user_id' => $row->user_id, 'id' => $row->rel_id]);
                    } elseif ($row->txn_for == 'survey') {
                        $link = route('admin.customer-survey.list', ['user_id' => $row->user_id, 'id' => $row->rel_id]);
                    } elseif ($row->txn_for == 'course') {
                        $link = route('admin.course-enrollment.list', ['user_id' => $row->user_id, 'id' => $row->rel_id]);
                    }

                    if ($link !== 'javascript:void(0)') {
                        return '<a href="' . $link . '" target="_blank" class="text-primary fw-bold">' . ucfirst($row->txn_for) . '</a>';
                    }
                    
                    return ucfirst($row->txn_for) ?: 'N/A';
                })
                ->editColumn('order_id', function ($row) { return $row->order_id ?: 'N/A'; })
                ->editColumn('razorpay_order_id', function ($row) { return $row->razorpay_order_id ?: 'N/A'; })
                ->editColumn('transaction_id', function ($row) { return $row->transaction_id ?: 'N/A'; })
                ->editColumn('razorpay_payment_id', function ($row) { return $row->razorpay_payment_id ?: 'N/A'; })
                ->editColumn('remarks', function ($row) { return $row->remarks ?: 'N/A'; })
                ->rawColumns(['customer_details','order_id', 'status', 'final_status', 'txn_for'])
                ->make(true);
        }
    }
}
