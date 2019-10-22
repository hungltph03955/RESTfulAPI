<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Transformers\CategoryTransformer;

class Category extends Model
{

  use SoftDeletes;

  protected $dates = ['delete_at'];

  public $transformer = CategoryTransformer::class;

  protected $fillable = [
    'name',
    'description'
  ];

  protected $hidden = [
      'pivot'
  ];

  public function products() {
    return $this->belongsToMany(Product::class);
  }
}
