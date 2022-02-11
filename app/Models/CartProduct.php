<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartProduct extends Model
{
    use HasFactory;

    protected $table = 'cart_products';
    protected $attributes = [
        'cart_id' => false,
        'book_id' => false,
        'type' => false,
        'price' => false,
    ];
}
