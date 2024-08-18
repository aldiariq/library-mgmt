<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;

    //Definisikan field pada tabel Author
    protected $fillable = ['name', 'bio', 'birth_date'];

    //Definisikan relasi antara tabel Author dan Book
    //Adapun definisi berikut yaitu satu Author dapat memiliki banyak Book
    public function books(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Book::class);
    }
}
