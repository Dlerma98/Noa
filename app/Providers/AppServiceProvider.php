<?php

namespace App\Providers;

use App\Events\PostPublished;
use App\Listeners\SendPostPublishedEmail;
use App\Models\Analysis;
use App\Models\Post;
use App\Policies\AnalysisPolicy;
use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Event::listen(
            PostPublished::class,
            SendPostPublishedEmail::class,
        );
    }

    protected $policies = [
        Analysis::class => AnalysisPolicy::class,
        Post::class => PostPolicy::class,
    ];
}
