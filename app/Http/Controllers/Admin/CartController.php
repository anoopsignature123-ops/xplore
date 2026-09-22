<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Cart;

class CartController extends Controller
{
    public function detail($id)
    {
        $cart = Cart::with(['user', 'items.product'])->find($id);

        if (!$cart) {
            return redirect()->route('admin.customer.list')->with('error', 'Cart Not Found');
        }

        $page_title = 'Cart Details';
        return view('admin.cart.detail', compact('cart', 'page_title'));
    }
}
