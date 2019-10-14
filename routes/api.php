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

//buyers
Route::resource('buyers','Buyer\BuyerController');
Route::resource('buyers.sellers','Buyer\BuyerSellerController');
Route::resource('buyers.products','Buyer\BuyerProductController');
Route::resource('buyers.transactions','Buyer\BuyerTransactionController');
Route::resource('buyers.categories','Buyer\BuyerCategoryController');

//categories
Route::resource('categories','Category\CategoryController');
Route::resource('categories.products','Category\CategoryProductController');
Route::resource('categories.sellers','Category\CategorySellerController');
Route::resource('categories.transactions','Category\CategoryTransactionController');
Route::resource('categories.buyers','Category\CategoryBuyerController');

//products
Route::resource('products','Product\ProductController',['only' => ['index', 'show']]);

//transactions
Route::resource('transactions','Transaction\transactionController',['only' => ['index', 'show']]);
Route::resource('transactions.categories','Transaction\TransactionCategoryController',['only' => ['index', 'show']]);
Route::resource('transactions.sellers','Transaction\TransactionSellerController',['only' => ['index', 'show']]);

//user
Route::resource('user','User\UserController');

//sellers
Route::resource('sellers','Seller\SellerController');
Route::resource('sellers.transactions','Seller\SellerTransactionController');
Route::resource('sellers.categories','Seller\SellerCategoryController');
Route::resource('sellers.buyers','Seller\SellerBuyerController');
Route::resource('sellers.products','Seller\SellerProductController');
