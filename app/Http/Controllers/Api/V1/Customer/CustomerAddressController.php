<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\Validator;

class CustomerAddressController extends Controller 
{
    public function addressList(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_id' => 'required|string',
        ]); 

        if ($validator->fails()) {
            return response()->json([
                'status'  => false, 
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $addresses = CustomerAddress::where('customer_id', $request->customer_id)->select('id', 'address_type', 'address', 'pincode', 'city_name', 'state_name', 'set_as_default')->get();

        return response()->json([
            'status' => true,
            'message' => 'Customer addresses fetched successfully',
            'data' => $addresses,
        ]);
    }  


    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address_id'  => 'required|string|exists:customer_addresses,id',
            'customer_id' => 'required|string',
        ]); 

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422); 
        } 

        $address = CustomerAddress::where('id', $request->address_id)->where('customer_id', $request->customer_id)->first();

        if (!$address) {
            return response()->json(['status' => false, 'message' => 'Address not found'], 404);
        } 

        $address->delete(); 

        return response()->json([
            'status' => true,
            'message' => 'Address deleted successfully' 
        ]);
    }


    public function addUpdate(Request $request)
    { 
        $validator = Validator::make($request->all(), [
            'address_id'     => 'nullable|string|exists:customer_addresses,id',
            'customer_id'    => 'required|string', 
            'address_type'   => 'required|in:home,office,other',
            'address'        => 'required|string',
            'pincode' => 'required|string|size:6', 
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
            'status' => true,
            'message' => $message
        ]);
    }
}
