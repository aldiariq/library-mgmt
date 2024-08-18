<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //Definisikan AuthorSeeder yang telah dibuat sebelumnya
        $this->call([
            AuthorSeeder::class
        ]);
    }
}
