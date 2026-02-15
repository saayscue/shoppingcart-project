<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Carts
{

    public static function list($show_deleted = false)
    {

        $cart_id = session('cart_id');

        if (!$cart_id) {
            return [];
        }

        $sql = "SELECT * 
        FROM cart_items WHERE cart_id = ?";

        $params = [
            'cart_id' => $cart_id
        ];

        if ($show_deleted == false) {
            $sql .= " AND deleted = false";
        }

        try {

            $rs = DB::select($sql, $params);
        } catch (\Illuminate\Database\QueryException $e) {
            $rs = [];
        }

        return $rs;
    }

    public static function getCart()
    {
        $cart_id = session('cart_id');

        if (!$cart_id) {
            try {
                $cart_id = DB::table('carts')->insertGetId([
                    'isinorder' => false,
                ], 'cart_id');
                session(['cart_id' => $cart_id]);
            } catch (\Illuminate\Database\QueryException $e) {
                return null;
            }
        }

        return $cart_id;
    }

    public static function addToCart($sku)
    {
        $cartId = self::getCart();

        $cart = DB::select("SELECT isinorder FROM carts WHERE cart_id = ?", [$cartId]);
        if (!empty($cart) && $cart[0]->isinorder) {
            return null;
        }

        try {
            $params = [
                $sku
            ];

            $sql = "SELECT * FROM products WHERE sku = ?";
            $product = DB::select($sql, $params);

            if (empty($product)) {
                return null;
            }

            $product = $product[0];
            $cartId = self::getCart();

            $params = [
                $cartId,
                $sku
            ];

            $sql = "SELECT * FROM cart_items WHERE cart_id = ? AND sku = ?";
            $existingItem = DB::select($sql, $params);

            if ($existingItem) {
                $sql = "UPDATE cart_items SET quantity = quantity + 1 WHERE cart_id = ? AND sku = ?";
                DB::update($sql, $params);
            } else {
                $params = [
                    $cartId,
                    $sku,
                    $product->price
                ];

                $sql = "INSERT INTO cart_items (cart_id, sku, quantity, price) VALUES (?, ?, 1, ?)";
                DB::insert($sql, $params);
            }

            session([
                'sku' => $sku,
                'product_name' => $product->name,
                'product_price' => $product->price
            ]);

            return $product;
        } catch (\Illuminate\Database\QueryException $e) {
            return null;
        }
    }


    public static function getCartItems($cartId)
    {
        $params = [
            $cartId
        ];

        $sql = "SELECT 
                cart_items.sku, 
                products.name, 
                cart_items.quantity, 
                products.price, 
                products.image 
            FROM cart_items 
            INNER JOIN products ON cart_items.sku = products.sku 
            WHERE cart_items.cart_id = ? 
            AND cart_items.deleted = false
            AND products.deleted = false
            AND EXISTS (
                SELECT 1 FROM carts WHERE carts.cart_id = cart_items.cart_id AND carts.isinorder = false
            )";
        try {
            $cartItems = DB::select($sql, $params);
        } catch (\Illuminate\Database\QueryException $e) {
            $cartItems = [];
        }

        return $cartItems;
    }

    public static function getTotalItems($cart_id)
    {
        $params = [
            $cart_id
        ];

        try {
            $sql = "SELECT SUM(quantity) as total_items FROM cart_items WHERE cart_id = ?";
            $result = DB::select($sql, $params);
        } catch (\Illuminate\Database\QueryException $e) {
            return 0;
        }
        return $result[0]->total_items ?? 0;
    }

    public static function getTotalCost($cart_id)
    {
        $params = [
            $cart_id
        ];

        try {
            $sql = "SELECT SUM(price * quantity) as total_cost FROM cart_items WHERE cart_id = ?";
            $result = DB::select($sql, $params);
        } catch (\Illuminate\Database\QueryException $e) {
            return 0.00;
        }
        return $result[0]->total_cost ?? 0.00;
    }

    public static function delete($cart_id, $sku)
    {
        if (!$cart_id || !$sku) {
            return false;
        }

        $params = [
            $cart_id,
            $sku
        ];

        $sql = "UPDATE cart_items
                SET deleted = true
                WHERE cart_id = ? AND sku = ?";

        try {
            DB::update($sql, $params);
            $rs = true;
        } catch (\Illuminate\Database\QueryException $e) {
            $rs = false;
        }

        return $rs;
    }

    public static function update($cart_id, $sku, $quantity)
    {
        $params = [
            $quantity,
            $cart_id,
            $sku
        ];

        $sql = "UPDATE cart_items 
                SET quantity = ? 
                WHERE cart_id = ? 
                AND sku = ?";

        try {

            DB::update($sql, $params);
            return true;
        } catch (\Illuminate\Database\QueryException $e) {
            return false;
        }
    }
}
