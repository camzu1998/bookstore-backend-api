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
     * Get the author for the book
     */
    public function author()
    {
        return $this->hasOne(Author::class);
    }
}
