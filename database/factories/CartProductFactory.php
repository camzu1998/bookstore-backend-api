<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CartProduct>
 */
class CartProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'cart_id' => false,
            'book_id' => false,
            'quantity'=> 1,
            'type' => false,
            'price' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
