<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Cart;
use App\Models\CartProduct;
use App\Models\Book;
use App\Models\Author;

class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Cart::factory()->hasCartProducts(3, function(array $attributes){
            $author = Author::factory()->create();
            $book = Book::factory([
                'author_id' => $author->id
            ])->create();
            return ['book_id' => $book->id, 'price' => $book->price];
        })->count(3)->create();
    }
}
