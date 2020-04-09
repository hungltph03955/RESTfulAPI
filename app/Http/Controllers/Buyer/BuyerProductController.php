<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerProductController extends ApiController
{

    /**
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Buyer $buyer)
    {
        $products = $buyer->transactions()->with('product')->get();
//        $products = $buyer->transactions()->with('product')->get()->pluck('product')->pluck('product');
        return $this->showAll($products);
    }

}
