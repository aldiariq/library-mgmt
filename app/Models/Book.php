<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    //Definisikan field pada tabel Book
    protected $fillable = ['title', 'description', 'publish_date', 'author_id'];

    //Definisikan relasi antara tabel Book dan Author
    //Adapun definisi berikut yaitu satu Book hanya memiliki satu Author
    public function author(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Author::class);
    }
}
