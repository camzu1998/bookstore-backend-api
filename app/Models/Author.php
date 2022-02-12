<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Book;

class Author extends Model
{
    use HasFactory;

    protected $table = 'authors';
    protected $attributes = [
        'name' => false,
        'created_at' => false,
    ];
    public $timestamps = false;

    /**
     * Get the books for the book author.
     */
    public function books()
    {
        return $this->hasMany(Book::class);
    }
}
