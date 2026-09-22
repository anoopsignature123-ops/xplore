<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Vendor;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class VendorController extends Controller
{
    public function index()
    {
        $page_title = 'Vendor List';
        return view('admin.vendor.list', compact('page_title'));
    }

    public function getRecords(Request $request)
    {
        if ($request->ajax()) {

            $query = Vendor::orderBy('id', 'desc');

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }

            if ($request->filled('phone_no')) {
                $query->where('phone_no', 'like', '%' . $request->phone_no . '%');
            }

            if ($request->filled('vendor_type')) {
                $query->where('vendor_type', $request->vendor_type);
            }

            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }

            if ($request->filled('from_date') && $request->filled('to_date')) {
                $query->whereBetween('created_at', [$request->from_date . ' 00:00:00', $request->to_date . ' 23:59:59']);
            } elseif ($request->filled('from_date')) {
                $query->whereDate('created_at', '>=', $request->from_date);
            } elseif ($request->filled('to_date')) {
                $query->whereDate('created_at', '<=', $request->to_date);
            }

            return DataTables::of($query)
                ->addIndexColumn()

                ->editColumn('created_at', function ($row) {
                    return $row->created_at ? $row->created_at->format('d M Y') : 'N/A';
                })
 
                ->editColumn('profile_image', function ($row) {
                    if (!empty($row->profile_image)) {
                        $imgUrl = asset($row->profile_image);
                        return '<a href="' . $imgUrl . '" target="_blank">
                                    <img src="' . $imgUrl . '" alt="' . e($row->name) . '" width="60" height="60" style="object-fit:cover;border-radius:6px;">
                                </a>';
                    }
                    return 'N/A';
                })

                ->editColumn('vendor_type', function ($row) {
                    if (!$row->vendor_type) return 'N/A';
                    return ucwords(str_replace('_', ' ', $row->vendor_type));
                })

                ->editColumn('status', function ($row) {
                    return '<span class="badge bg-' . ($row->status === 'Active' ? 'success' : 'danger') . '">' . $row->status . '</span>';
                })

                ->addColumn('action', function ($row) {
                    $btn = '';
                    
                    if(auth()->user()->can('vendor-add')) {
                        $editUrl = route('admin.vendor.add', $row->id);
                        $btn .= '<a title="Edit Record" href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a> ';
                    }
                    if(auth()->user()->can('vendor-delete')) {
                        $btn .= '<a title="Delete Record" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash-alt"></i></a>';
                    }
                    
                    return $btn;
                })

                ->rawColumns(['profile_image', 'status', 'action'])
                ->make(true);
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }

    public function add($id = null) {
        $vendor = !empty($id) ? Vendor::find($id) : null;
        if ($id && !$vendor) { 
            return redirect()->route('admin.vendor.list')->with('error', 'Record Not Found');
        }
        $btn_title  = $vendor ? 'Update' : 'Submit';
        $page_title = $vendor ? 'Update Vendor' : 'Add Vendor';

        return view('admin.vendor.add', compact('vendor', 'btn_title', 'page_title'));
    }

    public function save(Request $request)
    {
        $input = $request->all(); 
        $id = $input['id'] ?? null;

        $rules = [
            'name' => 'required|string',
            'email_id' => 'required|email|unique:vendors,email_id,' . $id,
            'phone_no' => 'required|min:10|max:10|unique:vendors,phone_no,' . $id,
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'status' => 'required|in:Pending,Active,Inactive,Blocked',
            'gender' => 'required|in:Male,Female,Other',
            'vendor_type' => 'required|in:survey,product,rental_product,course',
            'raw_password' => $id ? 'nullable|min:6' : 'required|min:6'
        ];

        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()
            ], 422);
        }

        $vendor = $id ? Vendor::find($id) : new Vendor();

        if($id && !$vendor){
            return response()->json([
                'message'=>'Record Not Found'
            ], 404);
        }

        $vendor->name = trim($input['name']);
        $vendor->email_id = trim($input['email_id']);
        $vendor->phone_no = trim($input['phone_no']);
        $vendor->status = $input['status'];
        $vendor->gender = $input['gender'];
        $vendor->vendor_type = $input['vendor_type'];

        if (!empty($input['raw_password'])) {
            $vendor->raw_password = $input['raw_password'];
            $vendor->password = Hash::make($input['raw_password']);
        }

        if ($request->hasFile('profile_image')) {
            $fileName = $request->file('profile_image');
            $uploaded = uploadImage(
                $fileName,
                'vendor',
                $request->input('old_profile_image')
            );
            $vendor->profile_image = $uploaded['image'] ?? '';
        }

        $vendor->save();

        return response()->json([
            'success'=>true,
            'message'=> $id ? 'Vendor updated successfully.' : 'Vendor added successfully.'
        ]);
    }

    public function delete(Request $request)
    {
        if (!auth()->user()->can('vendor-delete')) {
            return response()->json([ 
                'status' => false,
                'message' => 'Permission denied'
            ], 403);
        }

        $id = $request->get('id');
        $vendor = Vendor::find($id);

        if($vendor){
            $vendor->delete();
            return response()->json([
                'status' => true,
                'message' => 'Record Deleted successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Record Not Found'
        ]);
    }
}
