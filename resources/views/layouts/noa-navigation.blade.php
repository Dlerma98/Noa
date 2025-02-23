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
                @if(auth()->user()->hasRole('admin'))
                    <a href="{{ route('genres.index') }}"
                       class="px-3 py-2 {{ request()->routeIs('genres.index') ? 'text-sky-500' : 'text-slate-600 transition-colors hover:text-sky-500 dark:text-slate-400 dark:hover:text-sky-500' }}">
                        Géneros
                    </a>
                @endif
            @endauth

            @auth
                @if(auth()->user()->hasAnyRole('redactor', 'admin'))
                    <a href="{{ route('posts.myposts') }}"
                       class="px-3 py-2 {{ request()->routeIs('posts.myposts') ? 'text-sky-500' : 'text-slate-600 transition-colors hover:text-sky-500 dark:text-slate-400 dark:hover:text-sky-500' }}">
                        Mis Posts
                    </a>
                @endif

                    @if(auth()->user()->hasAnyRole('redactor', 'admin'))
                        <a href="{{ route('analysis.myanalyses') }}"
                           class="px-3 py-2 {{ request()->routeIs('analysis.myanalyses') ? 'text-sky-500' : 'text-slate-600 transition-colors hover:text-sky-500 dark:text-slate-400 dark:hover:text-sky-500' }}">
                            Mis Análisis
                        </a>
                    @endif
            @endauth
        </div>

        <!-- Botones de usuario -->
        <div class="flex items-center space-x-4">
            @auth
                <a href="{{ route('profile.show') }}"
                   class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    Perfil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                        Cerrar sesión
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}"
                   class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    Iniciar sesión
                </a>
                <a href="{{ route('register') }}"
                   class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-800 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition">
                    Registrarse
                </a>
            @endguest
        </div>
    </div>
</header>

