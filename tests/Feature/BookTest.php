<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Database\Seeders\AuthorSeeder;
use App\Models\Author;
use App\Models\Book;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_access_all_books_route()
    {
        $author = Author::factory()->hasBooks(1)->create();

        $response = $this->get('/api/books');
        $response->assertStatus(200);
        $response->assertJsonFragment(['author_id' => $author->id]);
    }

    public function test_access_author_route()
    {
        $author = Author::factory()->hasBooks(1)->create();

        $response = $this->get('/api/books/'.$author->id);
        $response->assertStatus(200);
        $response->assertJsonFragment(['author_id' => $author->id]);
    }

    public function test_access_book_route()
    {
        $author = Author::factory()->hasBooks(1)->create();
        $book = Book::BAuthor($author->id)->first();

        $response = $this->get('/api/book/'.$book->id);
        $response->assertStatus(200);
        $response->assertJsonFragment(['author_id' => $author->id]);
    }
}
