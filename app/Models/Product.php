<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [];

    public $timestamps = true;

    public function price(): HasOne
    {
        return $this->hasOne(ProductPrice::class, 'product_id');
    }

    public function image(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }
}
