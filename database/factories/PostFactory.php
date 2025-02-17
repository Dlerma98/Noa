<?php

namespace Database\Factories;

use App\Models\Genre;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

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
            'user_id' => $redactor->id, // Solo un redactor puede escribir posts
            'genre_id' => Genre::factory()->create()->id, // Crear un género aleatorio
            'title' => $this->faker->sentence, // Generar un título aleatorio
            'thumbnail' => $this->faker->randomElement($images), // URL de imagen aleatoria
            'excerpt' => $this->faker->paragraph, // Resumen aleatorio
            'content' => $this->faker->text(1000), // Contenido más largo
            'category' => $this->faker->randomElement(['PlayStation', 'Xbox', 'PC', 'Switch']), // Categoría aleatoria
            'type' => $this->faker->randomElement(['Exclusive', 'Multiplatform']), // Tipo aleatorio
            'created_at' => now(), // Fecha actual
            'updated_at' => now(), // Fecha actual
        ];
    }
}
