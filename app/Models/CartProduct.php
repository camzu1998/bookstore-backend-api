<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Cart;
use App\Models\Book;
class CartProduct extends Model
{
    use HasFactory;

    protected $table = 'cart_products';
    protected $attributes = [
        'cart_id' => false,
        'book_id' => false,
        'quantity'=> 1,
        'type' => false,
        'price' => false,
    ];

    /**
     * Scope a query to only include cart who has cart_token equals $token
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $cart_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCartID($query, int $cart_id)
    {
        return $query->where('cart_id', $cart_id);
    }

    /**
     * Scope a query to only include defined cart product
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $cart_id
     * @param  int  $book_id
     * @param  string  $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCartProduct($query, int $cart_id, int $book_id, string $type)
    {
        return $query->where('cart_id', $cart_id)->where('book_id', $book_id)->where('type', $type);
    }

    /**
     * Get the cart for the cart products
     */
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }
    
    /**
     * Get the book for the cart product
     */
    public function book()
    {
        return $this->hasOne(Book::class);
    }
}
