<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
  use SoftDeletes;

  protected $dates = ['delete_at'];

  protected $fillable = [
    'quantity',
    'buyers_id',
    'product_id'
  ];

  public function buyer() {
    return $this->belongsTo(Buyer::class);
  }

  public function product() {
    return $this->belongsTo(Product::class);
  }
}