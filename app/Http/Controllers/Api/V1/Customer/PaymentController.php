<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Transaction;
use App\Models\ProductOrder;
use App\Models\CustomerSurvey;
use App\Models\CourseEnrollment;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    private $api;
 
    public function __construct() 
    {
        // Replace with env variables if available
        $key = env('RAZORPAY_KEY', 'rzp_test_YourKeyIdHere');
        $secret = env('RAZORPAY_SECRET', 'YourSecretKeyHere');
        $this->api = new Api($key, $secret);
    } 

    public function createOrder(Request $request)
    {
        $request->validate([
            'order_type'  => 'required|in:survey,product,rental_product,course',
            'rel_id'      => 'required|string',
            'customer_id' => 'required|exists:customers,id',
            'address_id'  => 'nullable|exists:customer_addresses,id',
        ]);

        $customerAddress = null;

        if ($request->filled('address_id')) {
            $customerAddress = CustomerAddress::where('id', $request->address_id)
                ->where('customer_id', $request->customer_id)
                ->first();
        } else {
            $customerAddress = CustomerAddress::where('customer_id', $request->customer_id)
                ->where('set_as_default', 'yes')
                ->first();
 
            if (!$customerAddress) {
                $customerAddress = CustomerAddress::where('customer_id', $request->customer_id)->first();
            }
        }
 
        if (!$customerAddress) {
            return response()->json(['status' => false, 'message' => 'Address not found for this customer. Please add an address.'], 404);
        }  
  
        // Fetch amount from related tables
        $calculatedAmount = 0; 
        if ($request->order_type === 'product') {
            $record = ProductOrder::find($request->rel_id);
            if (!$record) return response()->json(['status' => false, 'message' => 'Product order not found'], 404);
            $calculatedAmount = $record->grand_total;
        } elseif ($request->order_type === 'survey') {
            $record = CustomerSurvey::find($request->rel_id);
            if (!$record) return response()->json(['status' => false, 'message' => 'Survey not found'], 404);
            $calculatedAmount = $record->amount;
        } elseif ($request->order_type === 'course') {
            $record = CourseEnrollment::find($request->rel_id);
            if (!$record) return response()->json(['status' => false, 'message' => 'Course enrollment not found'], 404);
            $calculatedAmount = $record->amount;
        }

        $customer = \App\Models\Customer::find($request->customer_id);

        DB::beginTransaction(); 
        try { 
            // Create Unified Order 
            $order = Order::create([
                'order_code'      => 'XPL-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                'order_type'      => $request->order_type,
                'rel_id'          => $request->rel_id,
                'customer_id'     => $request->customer_id,
                'customer_name'   => $customer->name ?? '',  
                'customer_mobile' => $customer->phone_no ?? '',
                'customer_email'  => $customer->email_id ?? '',
                'address_type'    => $customerAddress->address_type ?? '',
                'address'         => $customerAddress->address ?? '',
                'city_name'       => $customerAddress->city_name ?? '',
                'state_name'      => $customerAddress->state_name ?? '', 
                'pincode'         => $customerAddress->pincode ?? '',
                'amount'          => $calculatedAmount,
                'notes'           => 'Order for ' . $request->order_type,
                'status'          => 'pending', 
            ]);

            // Create Transaction
            $transaction = Transaction::create([
                'user_id' => $request->customer_id,
                'rel_id'  => $request->rel_id,  
                'txn_for' => $request->order_type,  
                'order_id'=> $order->id, 
                'amount'  => $calculatedAmount,
                'status'  => 'pending',
                'final_status' => 'pending',
                'remarks' => $request->notes ?? 'Payment for ' . $request->order_type,
            ]);

            $orderData = [
                'receipt'         => (string) $order->id, 
                'amount'          => $request->amount * 100,
                'currency'        => 'INR',
                'payment_capture' => 1 // auto capture
            ];

            $razorpayOrderId = 'order_dummy_' . Str::random(10);
            
            // Check if real keys are provided in .env
            $key = env('RAZORPAY_KEY', 'rzp_test_YourKeyIdHere');
            if ($key !== 'rzp_test_YourKeyIdHere') {
                $razorpayOrder = $this->api->order->create($orderData);
                $razorpayOrderId = $razorpayOrder['id'];
            }

            $transaction->razorpay_order_id = $razorpayOrderId;
            $transaction->save();
 
            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Order generated successfully', 
                'data' => [
                    'razorpay_order_id' => $razorpayOrderId,
                    'amount'            => $transaction->amount,
                    'currency'          => 'INR',
                    'key'               => env('RAZORPAY_KEY', 'rzp_test_YourKeyIdHere')
                ] 
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => $e->getMessage()], 500);
        }
    } 

    public function verifyPayment(Request $request)
    { 
        $request->validate([
            'razorpay_order_id'   => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature'  => 'required|string',
        ]);
 
        try {
            $key = env('RAZORPAY_KEY', 'rzp_test_YourKeyIdHere');
            
            if ($key !== 'rzp_test_YourKeyIdHere') { 
                $attributes = [
                    'razorpay_order_id'   => $request->razorpay_order_id, 
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature'  => $request->razorpay_signature
                ];

                $this->api->utility->verifyPaymentSignature($attributes);
            }

            // Signature is valid, update transaction
            $transaction = Transaction::where('razorpay_order_id', $request->razorpay_order_id)->first();
            
            if (!$transaction) {
                return response()->json(['status' => false, 'message' => 'Transaction not found'], 404);
            } 

            $transaction->status = 'success';
            $transaction->final_status = 'success';
            $transaction->razorpay_payment_id = $request->razorpay_payment_id;
            $transaction->razorpay_signature = $request->razorpay_signature;
            $transaction->save();

            // Update the unified order table (Using order_id as per new logic)
            $order = Order::find($transaction->order_id);
            if ($order) {
                $order->status = 'success';
                $order->save();
            }
 
            // Update related entities
            if ($transaction->txn_for === 'survey') {
                CustomerSurvey::where('id', $transaction->rel_id)->update(['payment_status' => 'success']);
            } elseif ($transaction->txn_for === 'course') { 
                CourseEnrollment::where('id', $transaction->rel_id)->update(['payment_status' => 'success']);
            } 
            elseif ($transaction->txn_for === 'product') {
                ProductOrder::where('id', $transaction->rel_id)->update(['payment_status' => 'success']);
            }    
 
            return response()->json([ 
                'status' => true,
                'message' => 'Payment verified successfully'
            ]);

        } catch (\Exception $e) {
            Log::error('Razorpay Signature Verification Failed', [$e->getMessage()]);
            
            // Mark transaction as failed
            Transaction::where('razorpay_order_id', $request->razorpay_order_id)->update([
                'status' => 'failed',
                'final_status' => 'failed'
            ]);

            $transaction = Transaction::where('razorpay_order_id', $request->razorpay_order_id)->first();
            if ($transaction) {
                $order = Order::find($transaction->order_id);
                if ($order) {
                    $order->status = 'failed';
                    $order->save();
                }
            }
            return response()->json(['status' => false, 'message' => 'Payment verification failed'], 400);
        }
    } 
}
