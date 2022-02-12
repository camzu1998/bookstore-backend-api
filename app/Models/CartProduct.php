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
        'type' => false,
        'price' => false,
    ];

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
