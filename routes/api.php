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

Route::group(
    ['prefix' => 'auth'],
    function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('refresh', 'AuthController@refresh');
    }
);

Route::group(['middleware' => 'jwt.verify'], function () {
    Route::resource('buyers', 'Buyer\BuyerController');
    Route::resource('buyers.transactions', 'Buyer\BuyerTransactionController', ['only' => ['index']]);
    Route::resource('buyers.products', 'Buyer\BuyerProductController', ['only' => ['index']]);
    Route::resource('buyers.sellers', 'Buyer\BuyerSellerController', ['only' => ['index']]);
    Route::resource('buyers.categories', 'Buyer\BuyerCategoryController', ['only' => ['index']]);

    Route::resource('categories', 'Category\CategoryController', ['except' => ['create', 'edit']]);
    Route::resource('categories.products', 'Category\CategoryProductController', ['only' => ['index']]);
    Route::resource('categories.sellers', 'Category\CategorySellerController', ['only' => ['index']]);
    Route::resource('categories.transactions', 'Category\CategoryTransactionController', ['only' => ['index']]);
    Route::resource('categories.buyers', 'Category\CategoryBuyerController', ['only' => ['index']]);


    Route::resource('sellers', 'Seller\SellerController', ['only' => ['index', 'show']]);
    Route::resource('sellers.categories', 'Seller\SellerCategoryController', ['only' => ['index']]);
    Route::resource('sellers.transactions', 'Seller\SellerTransactionController', ['only' => ['index']]);
    Route::resource('sellers.products', 'Seller\SellerProductController', ['except' => ['create', 'show', 'edit']]);
    Route::resource('sellers.buyers', 'Seller\SellerBuyerController', ['only' => ['index']]);


    Route::resource('products', 'Product\ProductController', ['except' => ['create', 'edit']]);
    Route::resource('products.transactions', 'Product\ProductTransactionController', ['only' => ['index']]);
    Route::resource('products.buyers', 'Product\ProductBuyerController', ['only' => ['index']]);
    Route::resource('products.categories', 'Product\ProductCategoryController', ['only' => ['index', 'update', 'destroy']]);
    Route::resource('products.buyers.transactions', 'Product\ProductBuyerTransactionController', ['only' => ['store']]);


    Route::resource('transactions', 'Transaction\TransactionController', ['except' => ['create', 'edit']]);
    Route::resource('transactions.categories', 'Transaction\TransactionCategoryController', ['only' => ['index']]);
    Route::resource('transactions.sellers', 'Transaction\TransactionSellerController', ['only' => ['index']]);


    Route::resource('user', 'User\UserController');
    Route::name('verify')->get('user/verify/{token}', 'User\UserController@verify');
    Route::name('resend')->get('user/{user}/resend', 'User\UserController@resend');


    Route::get('logout', 'AuthController@logout');
    Route::get('refresh', 'AuthController@refresh');
});

