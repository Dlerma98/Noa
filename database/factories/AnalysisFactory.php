<?php

namespace Database\Factories;

use App\Models\User;
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

        $images = ["4EzBIhvoLMr5NVu9OBipKLpZO8ZnbP1dfzhbxnXV.png",
            "b1FVGJo3kGPwaMFOxf4sgHGrBDfYBUppcxWW9uuT.png",
            "Hi6xjjy0dJJC7vigSpMRJOLTq638RW7o8JnaS4fs.png",
            "iABzoGvt1bBCyxZOp1eksPAVgM3FImte1V2a14vm.png",
            "LOJVJ8Q29PV1dZ44fX76c8zfNFxR3VG0mXQr67R3.jpg",
        ];


        return [
            'user_id' => User::factory()->create()->id,
            'title' => fake()->sentence,
            'thumbnail' => $this->faker->randomElement($images),// URL de imagen aleatoria
            'content' => fake()->paragraphs(3, true),
            'score' => fake()->numberBetween(0, 100),
            'console' => fake()->randomElement(['PlayStation', 'Xbox', 'PC', 'Switch']),
            'type' => fake()->randomElement(['Review', 'Retro', 'News']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
