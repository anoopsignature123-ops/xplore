<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables; 
use App\Models\Customer; 
use App\Models\ProductOrder;

class ProductOrderController extends Controller
{
    public function index(Request $request)
    {
        $page_title = 'Order List';
        $user_id = $request->user_id;
        $id = $request->id;
        $order_status = $request->order_status;
        $customers = Customer::select('id','name','phone_no')->orderBy('name')->get();
        return view('admin.product-order.list', compact('page_title', 'user_id', 'id', 'order_status', 'customers'));
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = ProductOrder::with('user');

            if ($request->user_id != '') {
                $query->where('user_id', $request->user_id);
            }
            if ($request->id != '') {
                $query->where('id', $request->id);
            }
            if ($request->order_number != '') { 
                $query->where('order_number', 'like', '%' . $request->order_number . '%');
            }
            if ($request->order_status != '') {
                $query->where('order_status', $request->order_status);
            }
            if ($request->payment_status != '') {
                $query->where('payment_status', $request->payment_status);
            }

            $query->orderBy('id', 'desc');

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d M Y, h:i A') : 'N/A';
                })

    ->addColumn('customer_details', function ($row) {
        if ($row->user) {
            $img = !empty($row->user->profile_image) ? asset($row->user->profile_image) : asset('assets/images/default-user.png');
            return '
                <div class="d-flex align-items-center">
                    <img src="'.$img.'" alt="Profile" style="width:40px;height:40px;border-radius:50%;object-fit:cover;margin-right:10px;">
                    <div>
                        <strong>'.$row->user->name.'</strong><br>
                        <small>'.$row->user->email_id.'</small><br>
                        <small>'.$row->user->phone_no.'</small>
                    </div>
                </div>
            ';
        }
        return 'N/A';
    })

           
           
           
                ->editColumn('grand_total', function ($row) {
                    return '₹' . number_format($row->grand_total, 2);
                })
                ->editColumn('payment_status', function ($row) {
                    $class = $row->payment_status === 'success' ? 'success' : ($row->payment_status === 'pending' ? 'warning' : 'danger');
                    return '<span class="badge bg-' . $class . '">' . $row->payment_status . '</span>';
                })
                ->editColumn('order_status', function ($row) {
                    $class = 'secondary';
                    if ($row->order_status === 'delivered') $class = 'success';
                    if ($row->order_status === 'pending') $class = 'warning'; 
                    if ($row->order_status === 'processing') $class = 'info';
                    if ($row->order_status === 'cancelled') $class = 'danger';
                    return '<span class="badge bg-' . $class . '">' . $row->order_status . '</span>';
                })
                ->addColumn('action', function ($row) {
                    return '<a title="View Details" href="' . route('admin.product-order.detail', $row->id) . '" class="btn btn-sm btn-info m-1 text-white"><i class="fas fa-eye"></i> Details</a>';
                })
                ->rawColumns(['payment_status', 'order_status', 'action','customer_details'])
                ->make(true);
        }
    } 

    public function detail($id)
    {
        $order = ProductOrder::with(['user', 'items.product'])->find($id);

        if (!$order) {
            return redirect()->route('admin.product-order.list')->with('error', 'Order Not Found');
        }

        $page_title = 'Order Details - ' . $order->order_number;
        return view('admin.product-order.detail', compact('order', 'page_title'));
    }

    public function changeStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:product_orders,id',
            'order_status' => 'required|string'
        ]);

        $order = ProductOrder::find($request->id);
        if ($order) {
            $order->order_status = $request->order_status;
            $order->save();
            return response()->json(['status' => true, 'message' => 'Order Status Updated Successfully']);
        }
        return response()->json(['status' => false, 'message' => 'Order Not Found']);
    }
}
