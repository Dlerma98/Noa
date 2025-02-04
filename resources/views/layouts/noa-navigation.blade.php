<header class="bg-white px-6 shadow dark:bg-slate-900">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between">
        <!-- Botón para el menú móvil -->
        <button @click="mobileMenu = !mobileMenu"
                class="-ml-1 rounded p-1 text-slate-500 transition-colors hover:bg-sky-500 hover:text-slate-100 focus:ring-2 focus:ring-slate-200 dark:text-slate-400 dark:hover:text-slate-100 md:hidden">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>

        <!-- Navegación Principal -->
        <div class="hidden md:flex space-x-8">
            <a href="{{ route('posts.index') }}"
               class="px-3 py-2 {{ request()->routeIs('posts.index') ? 'text-sky-500' : 'text-slate-600 transition-colors hover:text-sky-500 dark:text-slate-400 dark:hover:text-sky-500' }}">
                Inicio
            </a>

            <a href="{{ route('analyses.index') }}"
               class="px-3 py-2 {{ request()->routeIs('analyses.index') ? 'text-sky-500' : 'text-slate-600 transition-colors hover:text-sky-500 dark:text-slate-400 dark:hover:text-sky-500' }}">
                Análisis
            </a>

            @auth
                <a href="{{ route('posts.myposts') }}"
                   class="px-3 py-2 {{ request()->routeIs('posts.myposts') ? 'text-sky-500' : 'text-slate-600 transition-colors hover:text-sky-500 dark:text-slate-400 dark:hover:text-sky-500' }}">
                    Mis Posts
                </a>
            @endauth

        </div>

        @auth
            <div class="flex justify-end">
                    <a href="{{ route('profile.show') }}"
                       class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                        Perfil
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                            Cerrar sesión
                        </button>
            </div>
            @endauth

            @guest
            <div class="flex justify-end">
                <a href="{{ route('login') }}"
                   class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}"
                   class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    Registrarse
                </a>
            </div>
            @endguest
        </div>

    <!-- Menú móvil -->
    <div x-show="mobileMenu" @click.away="mobileMenu = false" class="md:hidden">
        <a href="{{ route('posts.index') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">
            Inicio
        </a>
        <a href="{{ route('analyses.index') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">
            Análisis
        </a>
      @auth
            <a href="{{ route('posts.myposts') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">
                Mis Posts
            </a>
        @endauth
    </div>
</header>
