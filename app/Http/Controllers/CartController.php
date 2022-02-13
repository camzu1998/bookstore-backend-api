<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Book;
use App\Models\Cart;
use App\Models\CartProduct;

class CartController extends Controller
{
    public function get(Request $request)
    {
        $cart = Cart::CartToken($request->cart_token)->first();

        if(empty($cart->id))
            return response()->json();


        $cart_products = CartProduct::select('books.name as book_name', 'books.price', 'cart_products.*', 'authors.name as author_name')->CartID($cart->id)->rightJoin('books', 'books.id', '=', 'cart_products.book_id')->rightJoin('authors', 'authors.id', '=', 'books.author_id')->get();
        return response()->json([
            'cart'          => $cart,
            'cart_products' => $cart_products
        ]);
    }

    public function add(Request $request)
    {
        if(!empty($request->cart_token))
            $cart = Cart::CartToken($request->cart_token)->first();
        
        if(empty($cart->id))
            $cart = Cart::factory()->create();

        $book = Book::find($request->book_id);
        if(empty($book->id))
            return response()->json(['request_book'=>$request->book_id, 'book' => $book]);

        $qty = 1;
        if(!empty($request->qty) && is_numeric($request->qty)){
            if($book->quantity < $request->qty)
                return response()->json(['request_qty'=>$request->qty, 'book_qty' => $book->quantity]);
                
            $qty = $request->qty;
        }

        $type = $book->type;
        if(!empty($request->type) && $book->type != 'pdf' && in_array($request->type, ['both', 'pdf', 'paper'])){
            $type = $request->type;
        }

        $cart_product = CartProduct::CartProduct($cart->id, $book->id, $type)->first();
        if(!empty($cart_product->id)){
            $cart_product->quantity += $qty;
            $cart_product->save();
        }else{
            $cart_product = CartProduct::factory()->create([
                'cart_id' => $cart->id,
                'book_id' => $book->id,
                'quantity'=> $qty,
                'type'    => $type,
                'price'   => $book->price,
            ]);
        }

        $cart->total_price += $book->price;
        $cart->save();

        $book->quantity -= $qty;
        $book->save();


        $cart_products = CartProduct::select('books.name as book_name', 'books.price', 'cart_products.*', 'authors.name as author_name')->CartID($cart->id)->rightJoin('books', 'books.id', '=', 'cart_products.book_id')->rightJoin('authors', 'authors.id', '=', 'books.author_id')->get();
        return response()->json([
            'cart'          => $cart,
            'cart_products' => $cart_products
        ]);
    }

    public function update()
    {
        return true;
    }
}
