<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

class Products
{

    public static function list($show_deleted = false)
    {
        $sql = "SELECT *
                FROM products";
        if ($show_deleted == false) {
            $sql .= " WHERE deleted = false";
        }

        try {
            $rs = DB::select($sql);
        } catch (\Illuminate\Database\QueryException $e) {
            $rs = [];
        }
        return $rs;
    }


    public static function get($sku)
    {

        $params = [
            $sku
        ];

        $sql = "SELECT *
                FROM products
                WHERE sku = ?";
        try {
            $rs = DB::select($sql, $params);
        } catch (\Illuminate\Database\QueryException $e) {
            $rs = [];
        }
        return $rs;
    }


    public static function add($sku, $name, $description, $price, $image, $material, $length, $gemstone, $clasp_type, $style)
    {

        $params = [
            $sku,
            $name,
            $description,
            $price,
            $image,
            $material,
            $length,
            $gemstone,
            $clasp_type,
            $style
        ];

        $sql = "INSERT INTO products(sku,name,description,price,image,material,length,gemstone,clasp_type,style)
         VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        try {
            DB::insert($sql, $params);
            $rs = true;
        } catch (\Illuminate\Database\QueryException $e) {
            $rs = false;
        }
        return $rs;
    }

    public static function update($sku, $name, $description, $price, $image, $material, $length, $gemstone, $clasp_type, $style)
    {

        $params = [
            $name,
            $description,
            $price,
            $image,
            $material,
            $length,
            $gemstone,
            $clasp_type,
            $style,
            $sku
        ];

        $sql = "UPDATE products
        SET name = ?,
            description = ?,
            price = ?,
            image = ?,
            material = ?,
            length = ?,
            gemstone = ?,
            clasp_type = ?,
            style = ?
        WHERE sku = ?";

        try {
            DB::update($sql, $params);
            $rs = true;
        } catch (\Illuminate\Database\QueryException $e) {
            $rs = false;
        }
        return $rs;
    }


    public static function delete($sku)
    {
        $params = [
            $sku
        ];

        $sql = "UPDATE products
        SET deleted = true
        WHERE sku = ?";

        try {
            DB::update($sql, $params);
            $rs = true;
        } catch (\Illuminate\Database\QueryException $e) {
            $rs = false;
        }
        return $rs;
    }
}
