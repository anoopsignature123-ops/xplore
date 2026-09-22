<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index()
    {
        $page_title = 'Customer List';
        return view('admin.customer.list', compact('page_title'));
    }

    public function getRecords(Request $request)
{
    if ($request->ajax()) {

        $query = Customer::with('cart')->orderBy('id', 'desc');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('phone_no')) {
            $query->where('phone_no', 'like', '%' . $request->phone_no . '%');
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

            ->editColumn('status', function ($row) {
                return '<span class="badge bg-' . ($row->status === 'Active' ? 'success' : 'danger') . '">' . $row->status . '</span>';
            })

            ->addColumn('action', function ($row) {
                $btn = '';
                
                if(auth()->user()->can('customer-add')) {
                    $editUrl = route('admin.customer.add', $row->id);
                    $btn .= '<a title="Edit Record" href="' . $editUrl . '" class="btn btn-sm btn-primary m-1"><i class="fas fa-edit"></i></a> ';
                }
                if(auth()->user()->can('customer-delete')) {
                    $btn .= '<a title="Delete Record" href="javascript:void(0);" onclick="deleteData(' . $row->id . ')" class="btn btn-sm btn-danger m-1"><i class="fas fa-trash-alt"></i></a>';
                }

                if ($row->cart) {
                    $btn .= '<a href="' . route('admin.cart.detail', $row->cart->id) . '" class="btn btn-sm btn-info m-1 text-white" title="View Cart"><i class="fas fa-shopping-cart"></i> Cart</a>';
                }
                $btn .= '<a href="' . route('admin.product-order.list', ['user_id' => $row->id]) . '" class="btn btn-sm btn-primary m-1 text-white" title="View Orders"><i class="fas fa-box"></i> Orders</a>';
                
                return $btn;
            })

            ->rawColumns(['profile_image', 'status', 'action'])
            ->make(true);
    }

    return response()->json(['error' => 'Invalid request'], 400);
}

    public function add($id = null) {
        $customer = !empty($id) ? Customer::find($id) : null;
        if ($id && !$customer) { 
            return redirect()->route('admin.customer.list')->with('error', 'Record Not Found');
        }
        $btn_title  = $customer ? 'Update' : 'Submit';
        $page_title = $customer ? 'Update Customer' : 'Add Customer';
        
        $addresses = $customer ? CustomerAddress::where('customer_id', $customer->id)->get() : [];

        return view('admin.customer.add', compact('customer', 'btn_title', 'page_title', 'addresses'));
    }

    public function save(Request $request)
    {
        $input = $request->all(); 
        $id = $input['id'] ?? null;

        $rules = [
            'name' => 'required|string',
            'email_id' => 'required|email|unique:customers,email_id,' . $id,
            'phone_no' => 'required|min:10|max:10|unique:customers,phone_no,' . $id,
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'status' => 'required|in:Pending,Active,Inactive,Blocked',
            'gender' => 'required|in:Male,Female,Other'
        ];

        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            return response()->json([
                'errors'=>$validator->errors()
            ], 422);
        }

        $customer = $id ? Customer::find($id) : new Customer();

        if($id && !$customer){
            return response()->json([
                'message'=>'Record Not Found'
            ], 404);
        }

        $customer->name = trim($input['name']);
        $customer->email_id = trim($input['email_id']);
        $customer->phone_no = trim($input['phone_no']);
        $customer->status = $input['status'];
        $customer->gender = $input['gender'];
        if(!$id) {
            $customer->device_type = 'Android'; // Default device_type
        }

        if ($request->hasFile('profile_image')) {
            $fileName = $request->file('profile_image');
            $uploaded = uploadImage(
                $fileName,
                'customer',
                $request->input('old_profile_image')
            );
            $customer->profile_image = $uploaded['image'] ?? '';
        }

        $customer->save();

        return response()->json([
            'success'=>true,
            'message'=> $id ? 'Customer updated successfully.' : 'Customer added successfully.'
        ]);
    }

    public function delete(Request $request)
    {
        if (!auth()->user()->can('customer-delete')) {
            return response()->json([ 
                'status' => false,
                'message' => 'Permission denied'
            ], 403);
        }

        $id = $request->get('id');
        $customer = Customer::find($id);

        if($customer){
            $customer->delete();
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

    public function saveAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id'     => 'nullable|numeric|exists:customer_addresses,id',
            'customer_id'    => 'required|numeric', 
            'address_type'   => 'required|in:home,office,other',
            'address'        => 'required|string',
            'pincode'        => 'required|string|size:6', 
            'city_name'      => 'required|string',
            'state_name'     => 'required|string',
            'set_as_default' => 'nullable|in:yes,no',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $existingAddress = CustomerAddress::where('customer_id', $request->customer_id)
            ->where('address_type', $request->address_type)
            ->first();

        if ($existingAddress && $existingAddress->id != $request->address_id) {
            return response()->json([
                'status'  => false,
                'message' => 'You can only create one address of type ' . $request->address_type,
            ], 422);
        }

        if ($request->set_as_default == 'yes') {
            CustomerAddress::where('customer_id', $request->customer_id)->update(['set_as_default' => 'no']);
        }

        if ($request->address_id) {
            $address = CustomerAddress::where('id', $request->address_id)->where('customer_id', $request->customer_id)->first();
            if (!$address) {
                return response()->json(['status' => false, 'message' => 'Address not found'], 404);
            } 
            $address->update($request->only([
                'address_type', 'address', 'pincode', 'city_name', 'state_name', 'set_as_default'
            ]));
            $message = 'Address updated successfully'; 
        } else {
            $address = CustomerAddress::create([ 
                'customer_id'    => $request->customer_id,
                'address_type'   => $request->address_type,
                'address'        => $request->address,
                'pincode'        => $request->pincode,
                'city_name'      => $request->city_name,
                'state_name'     => $request->state_name,
                'set_as_default' => $request->set_as_default ?? 'no',
            ]);
            $message = 'Address created successfully';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $address
        ]);
    }

    public function deleteAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'  => 'required|numeric|exists:customer_addresses,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        } 

        $address = CustomerAddress::where('id', $request->id)->first();

        if (!$address) {
            return response()->json(['status' => false, 'message' => 'Address not found'], 404);
        }

        $address->delete(); 

        return response()->json([
            'success' => true,
            'message' => 'Address deleted successfully'
        ]);
    }

    
}