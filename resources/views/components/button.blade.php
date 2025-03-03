<button {{ $attributes->merge(['class' => 'px-4 py-2 rounded-md font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-all duration-300 transform hover:scale-105 active:scale-95']) }} disabled>
    <span class="loader hidden">Cargando...</span>
    {{ $slot }}


    {{ $slot }}
</button>
