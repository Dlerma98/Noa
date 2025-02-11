<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class ListRecentPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:list {--limit=5}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Lista los últimos posts publicados';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $limit = $this->option('limit');
        $posts = Post::latest()->take($limit)->get();

        if ($posts->isEmpty()) {
            $this->info("No hay posts recientes.");
            return;
        }

        $this->table(
            ['ID', 'Título', 'Fecha de Publicación'],
            $posts->map(fn($post) => [$post->id, $post->title, $post->created_at->toDateTimeString()])
        );
    }
}
