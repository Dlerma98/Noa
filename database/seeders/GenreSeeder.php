<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Genre::insert([
            ['name' => 'Action'],
            ['name' => 'Adventure'],
            ['name' => 'RPG'],
            ['name' => 'Strategy'],
            ['name' => 'Horror'],
            ['name' => 'Simulation'],
            ['name' => 'Sports'],
        ]);
    }
}
