<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController
{
    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $product = Product::all();
        return $this->showAll($product);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Product $product)
    {
        return $this->showOne($product);
    }

}
