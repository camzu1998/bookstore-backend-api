<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\CartProduct;
use App\Models\Book;
use App\Models\Author;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';
    protected $attributes = [
        'cart_token' => false,
        'total_price' => false,
    ];

    /**
     * Scope a query to only include cart who has cart_token equals $token
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $token
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCartToken($query, string $token)
    {
        return $query->where('cart_token', 'LIKE', $token);
    }

    /**
     * Get the books for the book author.
     */
    public function cartProducts()
    {
        return $this->hasMany(CartProduct::class);
    }
}
