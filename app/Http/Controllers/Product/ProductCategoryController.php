<?php

namespace App\Http\Controllers\Product;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductCategoryController extends ApiController
{

    /**
     * ProductCategoryController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Product $product)
    {
        $categories = $product->categories;
        return $this->showAll($categories);
    }

    public function update(Request $request, Product $product, Category $category)
    {
//        attach : them
//        sync : xoa r them
//        syncWithoutDetach
        $product->categories()->attach([$category->id]);
        return $this->showAll($product->categories);
    }

    public function destroy(Product $product, Category $category)
    {
        if (!$product->categories()->find($category->id)) {
            return $this->errorResponse('The specified category is not a category of this product', Response::HTTP_NOT_FOUND);
        }
        $product->categories()->detach($category->id);
        return $this->showAll($product->categories);
    }
}
