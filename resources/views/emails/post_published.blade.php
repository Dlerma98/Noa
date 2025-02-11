<!DOCTYPE html>
<html>
<head>
    <title>Nuevo Post Publicado</title>
</head>
<body>
<h1>{{ $post->title }}</h1>
<p>{{ $post->content }}</p>
<a href="{{ url('/posts/' . $post->id) }}">Ver post</a>
</body>
</html>
