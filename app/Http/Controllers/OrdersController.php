<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function admin_order(Request $request)
    {
        $orders = \App\Models\Orders::list();

        return view('admin_order_list', ['orders' => $orders]);
    }

    public function index(Request $request)
    {
        return view('admin_order_list', ['rs' => \App\Models\Orders::list()]);
    }

    public function get(Request $request, $order_id)
    {
        return view('order', ['order' => \App\Models\Orders::get($order_id)]);
    }


    public function showCheckoutForm()
    {
        $cartId = session('cart_id');
        if (!$cartId) {
            return view('checkout');
        }

        return view('checkout');
    }

    public function collectShippingInfo(Request $request)
    {
        $cart_id = session('cart_id');
        $email = $request->email;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $phone_number = $request->phone_number;
        $street_number = $request->street_number;
        $street_name = $request->street_name;
        $apt_number = $request->apt_number;
        $city = $request->city;
        $state = $request->state;
        $zip = $request->zip;
        $shipping_method = $request->shipping_method;
        $total_cost = \App\Models\Carts::getTotalCost($cart_id);  
        $total_quantity = \App\Models\Carts::getTotalItems($cart_id);

        try {
            \App\Models\Orders::processOrder($cart_id, $email, $first_name, $last_name, $phone_number, $street_number, $street_name, $apt_number, $city, $state, $zip,$shipping_method, $total_cost, $total_quantity);
  
            return view('cart', [
                'cartItems' => [],
                'totalItems' => 0,
                'totalCost' => 0.00,
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return view('cart', [
                'cartItems' => [],
                'totalItems' => 0,
                'totalCost' => 0.00,
            ]);
        }
    }
}
