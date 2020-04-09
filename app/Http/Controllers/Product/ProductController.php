<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{

    public function index()
    {
        $product = Product::all();
        return $this->showAll($product);
    }


    public function store(Request $request)
    {
        //
    }

    public function show(Product $product)
    {
        return $this->showOne($product);
    }

    public function update(Request $request, Product $product)
    {
        //
    }

    public function destroy(Product $product)
    {
        //
    }
}
