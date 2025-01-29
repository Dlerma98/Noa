<?php


use App\Models\Analysis;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\get;

uses(RefreshDatabase::class);


it('shows a list of analyses', function () {
    $analisis = Analysis::factory(10)->create();

     get(route('analyses.index', $analisis))

    ->assertStatus(200)
    ->assertSee($analisis->title);
});
