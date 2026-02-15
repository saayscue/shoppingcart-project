<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Customers
{
    public static function get($email)
    {
        $params = [
            $email
        ];

        $sql = "SELECT *
                FROM customers
                WHERE email = ?";

        try {
            $rs = DB::select($sql, $params);
        } catch (\Illuminate\Database\QueryException $e) {
            $rs = [];
        }

        return $rs;
    }
    public static function add($email, $first_name, $last_name, $phone_number)
    {
        $params = [
            $email,
            $first_name,
            $last_name,
            $phone_number
        ];

        $sql = "INSERT INTO customers(email, first_name, last_name, phone_number)
                VALUES(?, ?, ?, ?)";

        try {
            DB::insert($sql, $params);
            $rs = true;
        } catch (\Illuminate\Database\QueryException $e) {
            $rs = false;
        }

        return $rs;
    }
}
