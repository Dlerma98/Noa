<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Post::class;
    public function definition(): array
    {

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->paragraph, // Genera un título aleatorio
            'thumbnail' => $this->faker->imageUrl(640, 480, 'video games', true), // URL de imagen aleatoria
            'excerpt' => $this->faker->paragraph, // Resumen aleatorio
            'content' => $this->faker->text(1000), // Contenido más largo
            'category' => $this->faker->randomElement(['PlayStation', 'Xbox', 'PC', 'Switch']), // Categoría aleatoria
            'type' => $this->faker->randomElement(['Exclusive', 'Multiplatform']), // Tipo aleatorio
            'created_at' => now(), // Fecha actual
            'updated_at' => now(), // Fecha actual
        ];
    }
}
