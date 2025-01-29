<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{asset('images/Noa.png')}}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Noa blog de Videojuegos')</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">
<header class="bg-white mx-auto shadow-md">
    <div class="container p-4 text-center  flex justify-center items-center">
        <a href="{{ url('/') }}" class="text-xl mx-auto font-bold text-indigo-600">
           <img class="w-20 h-20 mx-auto rounded-full" alt="logo" src="{{asset('images/Noa.png')}}"/> Noa blog de Videojuegos
        </a>
    </div>
</header>

<main class="container mx-auto py-8">
    @yield('content')
</main>

<footer class="bg-gray-800 text-white text-center py-4">
    © {{ date('Y') }} Noa. Todos los derechos reservados.
</footer>
</body>
</html>
