<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Author;
class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    protected $attributes = [
        'author_id' => false,
        'name' => false,
        'type' => false,
        'quantity' => false,
        'price' => false,
    ];

    /**
     * Scope a query to only include books of defined author
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int  $author_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBAuthor($query, int $author_id)
    {
        return $query->where('author_id', $author_id);
    }

    /**
     * Get the author for the book
     */
    public function author()
    {
        return $this->hasOne(Author::class);
    }
}
