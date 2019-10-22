<?php

namespace App\Transformers;

use App\Translation;
use League\Fractal\TransformerAbstract;

class TransactionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Translation $translation)
    {
        return [
            'identifier' => (int)$translation->id,
            'quantity' => (string)$translation->quantity,
            'buyer' => (string)$translation->buyer_id,
            'product' => (string)$translation->product_id,
            'creationDate' => (int)$translation->created_at,
            'lastChange' => (int)$translation->updated_at,
            'deletedDate' => isset($translation->deleted_at) ? (string) $translation->deleted_at : null,
        ];
    }
}
