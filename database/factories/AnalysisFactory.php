<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

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

        $images = [
            "thumbnails/4EzBIhvoLMr5NVu9OBipKLpZO8ZnbP1dfzhbxnXV.png",
            "thumbnails/b1FVGJo3kGPwaMFOxf4sgHGrBDfYBUppcxWW9uuT.png",
            "thumbnails/Hi6xjjy0dJJC7vigSpMRJOLTq638RW7o8JnaS4fs.png",
            "thumbnails/iABzoGvt1bBCyxZOp1eksPAVgM3FImte1V2a14vm.png",
            "thumbnails/LOJVJ8Q29PV1dZ44fX76c8zfNFxR3VG0mXQr67R3.jpg",
        ];

        $redactor = User::role('redactor')->inRandomOrder()->first();

        if (!$redactor) {
            // Si no hay redactores, crear uno nuevo y asignarle el rol
            $redactor = User::factory()->create();
            if (!Role::where('name', 'redactor')->exists()) {
                Role::create(['name' => 'redactor']); // Crear el rol si no existe
            }
            $redactor->assignRole('redactor'); // Asignar rol "redactor" al usuario
        }

        return [
            'user_id' =>  $redactor->id,
            'genre_id' => Genre::factory()->create()->id,
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
