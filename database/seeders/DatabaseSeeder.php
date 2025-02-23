<?php

namespace Database\Seeders;

use App\Models\Analysis;
use App\Models\Post;
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

        $this->call([
            GenreSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PostSeeder::class,
            AnalysisSeeder::class,
        ]);
    }
}
