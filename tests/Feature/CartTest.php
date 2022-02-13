<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Database\Seeders\AuthorSeeder;
use App\Models\Author;
use App\Models\Book;
use App\Models\Cart;
use App\Models\CartProduct;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_cart_route()
    {
        $cart = Cart::factory()->create();

        $response = $this->get('/api/cart');
        $response->assertJson([]);

        $response = $this->get('/api/cart?cart_token='.$cart->cart_token);
        $response->assertStatus(200);
        $response->assertJsonFragment(['cart_token'=>$cart->cart_token]);
    }

    public function test_add_to_cart_route()
    {
        $response = $this->post('/api/cart', ['book_id'=>99]);
        $response->assertJsonFragment(['book'=>null]);

        $author = Author::factory()->hasBooks(1)->create();
        $book = Book::BAuthor($author->id)->first();

        $invalid_qty = $book->quantity + 20;

        $response = $this->post('/api/cart', ['book_id'=>$book->id, 'qty'=>$invalid_qty]);
        $response->assertJsonFragment(['book_qty' => $book->quantity]);

        $response = $this->post('/api/cart', ['book_id'=>$book->id, 'qty'=>5, 'type'=>'pdf']);
        $response->assertJsonFragment(['book_id' => $book->id]);

        $cart_product = CartProduct::where('book_id', $book->id)->where('quantity', 5)->first();
        $cart = Cart::find($cart_product->cart_id);

        $response = $this->post('/api/cart', ['cart_token'=>$cart->cart_token, 'book_id'=>$book->id, 'qty'=>5, 'type'=>'pdf']);
        $response->assertJsonFragment(['quantity' => 10]);
    }

    public function test_update_product_in_cart()
    {
        $response = $this->post('/api/cart', ['book_id'=>99]);
        $response->assertJsonFragment(['book'=>null]);

        $cart = Cart::factory()
                    ->hasCartProducts(2, function(array $attributes){
                        $author = Author::factory()->create();
                        $book = Book::factory([
                            'author_id' => $author->id
                        ])->create();
                        return ['book_id' => $book->id, 'price' => $book->price, 'type' => $book->type];
                    })
                    ->create();
                    
        $cart_product = CartProduct::CartID($cart->id)->first();
        $book = Book::find($cart_product->book_id);
        $invalid_qty = $book->quantity + 20;

        $response = $this->put('/api/cart', ['cart_token'=>$cart->cart_token, 'book_id'=>$book->id, 'type'=>$cart_product->type, 'qty'=>$invalid_qty]);
        $response->assertJsonFragment(['book_qty' => $book->quantity]);

        $response = $this->put('/api/cart', ['cart_token'=>$cart->cart_token, 'book_id'=>$book->id, 'type'=>$cart_product->type, 'qty'=>5]);
        $response->assertJsonFragment(['book_id' => $book->id]);
    }

    public function test_delete_product_from_cart()
    {
        $response = $this->delete('/api/cart/product', ['book_id'=>99]);
        $response->assertJsonFragment(['cart_token'=>null]);

        $cart = Cart::factory()
                    ->hasCartProducts(2, function(array $attributes){
                        $author = Author::factory()->create();
                        $book = Book::factory([
                            'author_id' => $author->id
                        ])->create();
                        return ['book_id' => $book->id, 'price' => $book->price, 'type' => $book->type];
                    })
                    ->create();

        $cart_product = CartProduct::CartID($cart->id)->first();
        $response = $this->delete('/api/cart/product', ['cart_token'=>$cart->cart_token, 'book_id'=>$cart_product->book_id, 'type'=>$cart_product->type]);

        $response->assertJsonFragment(['cart_token'=>$cart->cart_token]);
        $response->assertJsonMissing(['book_id'=>$cart_product->book_id]);
    }

    public function test_delete_cart()
    {
        $response = $this->delete('/api/cart');
        $response->assertJsonFragment(['cart_token'=>null]);

        $response = $this->delete('/api/cart', ['cart_token' => 'test']);
        $response->assertJsonFragment(['cart_token'=>'test']);

        $cart = Cart::factory()
                    ->hasCartProducts(2, function(array $attributes){
                        $author = Author::factory()->create();
                        $book = Book::factory([
                            'author_id' => $author->id
                        ])->create();
                        return ['book_id' => $book->id, 'price' => $book->price, 'type' => $book->type];
                    })
                    ->create();

        $response = $this->delete('/api/cart', ['cart_token' => $cart->cart_token]);
        $response->assertJson([]);
    }
}
