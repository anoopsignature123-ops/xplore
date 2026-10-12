<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ContactType;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    /**
     * Fetch active Contact Types for dynamic dropdown in Contact Us form.
     */
    public function getContactTypes(Request $request)
    {
        $contactTypes = ContactType::select('id', 'name')
            ->where('status', 'Active')
            ->orderBy('name', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Contact types fetched successfully',
            'data' => $contactTypes,
        ]);
    }

    /**
     * Submit Contact Us Query.
     */
    public function submitContactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'           => 'required|string|max:255',
            'message'         => 'required|string',
            'contact_type_id' => 'nullable|exists:contact_types,id',
            'type'            => 'nullable|string|max:255',
            'name'            => 'nullable|string|max:255',
            'email'           => 'nullable|email|max:255',
            'phone'           => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $customer = auth('sanctum')->user() ?? $request->user();
        $customerId = $customer ? $customer->id : null;

        $type = $request->type;
        if (!empty($request->contact_type_id)) {
            $cType = ContactType::find($request->contact_type_id);
            if ($cType) {
                $type = $cType->name;
            }
        }

        $contactUs = ContactUs::create([
            'customer_id'     => $customerId,
            'contact_type_id' => $request->contact_type_id,
            'name'            => $request->name ?? ($customer ? $customer->name : null),
            'email'           => $request->email ?? ($customer ? ($customer->email_id ?? $customer->email) : null),
            'phone'           => $request->phone ?? ($customer ? ($customer->phone_no ?? $customer->phone) : null),
            'type'            => $type,
            'title'           => trim($request->title),
            'message'         => trim($request->message),
            'status'          => 'Pending',
        ]);

        return response()->json([
            'status'  => true,
            'message' => 'Your Contact Us query has been submitted successfully.',
            'data'    => $contactUs,
        ]);
    }

    /**
     * Fetch list of Contact Us queries submitted by the logged-in customer.
     */
    public function myContactQueries(Request $request)
    {
        $customer = auth('sanctum')->user() ?? $request->user();
        if (!$customer) {
            return response()->json([
                'status'  => false,
                'message' => 'Unauthorized customer token',
            ], 401);
        }

        $perPage = $request->per_page_record ?? 10;
        $page    = $request->page_no ?? 1;

        $queries = ContactUs::with('contactType:id,name')
            ->where('customer_id', $customer->id)
            ->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'status'  => true,
            'message' => 'Contact queries fetched successfully',
            'data'    => $queries->items(),
            'pagination' => [
                'total'        => $queries->total(),
                'per_page'     => $queries->perPage(),
                'current_page' => $queries->currentPage(),
                'last_page'    => $queries->lastPage(),
            ]
        ]);
    }
}
