<?php

namespace App\Console\Commands;

use App\Mail\PostPublishedMail;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ResendPostEmails extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:resend-emails {post_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reenviar correos de notificación de un post publicado a todos los usuarios';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $postId = $this->argument('post_id');
        $post = Post::find($postId);

        if (!$post) {
            $this->error("El post con ID $postId no existe.");
            return;
        }

        $this->info("Reenviando correos para el post: " . $post->title);

        $users = User::all();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new PostPublishedMail($post));
        }

        $this->info("Correos reenviados con éxito.");
    }
}
