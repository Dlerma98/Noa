<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\View;

uses(RefreshDatabase::class);

test('NoaLayout se renderiza correctamente en una vista extendida', function () {
    $view = View::make('layouts.noa-layout', [
        '__env' => app(\Illuminate\View\Factory::class),
    ])->render();

    expect($view)->toContain('<header class="bg-gradient-to-r from-purple-600 to-indigo-500 mx-auto shadow-lg">');
    expect($view)->toContain('<footer class="bg-gray-900 text-gray-300 text-center py-4">');
});



