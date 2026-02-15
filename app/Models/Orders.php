<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Orders
{

    public static function processOrder($cart_id, $email, $first_name, $last_name, $phone_number, $street_number, $street_name, $apt_number, $city, $state, $zip, $shipping_method, $total_cost, $total_quantity)
    {
        try {
            $params = [
                $email
            ];

            $sql = "SELECT * FROM customers WHERE email = ?";

            $customer = DB::select($sql, $params);

            if (empty($customer)) {

                $params = [
                    $email,
                    $first_name,
                    $last_name,
                    $phone_number
                ];

                $insertSql = "
                    INSERT INTO customers (email, first_name, last_name, phone_number)
                    VALUES (?, ?, ?, ?)
                ";
                DB::insert($insertSql, $params);
            }


            $params = [
                $cart_id
            ];


            $params = [$cart_id];
            $sql = "
                SELECT 
                    SUM(ci.quantity * p.price) AS total_cost, 
                    SUM(ci.quantity) AS total_quantity
                FROM cart_items ci
                JOIN products p ON ci.sku = p.sku
                WHERE ci.cart_id = ? AND ci.deleted = false AND p.deleted = false
            ";

            $result = DB::select($sql, $params);
            $total_cost = $result[0]->total_cost ?? 0; 
            $total_quantity = $result[0]->total_quantity ?? 0;

            $params = [
                $email,
                $cart_id,
                $street_number,
                $street_name,
                $apt_number ?? null,
                $city,
                $state,
                $zip,
                $shipping_method,
                $total_cost,
                $total_quantity
            ];

            $sql = "
                INSERT INTO orders (email, cart_id, street_number, street_name, apt_number, city, state, zip, shipping_method, total_cost, total_quantity)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
                RETURNING order_id;
            ";

            $order = DB::select($sql, $params);
            $order_id = $order[0]->order_id;

            $params = [
                $order_id,
                $email,
                $cart_id
            ];

            $sql = "
            INSERT INTO order_items (order_id, email, sku, quantity, price)
            SELECT ?, ?, ci.sku, ci.quantity, ci.price
            FROM cart_items ci
            JOIN products p ON ci.sku = p.sku
            WHERE ci.cart_id = ?
              AND ci.deleted = false 
              AND p.deleted = false;
            ";

            DB::insert($sql, $params);

            $params = [
                $cart_id
            ];

            $sql = "
                UPDATE carts
                SET isinorder = true
                WHERE cart_id = ? AND isinorder = false;
            ";

            DB::update($sql, $params);

            $sql = "
                UPDATE cart_items
                SET isinorder = true
                WHERE cart_id = ? AND isinorder = false;
            ";

            DB::update($sql, $params);
        } catch (\Illuminate\Database\QueryException $e) {
            throw new \Exception('Error processing the order: ' . $e->getMessage());
        }
    }

    public static function list($show_deleted = false)
    {
        $sql = " SELECT 
    o.order_id, 
    o.cart_id,
    c.first_name, 
    c.last_name, 
    c.email, 
    c.phone_number, 
    o.street_number, 
    o.street_name, 
    o.apt_number, 
    o.city, 
    o.state, 
    o.zip,
    o.shipping_method,
    o.total_cost,
    o.total_quantity,
    STRING_AGG(
        CONCAT(
        'SKU: ', oi.sku, 
        '<br>Product: ', p.name, 
        '<br>Quantity: ', oi.quantity, 
        '<br>$', oi.price), '<br><br>'
    ) AS products
FROM orders o
JOIN customers c ON o.email = c.email
JOIN order_items oi ON o.order_id = oi.order_id
JOIN products p ON oi.sku = p.sku
WHERE p.deleted = false
GROUP BY 
    o.order_id, o.cart_id, c.first_name, c.last_name, c.email, c.phone_number, 
    o.street_number, o.street_name, o.apt_number, o.city, o.state, o.zip, o.shipping_method, o.total_cost, o.total_quantity
ORDER BY o.order_id;";


        try {
            $orders = DB::select($sql);
            return $orders;
        } catch (\Illuminate\Database\QueryException $e) {
            return [];
        }
    }

    public static function get($order_id)
    {
        $params = [
            'order_id' => $order_id
        ];

        $sql = "SELECT o.order_id, c.first_name, c.last_name, c.email, c.phone_number,
                       o.street_number, o.street_name, o.apt_number, o.city, o.state, o.zip, o.shipping_method, o.total_cost, o.total_quantity
                FROM orders o
                LEFT JOIN customers c ON o.email = c.email
                WHERE o.order_id = :order_id";

        try {
            $order = DB::select($sql, $params);
        } catch (\Illuminate\Database\QueryException $e) {
            $order = [];
        }

        return $order;
    }
}
