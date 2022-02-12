<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Author;
use App\Models\Book;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    protected $model = Book::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_id' => false,
            'name' => $this->faker->sentence(2),
            'type' => "both", //both, pdf, book
            'quantity' => $this->faker->randomNumber(3, false),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
