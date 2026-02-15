<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductsController extends Controller
{


    public function admin_index(Request $request)
    {

        return view('admin_products', ['rs' => \App\Models\Products::list()]);
    }

    public function admin_product_edit($sku)
    {
        $product = \App\Models\Products::get($sku);

        return view('admin_product_edit', ['product' => $product[0]]);
    }


    public function admin_products_delete(Request $request)
    {
        $sku = $request['sku'];


        \App\Models\Products::delete($sku);

        return view('admin_products', ['rs' => \App\Models\Products::list()]);
    }

    public function admin_products_update(Request $request)
    {

        $sku = $request['sku'];
        $name = $request['name'];
        $description = $request['description'];
        $price = $request['price'];
        $image = $request->file('image');
        $material = $request['material'];
        $length = $request['length'];
        $gemstone = $request['gemstone'];
        $clasp_type = $request['clasp_type'];
        $style = $request['style'];


        // store uploads in public/uploads (cross-platform)
        $uploadDir = public_path('uploads') . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if ($image) {
            $filename = $image->getClientOriginalName();
            $image->move($uploadDir, $filename);
            // store path relative to public so views can use asset('uploads/...')
            $imagePath = 'uploads/' . $filename;
        } else {
            $imagePath = \App\Models\Products::get($sku)[0]->image;
        }


        \App\Models\Products::update($sku, $name, $description, $price, $imagePath, $material, $length, $gemstone, $clasp_type, $style);

        return view('admin_products', ['rs' => \App\Models\Products::list()]);
    }

    public function admin_products_add(Request $request)
    {
        $sku = $request['sku'];
        $name = $request['name'];
        $description = $request['description'];
        $price = $request['price'];
        $image = $request->file('image');
        $material = $request['material'];
        $length = $request['length'];
        $gemstone = $request['gemstone'];
        $clasp_type = $request['clasp_type'];
        $style = $request['style'];

        
        // store uploads in public/uploads (cross-platform)
        $uploadDir = public_path('uploads') . DIRECTORY_SEPARATOR;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if ($image) {
            $filename = $image->getClientOriginalName();
            $image->move($uploadDir, $filename);
            // store path relative to public so views can use asset('uploads/...')
            $imagePath = 'uploads/' . $filename;
        } else {
            $imagePath = \App\Models\Products::get($sku)[0]->image;
        }

        \App\Models\Products::add($sku, $name, $description, $price, $imagePath, $material, $length, $gemstone, $clasp_type, $style);

        return view('admin_products', ['rs' => \App\Models\Products::list()]);
    }

    public function index(Request $request)
    {

        return view('home', ['rs' => \App\Models\Products::list()]);
    }

    public function get(Request $request, $sku)
    {

        return view('products', ['products' => \App\Models\Products::get($sku)[0]]);
    }
}
