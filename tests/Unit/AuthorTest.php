<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Author;

class AuthorTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_create_author()
    {
        $author = Author::factory()->create();

        $this->assertModelExists($author);
    }

    public function test_change_author()
    {
        $author = Author::factory()->create();
        $this->assertModelExists($author);

        $author->name = 'test';
        $author->save();

        $this->assertDatabaseHas('authors', [
            'name' => 'test',
        ]);
    }

    public function test_delete_author()
    {
        $author = Author::factory()->create();
        $this->assertModelExists($author);

        $author->delete();

        $this->assertModelMissing($author);
    }
}
