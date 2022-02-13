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
        if(empty($request->cart_token))
            return response()->json();

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
            if($book->quantity < $request->qty || $request->qty < 0)
                return response()->json(['request_qty'=>$request->qty, 'book_qty' => $book->quantity]);
                
            $qty = $request->qty;
        }

        $type = $book->type;
        if(!empty($request->type) && $book->type != 'pdf' && in_array($request->type, ['both', 'pdf', 'paper'])){
            $type = $request->type;
        }

        $cart_product = CartProduct::CartProduct($cart->id, $book->id, $type)->first();
        if(!empty($cart_product->id)){
            $cart_product->quantity += $cart_product->quantity;
            if($book->quantity < $cart_product->qty)
                return response()->json(['request_qty'=>$request->qty, 'book_qty' => $book->quantity, 'cart_product_qty' => $cart_product->quantity]);

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

        $cart_products = CartProduct::select('books.name as book_name', 'books.price', 'cart_products.*', 'authors.name as author_name')->CartID($cart->id)->rightJoin('books', 'books.id', '=', 'cart_products.book_id')->rightJoin('authors', 'authors.id', '=', 'books.author_id')->get();
        return response()->json([
            'cart'          => $cart,
            'cart_products' => $cart_products
        ]);
    }

    public function update(Request $request)
    {
        if(empty($request->cart_token))
            return response()->json(['cart_token'=>$request->cart_token]);

        $cart = Cart::CartToken($request->cart_token)->first();
        
        if(empty($cart->id))
            return response()->json(['cart_token'=>$request->cart_token]);

        $book = Book::find($request->book_id);
        if(empty($book->id))
            return response()->json(['request_book'=>$request->book_id, 'book' => $book]);

        $qty = 1;
        if(empty($request->qty) || !is_numeric($request->qty) || $book->quantity < $request->qty || $request->qty < 0)
            return response()->json(['request_qty'=>$request->qty, 'book_qty' => $book->quantity]);

        $qty = $request->qty;
        
        $type = $book->type;
        if(!empty($request->type) && $book->type != 'pdf' && in_array($request->type, ['both', 'pdf', 'paper'])){
            $type = $request->type;
        }

        $cart_product = CartProduct::CartProduct($cart->id, $book->id, $type)->first();
        if(empty($cart_product->id)){
            return response()->json(['request_book'=>$request->book_id, 'cart_id' => $cart->id, 'type' => $type]);
        }
        $cart_product->quantity = $qty;
        $cart_product->save();

        $total_price = 0;
        $cart_products = CartProduct::CartID($cart->id)->get();
        foreach($cart_products as $cart_product)
        {
            $total_price += $cart_product->quantity*$cart_product->price;
        }
        $cart->total_price = $total_price;
        $cart->save();

        $cart_products = CartProduct::select('books.name as book_name', 'books.price', 'cart_products.*', 'authors.name as author_name')->CartID($cart->id)->rightJoin('books', 'books.id', '=', 'cart_products.book_id')->rightJoin('authors', 'authors.id', '=', 'books.author_id')->get();
        return response()->json([
            'cart'          => $cart,
            'cart_products' => $cart_products
        ]);
    }
    
    public function delete_product(Request $request)
    {
        if(empty($request->cart_token))
            return response()->json(['cart_token'=>$request->cart_token]);

        $cart = Cart::CartToken($request->cart_token)->first();
        
        if(empty($cart->id))
            return response()->json(['cart_token'=>$request->cart_token]);

        $book = Book::find($request->book_id);
        if(empty($book->id))
            return response()->json(['request_book'=>$request->book_id, 'book' => $book]);
        
        $type = $book->type;
        if(!empty($request->type) && $book->type != 'pdf' && in_array($request->type, ['both', 'pdf', 'paper'])){
            $type = $request->type;
        }

        $cart_product = CartProduct::CartProduct($cart->id, $book->id, $type)->first();
        if(empty($cart_product->id)){
            return response()->json(['request_book'=>$request->book_id, 'cart_id' => $cart->id, 'type' => $type]);
        }

        $cart->total_price -= $cart_product->quantity * $cart_product->price;
        $cart->save();
        $cart_product->delete();

        $cart_products = CartProduct::select('books.name as book_name', 'books.price', 'cart_products.*', 'authors.name as author_name')->CartID($cart->id)->rightJoin('books', 'books.id', '=', 'cart_products.book_id')->rightJoin('authors', 'authors.id', '=', 'books.author_id')->get();
        return response()->json([
            'cart'          => $cart,
            'cart_products' => $cart_products
        ]);
    }

    public function delete(Request $request)
    {
        if(empty($request->cart_token))
            return response()->json(['cart_token'=>$request->cart_token]);

        $cart = Cart::CartToken($request->cart_token)->first();
        
        if(empty($cart->id))
            return response()->json(['cart_token'=>$request->cart_token]);

        CartProduct::CartID($cart->id)->delete();
        Cart::find($cart->id)->delete();

        return response()->json();
    }
}
