<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $fillable = [
        'product_id',
        'customer_id',
        'qty',
        'price',
        'total',
        'status'
    ];

    public $timestamps = TRUE;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
