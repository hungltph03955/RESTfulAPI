<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('buyers','Buyer\BuyerController');
Route::resource('categories','Category\CategoryController',['only' => ['index', 'show']]);
Route::resource('products','Product\ProductController',['only' => ['index', 'show']]);
Route::resource('transactions','Transaction\transactionController',['only' => ['index', 'show']]);
Route::resource('user','User\UserController');
Route::resource('sellers','Seller\SellerController');
