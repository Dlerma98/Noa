<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Analysis>
 */
class AnalysisFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence,
            'content' => fake()->paragraphs(3, true),
            'score' => fake()->numberBetween(1, 10),
            'genre' => fake()->randomElement(['Action', 'Adventure', 'Sports', 'RPG']),
            'console' => fake()->randomElement(['PlayStation', 'Xbox', 'PC', 'Switch']),
            'type' => fake()->randomElement(['Review', 'Retro', 'News']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
