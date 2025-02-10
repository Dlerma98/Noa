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
        // User::factory(10)->create();

        $this->call(GenreSeeder::class);

        User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
        ]);
        Post::factory(10)->create();
        Analysis::factory(10)->create();
    }
}
