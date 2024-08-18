<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthorController;
use App\Http\Controllers\BookController;

//Definisikan route untuk controller Author
Route::apiResource('authors', AuthorController::class);

//Definisikan route untuk controller Book
Route::apiResource('books', BookController::class);
Route::get('authors/{id}/books', [AuthorController::class, 'books']);

