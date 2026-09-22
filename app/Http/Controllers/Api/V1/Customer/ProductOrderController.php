<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\ProductOrder;
use App\Models\ProductOrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class ProductOrderController extends Controller
{
    
 public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|string|exists:customers,id',
            'address_id' => 'required|string|exists:customer_addresses,id',
        ]);
 
        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Check User
        $user = Customer::find($request->user_id);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        // Check Address
        $customerAddress = CustomerAddress::where('id', $request->address_id)
            ->where('customer_id', $user->id)
            ->first();

        if (!$customerAddress) {
            return response()->json([
                'status' => false,
                'message' => 'Address not found for this customer.'
            ], 404);
        }

        // Check Cart
        $cart = Cart::with('items')->where('user_id', $user->id)->first();

        if (!$cart || $cart->items->count() == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Cart is empty.'
            ], 400);
        }

        $subtotal   = $cart->items->sum('line_total');
        $grandTotal = $subtotal;

        // Create Order
        $order = ProductOrder::create([
            'order_number'     => 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
            'user_id'          => $user->id,
            'customer_name'    => $user->name ?? '',
            'customer_mobile'  => $user->phone_no ?? '',
            'customer_email'   => $user->email_id ?? '',
            'address_type'     => $customerAddress->address_type ?? '',
            'address'          => $customerAddress->address ?? '',
            'city_name'        => $customerAddress->city_name ?? '',
            'state_name'       => $customerAddress->state_name ?? '',
            'pincode'          => $customerAddress->pincode ?? '',
            'subtotal'         => $subtotal,
            'tax'              => 0,
            'tax_percentage'   => 0,
            'grand_total'      => $grandTotal,
            'payment_status'   => 'pending',
            'order_status'     => 'pending',
            'notes'            => '',
        ]);

        if (!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to place order.'
            ], 500);
        }

        // Save Order Items
        foreach ($cart->items as $item) {

            $orderItem = ProductOrderItem::create([
                'order_id'          => $order->id,
                'product_id'        => $item->product_id,
                'variant_id'        => $item->variant_id,
                'product_name'      => $item->product_name,
                'variant_name'      => $item->variant_name,
                'category_name'     => $item->category_name,
                'sub_category_name' => $item->sub_category_name,
                'brand_name'        => $item->brand_name,
                'mrp_price'         => $item->mrp_price,
                'sale_price'        => $item->sale_price,
                'quantity'          => $item->quantity,
                'line_total'        => $item->line_total,
            ]);

            if (!$orderItem) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed to create order item.'
                ], 500);
            }

            // Reduce Stock
            if ($item->variant_id) {

                $variant = ProductVariant::find($item->variant_id);

                if ($variant) {
                    $variant->stock = max(0, $variant->stock - $item->quantity);
                    $variant->save();
                }

            } elseif ($item->product_id) {

                $product = Product::find($item->product_id);

                if ($product) {
                    $product->stock = max(0, $product->stock - $item->quantity);
                    $product->save();
                }
            }
        }
 
        // Clear Cart
        $cart->items()->delete();

        return response()->json([
            'status'   => true,
            'message'  => 'Order placed successfully.',
            'order_id' => $order->id
        ], 201);
    }

}
