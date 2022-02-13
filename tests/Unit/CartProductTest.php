<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Author;
use App\Models\Book;
use App\Models\Cart;
use App\Models\CartProduct;

class CartProductTest extends TestCase
{
    
    public function test_creating_cart_products()
    {
        $cart = Cart::factory()->hasCartProducts(1, function(array $attributes){
            $author = Author::factory()->create();
            $book = Book::factory([
                'author_id' => $author->id
            ])->create();
            return ['book_id' => $book->id, 'price' => $book->price, 'type' => $book->type];
        })->create();
        $this->assertModelExists($cart);
        $this->assertDatabaseHas('cart_products', [
            'cart_id' => $cart->id,
        ]);
    }

    public function test_updating_cart_products()
    {
        $cart = Cart::factory()->hasCartProducts(3, function(array $attributes){
            $author = Author::factory()->create();
            $book = Book::factory([
                'author_id' => $author->id
            ])->create();
            return ['book_id' => $book->id, 'price' => $book->price, 'type' => $book->type];
        })->create();
        $this->assertModelExists($cart);

        $cart_product = CartProduct::CartID($cart->id)->first();
        $cart_product->quantity = 99;
        $cart_product->save();

        $this->assertDatabaseHas('cart_products', [
            'cart_id'  => $cart->id,
            'quantity' => 99,
        ]);
    }

    public function test_deleting_cart_products()
    {
        $cart = Cart::factory()->hasCartProducts(3, function(array $attributes){
            $author = Author::factory()->create();
            $book = Book::factory([
                'author_id' => $author->id
            ])->create();
            return ['book_id' => $book->id, 'price' => $book->price, 'type' => $book->type];
        })->create();
        $this->assertModelExists($cart);

        $cart_product = CartProduct::CartID($cart->id)->first();
        $cart_product->delete();

        $this->assertModelMissing($cart_product);
    }
}
