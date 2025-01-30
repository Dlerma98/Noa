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

           {{-- @auth
                <a href="{{ route('posts.myposts') }}"
                   class="px-3 py-2 {{ request()->routeIs('posts.myposts') ? 'text-sky-500' : 'text-slate-600 transition-colors hover:text-sky-500 dark:text-slate-400 dark:hover:text-sky-500' }}">
                    Mis Posts
                </a>
            @endauth --}}

        </div>

        <!-- Dropdown de usuario -->
        <div x-data="{ open: false }" class="relative">
            @auth
                <button @click="open = !open"
                        class="flex items-center space-x-2 px-3 py-2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition">
                    <img class="h-6 w-6 rounded-full"
                         src="https://ui-avatars.com/api?name={{ Auth::user()->name }}+{{ Auth::user()->lastname }}"
                         alt="Usuario actual">
                    <svg class="h-4 w-4 fill-current" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                              clip-rule="evenodd" />
                    </svg>
                </button>

                <!-- Menú desplegable -->
                <div x-show="open" @click.away="open = false"
                     class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg z-50"
                     style="display: none;">
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
                    </form>
                </div>
            @endauth

            @guest
                <a href="{{ route('login') }}"
                   class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}"
                   class="px-3 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md">
                    Registrarse
                </a>
            @endguest
        </div>

        <!-- Botón de tema oscuro -->
        <div x-data="{ themeMenu: false }" class="relative">
            <button @click="themeMenu = !themeMenu"
                    class="rounded-full text-slate-500 hover:text-sky-500 focus:ring-2 focus:ring-slate-200 dark:text-slate-400 dark:hover:text-sky-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z">
                    </path>
                </svg>
            </button>

            <!-- Menú de tema -->
            <div x-show="themeMenu" @click.away="themeMenu = false"
                 class="absolute right-0 mt-2 w-28 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md shadow-lg z-50"
                 style="display: none;">
                <button data-theme-option="light"
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Claro
                </button>
                <button data-theme-option="dark"
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Oscuro
                </button>
                <button data-theme-option="system"
                        class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Sistema
                </button>
            </div>
        </div>
    </div>

    <!-- Menú móvil -->
    <div x-show="mobileMenu" @click.away="mobileMenu = false" class="md:hidden">
        <a href="{{ route('posts.index') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">
            Inicio
        </a>
        <a href="{{ route('analyses.index') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">
            Análisis
        </a>
       {{--}} Esto debo de añadirlo mas adelante cuando se asocien los post a un usuario que los haya publicado @auth
            <a href="{{ route('posts.myposts') }}" class="block px-3 py-2 text-gray-700 dark:text-gray-300">
                Mis Posts
            </a>
        @endauth --}}
    </div>
</header>
