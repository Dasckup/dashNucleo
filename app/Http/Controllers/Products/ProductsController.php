<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {

        $products = Products::get();

        return view('pages.products.index', [
            'products' => $products
        ]);
    }
}
