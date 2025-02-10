<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genres = ['Action', 'Adventure', 'RPG', 'Strategy', 'Horror', 'Simulation', 'Sports'];

        foreach ($genres as $genre) {
            Genre::updateOrInsert(['name' => $genre]); // Correcto
        }
    }
}
