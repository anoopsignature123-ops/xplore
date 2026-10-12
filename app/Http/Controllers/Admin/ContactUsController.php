<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\ContactUs;
use App\Models\ContactType;

class ContactUsController extends Controller
{
    public function index()
    {
        $page_title = 'Contact Us Queries List';
        $contactTypes = ContactType::where('status', 'Active')->get();
        return view('admin.contact-us.list', compact('page_title', 'contactTypes'));
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {
            $query = ContactUs::with(['customer', 'contactType'])->select('contact_us.*')->orderBy('id', 'desc');

            if ($request->contact_type_id) {
                $query->where('contact_type_id', $request->contact_type_id);
            }

            if ($request->status) {
                $query->where('status', $request->status);
            }

            if ($request->from_date && $request->to_date) {
                $fromDate = \Carbon\Carbon::parse($request->from_date)->startOfDay();
                $toDate = \Carbon\Carbon::parse($request->to_date)->endOfDay();
                $query->whereBetween('created_at', [$fromDate, $toDate]);
            } elseif ($request->from_date) {
                $fromDate = \Carbon\Carbon::parse($request->from_date)->startOfDay();
                $query->where('created_at', '>=', $fromDate);
            } elseif ($request->to_date) {
                $toDate = \Carbon\Carbon::parse($request->to_date)->endOfDay();
                $query->where('created_at', '<=', $toDate);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('user_info', function ($row) {
                    $customer = $row->customer;
                    $name = $row->name ?? ($customer ? $customer->name : 'N/A');
                    $email = $row->email ?? ($customer ? $customer->email_id : 'N/A');
                    $phone = $row->phone ?? ($customer ? $customer->phone_no : 'N/A');

                    $img = ($customer && !empty($customer->profile_image)) ? asset($customer->profile_image) : asset('assets/images/default-user.png');

                    return '
                        <div class="d-flex align-items-center">
                            <img src="'.$img.'" alt="Profile Image" class="rounded-circle me-2" width="40" height="40" style="object-fit: cover;">
                            <div>
                                <span class="fw-bold text-dark d-block">'.e($name).'</span>
                                <span class="text-muted small d-block">'.e($phone).'</span>
                                <span class="text-muted small d-block">'.e($email).'</span>
                            </div>
                        </div>
                    ';
                })
                ->addColumn('contact_type_name', function ($row) {
                    return e($row->type ?? ($row->contactType ? $row->contactType->name : 'N/A'));
                })
                ->editColumn('title', function ($row) {
                    return e($row->title);
                })
                ->editColumn('message', function ($row) {
                    return \Str::limit(e($row->message), 50);
                })
                ->editColumn('reply', function ($row) {
                    return $row->reply ? \Str::limit(e($row->reply), 50) : '<span class="text-muted">No Reply Yet</span>';
                })
                ->editColumn('status', function ($row) {
                    $badgeClass = 'bg-secondary';
                    if ($row->status === 'Pending') $badgeClass = 'bg-warning text-dark';
                    elseif ($row->status === 'In-Progress') $badgeClass = 'bg-info text-white';
                    elseif ($row->status === 'Resolved') $badgeClass = 'bg-success';
                    elseif ($row->status === 'Closed') $badgeClass = 'bg-danger';

                    return '<span class="badge '.$badgeClass.'">'.$row->status.'</span>';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d M Y h:i A') : '';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" class="btn btn-sm btn-info me-1 btn-view-reply" 
                            data-id="'.$row->id.'" 
                            data-name="'.e($row->name ?? ($row->customer ? $row->customer->name : 'N/A')).'"
                            data-type="'.e($row->type ?? ($row->contactType ? $row->contactType->name : 'N/A')).'"
                            data-title="'.e($row->title).'"
                            data-message="'.e($row->message).'"
                            data-reply="'.e($row->reply).'"
                            data-status="'.$row->status.'"
                            title="View / Reply">
                            <i class="fas fa-eye"></i> View/Reply
                            </button>';
                    $btn .= '<a href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>';
                    return $btn;
                })
                ->rawColumns(['user_info', 'contact_type_name', 'reply', 'status', 'action'])
                ->make(true);
        }
    }

    public function updateReplyStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:contact_us,id',
            'reply' => 'nullable|string',
            'status' => 'required|in:Pending,In-Progress,Resolved,Closed',
        ]);

        $contactUs = ContactUs::find($request->id);
        if ($contactUs) {
            $contactUs->reply = $request->reply;
            $contactUs->status = $request->status;
            $contactUs->save();

            return response()->json([
                'status' => true,
                'message' => 'Query updated successfully!'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Record not found'
        ], 404);
    }

    public function delete(Request $request)
    {
        $contactUs = ContactUs::find($request->id);

        if ($contactUs) {
            $contactUs->delete();
            return response()->json(['status' => true, 'message' => 'Record Deleted Successfully']);
        }

        return response()->json([
            'status' => false,
            'message' => 'Record Not Found'
        ]);
    }
}
