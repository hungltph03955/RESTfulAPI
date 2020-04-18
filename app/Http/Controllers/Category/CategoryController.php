<?php

namespace App\Http\Controllers\Category;

use App\Category;
use App\Http\Controllers\ApiController;
use App\Transformers\CategoryTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{

    public function __construct()
    {
        $this->middleware('client.credentials')->only(['index', 'show']);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::all();
        return $this->showAll($categories);
    }


    /**
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Category $category)
    {
        return $this->showOne($category);
    }


    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required'
        ];
        $this->validate($request, $rules);
        $newCategory = Category::create($request->all());
        return $this->showOne($newCategory, Response::HTTP_CREATED);
    }


    /**
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Category $category)
    {
        $category->fill($request->only([
            'name',
            'description'
        ]));

        if ($category->isClean()) {
            return $this->errorResponse("You need to specify any different value to update", Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category->save();
        return $this->showOne($category);
    }

    /**
     * @param Category $category
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return $this->showOne($category);
    }
}
