<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Noa blog de Videojuegos')</title>
    <meta name="description" content="Blog sobre videojuegos">
    <link rel="icon" href="{{ asset('images/Noa.png') }}" type="image/png">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 text-gray-900">
<header class="bg-gradient-to-r from-purple-600 to-indigo-500 mx-auto shadow-lg">
    <div class="container p-4 text-center flex justify-center items-center">
        <a href="{{ url('/') }}" class="text-xl mx-auto font-bold text-white flex flex-col items-center">
            <img class="w-20 h-20 mx-auto rounded-full shadow-md" alt="logo" src="{{ asset('images/Noa.png') }}" />
            <span class="animate-color-change transition-transform duration-300 hover:scale-110">
        Noa blog de Videojuegos
    </span>
        </a>

    </div>
</header>

@include('layouts.noa-navigation') <!-- 🔹 Aquí incluimos la barra de navegación -->

<main class="container mx-auto py-8">
    @yield('content')
</main>

<footer class="bg-gray-900 text-gray-300 text-center py-4">
    © {{ date('Y') }} Noa. Todos los derechos reservados.
</footer>
</body>
</html>
