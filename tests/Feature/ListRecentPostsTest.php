<?php

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;

uses(RefreshDatabase::class);

test('el comando posts:list se ejecuta correctamente', function () {
    $exitCode = Artisan::call('posts:list');

    expect($exitCode)->toBe(0);
});
