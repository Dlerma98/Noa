<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {

        // Crear un usuario Redactor
        $redactor = User::create([
            'name' => 'Redactor User',
            'email' => 'redactor@example.com',
            'password' => bcrypt('password'),
            'birthdate' => '1990-01-01',
        ]);
        $redactor->assignRole('redactor');

        // Crear un usuario Lector
        $lector = User::create([
            'name' => 'Lector User',
            'email' => 'lector@example.com',
            'password' => bcrypt('password'),
            'birthdate' => '1990-01-01',
        ]);
        $lector->assignRole('lector');
    }
}
