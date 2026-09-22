<?php

namespace App\Http\Controllers\Api\V1\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Validator;


class CartController extends Controller
{
   


    public function viewCart(Request $request)
{
    $validator = Validator::make($request->all(), [
        'user_id'         => 'required|string',
        'page_no'         => 'nullable|string|min:1',
        'per_page_record' => 'nullable|string|min:1',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status'  => false,
            'message' => $validator->errors()->first(),
        ], 422);
    }

    $userId = $request->user_id;
    $cart = Cart::firstOrCreate(['user_id' => $userId]);

    $perPage = $request->per_page_record ?? 10;
    $page    = $request->page_no ?? 1;

    $cartItems = CartItem::with('product:id,image') // Load only id & image
        ->where('cart_id', $cart->id)
        ->paginate($perPage, ['*'], 'page', $page);

    $data = collect($cartItems->items())->map(function ($item) {

        $item->product_image = $item->product?->image
            ? asset($item->product->image) // change path if needed
            : null;

        unset($item->product); // Remove nested product object if you only want image

        return $item;
    });

    return response()->json([
        'status' => true,
        'message' => 'Cart fetched successfully',
        'cart_id' => $cart->id,
        'cart_total' => number_format(
            CartItem::where('cart_id', $cart->id)->sum('line_total'),
            2,
            '.',
            ''
        ),
        'data' => $data,
    ]);
}


    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'    => 'required|string',
            'product_id' => 'required|string|exists:products,id',
            'variant_id' => 'nullable|string|exists:product_variants,id',
            'quantity'   => 'required|string|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userId = $request->user_id;
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        $product = Product::with(['category', 'subCategory', 'brand'])->find($request->product_id);
        $variant = null;
        if ($request->variant_id) {
            $variant = ProductVariant::find($request->variant_id);
        }

        // Stock check
        $availableStock = $variant ? $variant->stock : $product->stock;

        $salePrice = $variant ? $variant->sale_price : $product->sale_price;
        $mrpPrice = $variant ? $variant->mrp_price : $product->mrp_price;

        // Check if item already exists in cart, update quantity if it does
        $cartItem = CartItem::where('cart_id', $cart->id)
                            ->where('product_id', $request->product_id)
                            ->where('variant_id', $request->variant_id)
                            ->first();

        $currentQuantity = $cartItem ? $cartItem->quantity : 0;
        $newQuantity = $currentQuantity + (int)$request->quantity;

        if ($newQuantity > $availableStock) {
            return response()->json([
                'status' => false,
                'message' => 'Requested quantity exceeds available stock.',
                'available_stock' => $availableStock
            ], 400);
        }

        $lineTotal = $salePrice * $newQuantity;

        if ($cartItem) {
            $cartItem->quantity = $newQuantity;
            $cartItem->line_total = $lineTotal;
            $cartItem->save();
        } else {
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'variant_id' => $variant ? $variant->id : null,
                'product_name' => $product->product_name,
                'variant_name' => $variant ? $variant->variant_name : null,
                'category_name' => $product->category ? $product->category->category_name : null,
                'sub_category_name' => $product->subCategory ? $product->subCategory->sub_category_name : null,
                'brand_name' => $product->brand ? $product->brand->brand_name : null,
                'mrp_price' => $mrpPrice,
                'sale_price' => $salePrice,
                'quantity' => $newQuantity,
                'line_total' => $lineTotal,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Item added to cart successfully',
            'data' => $cartItem
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'      => 'required|string',
            'cart_item_id' => 'required|string|exists:cart_items,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userId = $request->user_id;
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json(['status' => false, 'message' => 'Cart not found'], 404);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)->where('id', $request->cart_item_id)->first();

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['status' => true, 'message' => 'Item removed from cart']);
        }

        return response()->json(['status' => false, 'message' => 'Item not found in cart'], 404);
    }

    public function reduceQuantity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id'      => 'required|string',
            'cart_item_id' => 'required|string|exists:cart_items,id',
            'quantity'     => 'nullable|string|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $userId = $request->user_id;
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json(['status' => false, 'message' => 'Cart not found'], 404);
        }

        $cartItem = CartItem::where('cart_id', $cart->id)->where('id', $request->cart_item_id)->first();

        if ($cartItem) {
            $reduceBy = $request->has('quantity') ? (int)$request->quantity : 1;
            $newQuantity = $cartItem->quantity - $reduceBy;

            if ($newQuantity <= 0) {
                $cartItem->delete();
                return response()->json(['status' => true, 'message' => 'Item removed from cart']);
            }

            $cartItem->quantity = $newQuantity;
            $cartItem->line_total = $cartItem->sale_price * $newQuantity;
            $cartItem->save();

            return response()->json([
                'status' => true,
                'message' => 'Quantity reduced successfully',
                'data' => $cartItem
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Item not found in cart'], 404);
    }
}
