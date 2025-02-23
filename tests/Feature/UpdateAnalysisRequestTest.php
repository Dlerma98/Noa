<?php

use App\Http\Requests\Analysis\UpdateAnalysisRequest;
use Illuminate\Support\Facades\Validator;

test('UpdateAnalysisRequest permite datos válidos', function () {
    // Crear un género válido
    $genre = \App\Models\Genre::factory()->create();

    $data = [
        'title' => 'Título actualizado con más de 10 caracteres',
        'content' => 'Este es un contenido válido que supera los 10 caracteres.',
        'score' => 85,
        'console' => 'PC',
        'type' => 'Retro',
        'thumbnail' => null, // Permitimos `nullable`
        'genre_id' => $genre->id, // Asegurar que el ID existe
    ];

    $request = new \App\Http\Requests\Analysis\UpdateAnalysisRequest();
    $validator = \Illuminate\Support\Facades\Validator::make($data, $request->rules());

    dump($validator->errors()->all()); // Verificar si hay errores en la validación
    expect($validator->fails())->toBeFalse();
});

test('UpdateAnalysisRequest rechaza un título vacío', function () {
    $data = [
        'title' => '',
        'content' => 'Este es un contenido válido con más de 30 caracteres.',
        'score' => 85,
        'console' => 'PC',
        'type' => 'Retro',
        'genre_id' => 1,
    ];

    $request = new UpdateAnalysisRequest();
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('title'))->toBeTrue();
});

test('UpdateAnalysisRequest rechaza un contenido demasiado corto', function () {
    $data = [
        'title' => 'Título válido',
        'content' => 'Corto',
        'score' => 85,
        'console' => 'PC',
        'type' => 'Retro',
        'genre_id' => 1,
    ];

    $request = new UpdateAnalysisRequest();
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('content'))->toBeTrue();
});

test('UpdateAnalysisRequest rechaza un score fuera de rango', function () {
    $data = [
        'title' => 'Título válido',
        'content' => 'Este es un contenido válido con más de 30 caracteres.',
        'score' => 150, // Debe estar entre 0 y 100
        'console' => 'PC',
        'type' => 'Retro',
        'genre_id' => 1,
    ];

    $request = new UpdateAnalysisRequest();
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('score'))->toBeTrue();
});

test('UpdateAnalysisRequest rechaza una consola inválida', function () {
    $data = [
        'title' => 'Título válido',
        'content' => 'Este es un contenido válido con más de 30 caracteres.',
        'score' => 85,
        'console' => 'GameBoyAdvance', // Consola inválida
        'type' => 'Retro',
        'genre_id' => 1,
    ];

    $request = new UpdateAnalysisRequest();
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('console'))->toBeTrue();
});

test('UpdateAnalysisRequest rechaza un título demasiado largo', function () {
    $data = [
        'title' => str_repeat('A', 256), // Excede el límite de 255 caracteres
        'content' => 'Contenido válido con más de 30 caracteres.',
        'score' => 85,
        'console' => 'PC',
        'type' => 'Retro',
        'genre_id' => \App\Models\Genre::factory()->create()->id,
    ];

    $request = new UpdateAnalysisRequest();
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('title'))->toBeTrue();
});

test('UpdateAnalysisRequest rechaza un contenido demasiado largo', function () {
    $data = [
        'title' => 'Título válido',
        'content' => str_repeat('A', 501), // Excede el límite de 500 caracteres
        'score' => 85,
        'console' => 'PC',
        'type' => 'Retro',
        'genre_id' => \App\Models\Genre::factory()->create()->id,
    ];

    $request = new UpdateAnalysisRequest();
    $validator = Validator::make($data, $request->rules());

    expect($validator->fails())->toBeTrue();
    expect($validator->errors()->has('content'))->toBeTrue();
});
