<nav class="bg-white dark:bg-gray-800 shadow transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-xl font-semibold text-gray-800 dark:text-white transition-colors duration-300">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>
                <div class="flex space-x-4">
                    <a href="/almacen" class="text-gray-800 dark:text-white">Almacén</a>
                    <a href="/cirugias" class="text-gray-800 dark:text-white">Cirugías</a>
                    <a href="/despacho" class="text-gray-800 dark:text-white">Despacho</a>
                </div>
            </div>
            <div class="flex items-center">
                <button id="theme-toggle" class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 transition-all duration-300 transform hover:scale-105">
                    <svg id="theme-icon" class="w-6 h-6 text-gray-800 dark:text-gray-200 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path id="sun-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" class="hidden dark:block"/>
                        <path id="moon-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" class="block dark:hidden"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
