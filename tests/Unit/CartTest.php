<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Cart;

class CartTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_cart()
    {
        $cart = Cart::factory()->create();

        $this->assertModelExists($cart);
    }

    public function test_updating_cart()
    {
        $cart = Cart::factory()->create();
        $this->assertModelExists($cart);

        $cart->total_price = 999.99;
        $cart->save();

        $this->assertDatabaseHas('carts', [
            'total_price' => 999.99,
        ]);
    }

    public function test_deleting_cart()
    {
        $cart = Cart::factory()->create();
        $this->assertModelExists($cart);

        $cart->delete();

        $this->assertModelMissing($cart);
    }
}
