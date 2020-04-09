<?php

namespace App\Http\Controllers\Buyer;

use App\Buyer;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

class BuyerCategoryController extends ApiController
{

    /**
     * @param Buyer $buyer
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Buyer $buyer)
    {
//        $categories = $buyer->transactions()->with('product.categories')->get();

        $categories = $buyer->transactions()->with('product.categories')->get()
            ->pluck('product.categories')
            ->collapse();
//        $categories = $buyer->transactions()->with('product.categories')
//            ->get()
//            ->pluck('product.categories')
//            ->unique('id')
//            ->values();
        return $this->showAll($categories);
    }

}
