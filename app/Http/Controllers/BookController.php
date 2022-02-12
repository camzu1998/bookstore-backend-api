<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Author;

class BookController extends Controller
{
    public function get_all(Request $request){
        return Book::select('books.*', 'authors.name as author_name')->rightJoin('authors', 'authors.id', '=', 'books.author_id')->get();
    }

    public function get(Request $request, int $book_id){
        return Book::select('books.*', 'authors.name as author_name')->rightJoin('authors', 'authors.id', '=', 'books.author_id')->where('books.id', $book_id)->first();
    }

    public function get_author(Request $request, int $author_id){
        return Book::select('books.*', 'authors.name as author_name')->rightJoin('authors', 'authors.id', '=', 'books.author_id')->where('books.author_id', $author_id)->get();
    }
}
