<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AuthorController extends Controller
{

    //Method untuk listing semua Author
    public function index(): \Illuminate\Http\JsonResponse
    {
        //Implementasi cache untuk mempecepat laod data Author
        //Cache akan disimpan selama 60 menit, ketika lebih dari 60 detik maka,
        //Cache akan diisi dengan request terakhir
        $authors = Cache::remember('authors_all', 60, function () {
            return Author::select('id', 'name', 'bio', 'birth_date')->get();
        });

        return response()->json($authors);
    }

    //Method untuk insert Author
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $author = Author::create($request->only('name', 'bio', 'birth_date'));

        //Ketika ada data Author baru, maka cache author_all akan dihapus
        //untuk menghindari data yang tidak konsisten
        Cache::forget('authors_all');

        return response()->json($author->only('id', 'name', 'bio', 'birth_date'), 201);
    }

    //Method untuk listing satu Author
    public function show(Author $author): \Illuminate\Http\JsonResponse
    {
        //Implementasi cache untuk single Author
        $authorDetails = Cache::remember('author_'.$author->id, 60, function () use ($author) {
            return $author->only('id', 'name', 'bio', 'birth_date');
        });

        return response()->json($authorDetails);
    }

    //Method untuk update Author
    public function update(Request $request, Author $author): \Illuminate\Http\JsonResponse
    {
        $author->update($request->only('name', 'bio', 'birth_date'));

        //Ketika ada data Author yang berubah, maka cache author akan dihapus
        //untuk menghindari data yang tidak konsisten dan menambahkan cache untuk
        //Author yang diupdate tersebut
        Cache::put('author_'.$author->id, $author->only('id', 'name', 'bio', 'birth_date'), 60);
        Cache::forget('authors_all');

        return response()->json($author->only('id', 'name', 'bio', 'birth_date'), 200);
    }

    //Method untuk delete Author
    public function destroy(Author $author): \Illuminate\Http\JsonResponse
    {
        $author->delete();

        //Ketika ada data Author yang dihapus,maka cache yang berkaitan dengan author akan dihapus
        //untuk menghindari data yang tidak konsisten
        Cache::forget('author_'.$author->id);
        Cache::forget('authors_all');

        return response()->json(null, 204);
    }

    //Method untuk listing Book berdasarkan ID Author
    public function books($id)
    {
        return Author::select('id', 'name', 'bio', 'birth_date')
            ->with(['books' => function($query) {
                $query->select('id', 'title', 'author_id', 'publish_date');
            }])
            ->findOrFail($id);
    }
}
