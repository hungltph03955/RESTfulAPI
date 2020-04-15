<?php

namespace App;

use App\Product;
use App\Transformers\CategoryTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'pivot'
    ];

    protected $fillable = [
        'name',
        'description'
    ];

    public $transformer = CategoryTransformer::class;

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
