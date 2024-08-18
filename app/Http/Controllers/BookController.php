<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class BookController extends Controller
{
    //Method untuk listing semua Book
    public function index(): \Illuminate\Http\JsonResponse
    {
        //Implementasi cache untuk mempecepat laod data Book
        //Cache akan disimpan selama 60 menit, ketika lebih dari 60 detik maka,
        //Cache akan diisi dengan request terakhir
        $books = Cache::remember('books_all', 60, function () {
            return Book::select('id', 'title', 'author_id', 'publish_date')->get();
        });

        return response()->json($books);
    }

    //Method untuk insert Book
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $book = Book::create($request->only('title', 'description', 'author_id', 'publish_date'));

        //Ketika ada data Book baru, maka cache book_all akan dihapus
        //untuk menghindari data yang tidak konsisten
        Cache::forget('books_all');
        Cache::forget('author_books_'.$book->author_id);

        return response()->json($book->only('id', 'title', 'author_id', 'publish_date'), 201);
    }

    //Method untuk listing satu Book
    public function show(Book $book): \Illuminate\Http\JsonResponse
    {
        //Implementasi cache untuk single Book
        $bookDetails = Cache::remember('book_'.$book->id, 60, function () use ($book) {
            return $book->only('id', 'title', 'author_id', 'publish_date');
        });

        return response()->json($bookDetails);
    }

    //Method untuk update Book
    public function update(Request $request, Book $book): \Illuminate\Http\JsonResponse
    {

        $book->update($request->only('title', 'description', 'author_id', 'publish_date'));

        //Ketika ada data Book yang berubah, maka cache book akan dihapus
        //untuk menghindari data yang tidak konsisten dan menambahkan cache untuk
        //Book yang diupdate tersebut
        Cache::put('book_'.$book->id, $book->only('id', 'title', 'author_id', 'publish_date'), 60);
        Cache::forget('books_all');
        Cache::forget('author_books_'.$book->author_id);

        return response()->json($book->only('id', 'title', 'author_id', 'publish_date'), 200);
    }

    //Method untuk delete Book
    public function destroy(Book $book): \Illuminate\Http\JsonResponse
    {
        $book->delete();

        //Ketika ada data Book yang dihapus, maka cache yang berkaitan dengan book akan dihapus
        //untuk menghindari data yang tidak konsisten
        Cache::forget('book_'.$book->id);
        Cache::forget('books_all');
        Cache::forget('author_books_'.$book->author_id);

        return response()->json(null, 204);
    }
}
