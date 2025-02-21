<?php

namespace App\Jobs;

use App\Models\Post;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GeneratePostPDF implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $post;

    /**
     * Create a new job instance.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pdf = PDF::loadView('posts.pdf', ['post' => $this->post]);

        // Definir la ruta del archivo PDF
        $filePath = "pdfs/post-{$this->post->id}.pdf";

        // Guardar el PDF en el almacenamiento
        Storage::disk('public')->put($filePath, $pdf->output());
    }
}
