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

        $images = ["4EzBIhvoLMr5NVu9OBipKLpZO8ZnbP1dfzhbxnXV.png",
            "b1FVGJo3kGPwaMFOxf4sgHGrBDfYBUppcxWW9uuT.png",
            "Hi6xjjy0dJJC7vigSpMRJOLTq638RW7o8JnaS4fs.png",
            "iABzoGvt1bBCyxZOp1eksPAVgM3FImte1V2a14vm.png",
            "LOJVJ8Q29PV1dZ44fX76c8zfNFxR3VG0mXQr67R3.jpg",
            ];

        return [
            'user_id' => User::factory(),
            'title' => $this->faker->paragraph, // Genera un título aleatorio
            'thumbnail' => $this->faker->randomElement->$images,// URL de imagen aleatoria
            'excerpt' => $this->faker->paragraph, // Resumen aleatorio
            'content' => $this->faker->text(1000), // Contenido más largo
            'category' => $this->faker->randomElement(['PlayStation', 'Xbox', 'PC', 'Switch']), // Categoría aleatoria
            'type' => $this->faker->randomElement(['Exclusive', 'Multiplatform']), // Tipo aleatorio
            'created_at' => now(), // Fecha actual
            'updated_at' => now(), // Fecha actual
        ];
    }
}
