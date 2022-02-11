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
            'name' => $this->faker->title(),
            'type' => 'both', //both, pdf, book
            'quantity' => $this->faker->randomNumber(5, false),
            'price' => $this->faker->randomFloat(2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
