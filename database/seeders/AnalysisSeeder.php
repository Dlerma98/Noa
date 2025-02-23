<?php

namespace Database\Seeders;

use App\Models\Analysis;
use Illuminate\Database\Seeder;

class AnalysisSeeder extends Seeder
{
    public function run(): void
    {
        Analysis::factory(13)->create();
    }
}
