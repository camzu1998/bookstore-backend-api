<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BookController;
use App\Http\Controllers\CartController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/books', [BookController::class, 'get_all']);
Route::get('/books/{author_id}', [BookController::class, 'get_author']);
Route::get('/book/{book_id}', [BookController::class, 'get']);

Route::get('/cart', [CartController::class, 'get']);
Route::post('/cart', [CartController::class, 'add']);
Route::put('/cart', [CartController::class, 'update']);
Route::delete('/cart', [CartController::class, 'delete']);