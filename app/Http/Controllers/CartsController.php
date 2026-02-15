<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



class CartsController extends Controller
{
    public function cartIndex()
    {
        $cartId = session('cart_id');

        if (!$cartId) {
            return view('cart', [
                'cartItems' => [],
                'totalItems' => 0,
                'totalCost' => 0.00
            ]);
        }

        $cartItems = \App\Models\Carts::getCartItems($cartId);
        $totalItems = array_sum(array_column($cartItems, 'quantity'));
        $totalCost = array_sum(array_map(function ($item) {
            return $item->price * $item->quantity;
        }, $cartItems));

        return view('cart', [
            'cartItems' => $cartItems,
            'totalItems' => $totalItems,
            'totalCost' => $totalCost
        ]);
    }

    public function addProductToCart(Request $request, $sku)
    {
        // Ensure there is a cart for the user, create if not
        $cartId = session('cart_id') ?: \App\Models\Carts::getCart();

        $product = \App\Models\Carts::addToCart($sku);

        if (!$product) {
            return view('cart', [
                'cartItems' => [],
                'totalItems' => 0,
                'totalCost' => 0.00
            ]);
        }

        $cartItems = \App\Models\Carts::getCartItems($cartId);
        $totalItems = array_sum(array_column($cartItems, 'quantity'));
        $totalCost = array_sum(array_map(function ($item) {
            return $item->price * $item->quantity;
        }, $cartItems));

        return view('cart', [
            'cartItems' => $cartItems,
            'totalItems' => $totalItems,
            'totalCost' => $totalCost
        ]);
    }

    public function removeProductFromCart(Request $request)
    {
        $sku = $request['sku'];
        $cartId = session('cart_id');

        \App\Models\Carts::delete($cartId, $sku);

        $cartItems = \App\Models\Carts::getCartItems($cartId);
        $totalItems = array_sum(array_column($cartItems, 'quantity'));
        $totalCost = array_sum(array_map(function ($item) {
            return $item->price * $item->quantity;
        }, $cartItems));

        return view('cart', [
            'cartItems' => $cartItems,
            'totalItems' => $totalItems,
            'totalCost' => $totalCost
        ]);
    }

    public function updateQuantity(Request $request)
    {
        $sku = $request['sku'];
        $quantity = $request['quantity'];
        $cartId = session('cart_id');

        \App\Models\Carts::update($cartId, $sku, $quantity);

        $cartItems = \App\Models\Carts::getCartItems($cartId);
        $totalItems = array_sum(array_column($cartItems, 'quantity'));
        $totalCost = array_sum(array_map(function ($item) {
            return $item->price * $item->quantity;
        }, $cartItems));

        return view('cart', [
            'cartItems' => $cartItems,
            'totalItems' => $totalItems,
            'totalCost' => $totalCost
        ]);
    }
}
