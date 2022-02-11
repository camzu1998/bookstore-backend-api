<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
