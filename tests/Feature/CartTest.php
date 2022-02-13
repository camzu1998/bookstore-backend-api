<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Database\Seeders\AuthorSeeder;
use App\Models\Author;
use App\Models\Book;
use App\Models\Cart;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_cart_route()
    {
        $cart = Cart::factory()->create();

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
    }

}
