<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPromo extends Model
{
    use HasFactory;

    protected $table = 'promo_product';
    protected $fillable = [];

    public $timestamps = TRUE;
}