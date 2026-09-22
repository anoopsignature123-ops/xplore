<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\HelpQuery;
use App\Models\Customer;

class HelpQueryController extends Controller
{
    public function index()
    {
        $page_title = 'Customer Help Query List';
        $customers = Customer::select('id', 'name', 'phone_no')->where('status', 'Active')->get();
        return view('admin.help-queries.list', compact('page_title', 'customers'));
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {

            $query = HelpQuery::with('customer')->select('help_queries.*')->orderBy('id', 'desc');

            if ($request->customer_id) {
                $query->where('customer_id', $request->customer_id);
            }

            if ($request->from_date && $request->to_date) {
                $fromDate = \Carbon\Carbon::parse($request->from_date)->startOfDay();
                $toDate = \Carbon\Carbon::parse($request->to_date)->endOfDay();
                $query->whereBetween('help_queries.created_at', [$fromDate, $toDate]);
            } elseif ($request->from_date) {
                $fromDate = \Carbon\Carbon::parse($request->from_date)->startOfDay();
                $query->where('help_queries.created_at', '>=', $fromDate);
            } elseif ($request->to_date) {
                $toDate = \Carbon\Carbon::parse($request->to_date)->endOfDay();
                $query->where('help_queries.created_at', '<=', $toDate);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('customer_info', function ($row) {
                    $customer = $row->customer;
                    if (!$customer) return 'N/A';
                    
                    $img = !empty($customer->profile_image) ? asset($customer->profile_image) : asset('assets/images/default-user.png');
                    
                    return '
                        <div class="d-flex align-items-center">
                            <img src="'.$img.'" alt="Profile Image" class="rounded-circle me-3" width="45" height="45" style="object-fit: cover;">
                            <div>
                                <span class="fw-bold text-dark d-block">'.$customer->name.'</span>
                                <span class="text-muted small d-block">'.$customer->phone_no.'</span>
                                <span class="text-muted small d-block">'.$customer->email_id.'</span>
                            </div>
                        </div>
                    ';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d F Y h:i A') : '';
                })
                ->addColumn('remark', function ($row) {
                    if (empty($row->remark)) {
                        return '<button type="button" class="btn btn-sm btn-info btn-give-review" data-id="'.$row->id.'">Give Review</button>';
                    }
                    return '<span>' . e($row->remark) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '';
                    if (auth()->user()->can('help-query-delete')) {
                        $btn .= '<a href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash"></i></a>';
                    }
                    return $btn;
                })
                ->rawColumns(['customer_info', 'remark', 'action'])
                ->make(true);
        }
    }

    public function updateRemark(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:help_queries,id',
            'remark' => 'required|string'
        ]);

        $helpQuery = HelpQuery::find($request->id);

        if ($helpQuery && empty($helpQuery->remark)) {
            $helpQuery->remark = $request->remark;
            $helpQuery->save();
            return response()->json(['status' => true, 'message' => 'Remark saved successfully']);
        }

        return response()->json([
            'status' => false,
            'message' => 'Remark already exists or record not found'
        ]);
    }

    public function delete(Request $request)
    {
        $helpQuery = HelpQuery::find($request->id);

        if ($helpQuery) {
            $helpQuery->delete();
            return response()->json(['status' => true, 'message' => 'Record Deleted Successfully']);
        }

        return response()->json([
            'status' => false,
            'message' => 'Record Not Found'
        ]);
    }
}
