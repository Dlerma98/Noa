<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Mail\PostPublishedMail;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPostPublishedEmail
{
    use InteractsWithQueue;
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }


    public function handle(PostPublished $event)
    {
        $users = User::all();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new PostPublishedMail($event->post));
        }
    }
}
