<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Author;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Definisikan berapa banyak data dummy untuk model Author
        //Dikarenakan terdapat relasi antara model Author dan model Book,
        //Maka kita dapat menggunakan method hasBooks untuk membuatkan data dummy untuk model Book secara otomatis
        //Dengan statement dibawah, total data dummy sebanyak 30 dengan rincian 1 Author memiliki 3 Book
        Author::factory()
            ->count(10)  //Definisikan berapa banyak data dummy model Author
            ->hasBooks(3) //Definisikan berapa banyak data dummy model Book
            ->create();
    }
}
