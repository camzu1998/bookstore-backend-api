<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\CartProduct;

class CartController extends Controller
{
    public function get(Request $request, string $token){
        $cart = Cart::CartToken($token)->first();
        if(empty($cart->id))
            return response()->json();


        $cart_products = CartProduct::select('books.name as book_name', 'books.price', 'cart_products.*', 'authors.name as author_name')->CartID($cart->id)->rightJoin('books', 'books.id', '=', 'cart_products.book_id')->rightJoin('authors', 'authors.id', '=', 'books.author_id')->get();
        return response()->json([
            'cart'          => $cart,
            'cart_products' => $cart_products
        ]);
    }
}
