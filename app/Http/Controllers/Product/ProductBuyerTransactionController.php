<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\ApiController;
use App\Product;
use App\Transaction;
use App\Transformers\TransactionTransformer;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductBuyerTransactionController extends ApiController
{

    public function __construct()
    {
    }

    /**
     * @param Request $request
     * @param Product $product
     * @param User $buyer
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Product $product, User $buyer)
    {
        $rules = [
            'quantity' => 'required|integer|min:1'
        ];

        $this->validate($request, $rules);

        if ($buyer->id == $product->seller_id) {
            return $this->errorResponse("The buyer must be defferent from the seller", Response::HTTP_CONFLICT);
        }

        if (!$buyer->isVerified()) {
            return $this->errorResponse("The buyer must be a verified user", Response::HTTP_CONFLICT);
        }

        if (!$product->seller->isVerified()) {
            return $this->errorResponse("The buyer must be a verified user", Response::HTTP_CONFLICT);
        }

        if (!$product->isAvailable()) {
            return $this->errorResponse("The product is not available", Response::HTTP_CONFLICT);
        }

        if ($product->quantity < $request->quantity) {
            return $this->errorResponse('The product does not have enough units for this transaction', Response::HTTP_CONFLICT);
        }

        return DB::transaction(function () use ($request, $product, $buyer) {
            $product->quantity -= $request->quantity;
            $product->save();

            $transaction = Transaction::create([
                'quantity' => $request->quantity,
                'buyer_id' => $buyer->id,
                'product_id' => $product->id
            ]);

            return $this->showOne($transaction, Response::HTTP_CREATED);
        });
    }
}
