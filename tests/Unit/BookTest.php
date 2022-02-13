<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Book;


class BookTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_create_book()
    {
        $book = Book::factory()->create([
            'author_id' => 1
        ]);

        $this->assertModelExists($book);
    }

    public function test_change_book()
    {
        $book = Book::factory()->create([
            'author_id' => 1
        ]);
        $this->assertModelExists($book);

        $book->name = 'test';
        $book->save();

        $this->assertDatabaseHas('books', [
            'name' => 'test',
        ]);
    }

    public function test_delete_book()
    {
        $book = Book::factory()->create([
            'author_id' => 1
        ]);
        $this->assertModelExists($book);

        $book->delete();

        $this->assertModelMissing($book);
    }
}
