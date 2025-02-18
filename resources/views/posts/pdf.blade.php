

        <div class="flex-1 space-y-3 pt-4 md:text-center">
            <h2 class="text-2xl font-semibold leading-tight text-slate-800 dark:text-slate-200 md:text-4xl">
                {{ $post->title }}
            </h2>
        </div>

        <div class="prose prose-slate mx-auto mt-6 dark:prose-invert lg:prose-xl">
            <p>{{ $post->content }}</p>
            <p>Autor: {{$post->user->name}}</p>
        </div>

