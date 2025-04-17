<!-- Botón de hamburguesa (visible en pantallas pequeñas) -->
<button id="sidebar-toggle" class="fixed top-0 left-0 sm:hidden p-4 z-50 text-gray-700 dark:text-white hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
    <span class="material-symbols-outlined">menu</span>
</button>

<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-full transition-transform -translate-x-full sm:translate-x-0 bg-blue-900 dark:bg-gray-800 shadow-lg">
    <div class="h-full px-4 py-6 overflow-y-auto">
        <!-- Logo -->
        <a href="{{route('dashboard.index')}}" class="flex items-center mb-6">
            <img src="{{asset('/images/logo.png')}}" class="h-8 mr-3" alt="Flowbite Logo">
            <span class="text-sm font-semibold text-white dark:text-white">Alcaldía Municipal de León</span>
        </a>

        <!-- User Info -->
        @if(auth()->check())
        <div class="flex items-center gap-2 bg-green-600 px-4 py-2 rounded-lg text-white mb-4">
        <img src="{{asset('/images/iconos/activo.png')}}" alt="" class="w-6 h-6" >
            <h1>Usuario Activo: {{ auth()->user()->usuario }}</h1>
        </div>
        @else
        <h1 class="text-white mb-4">Bienvenido, visitante</h1>
        @endif

        <!-- Menu -->
        <ul class="space-y-3">
            @role('admin')
            <li class="relative">
                <a href="{{route('users.index')}}" data-popover-target="popover-user-list" class="flex items-center gap-3 p-3 text-white transition rounded-lg hover:bg-blue-700">
                    <img src="{{asset('/images/iconos/usuarios.png')}}" alt="" class="w-6 h-6" style="filter: invert(1);">
                    Lista de usuarios
                </a>
                <div id="popover-user-list" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-700 bg-white border border-gray-200 rounded-lg shadow-sm p-2">
                    Accede a la lista de usuarios registrados en el sistema.
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </li>

            <li>
                <button class="flex items-center w-full gap-3 p-3 text-white transition rounded-lg hover:bg-blue-700" aria-controls="dropdown-vehiculos" data-collapse-toggle="dropdown-vehiculos">
                    <img src="{{asset('/images/iconos/catalogo.png')}}" alt="" class="w-6 h-6" style="filter: invert(1);">
                    <span>Catálogos</span>
                    <svg class="ml-auto w-4 h-4 transform transition-transform" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                    </svg>
                </button>
                <ul id="dropdown-vehiculos" class="hidden py-2 pl-6 space-y-2">
                    <!-- Vehículos -->
                    <li class="relative">
                        <a href="{{ route('modelos-vehiculos.index') }}" data-popover-target="popover-vehiculos" class="flex items-center gap-3 p-2 text-white transition rounded-lg hover:bg-blue-700">
                            <img src="{{asset('/images/iconos/vehiculo.png')}}" alt="" class="w-6 h-6" style="filter: invert(1);">
                            Vehículos
                        </a>
                        <div id="popover-vehiculos" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-700 bg-white border border-gray-200 rounded-lg shadow-sm p-2">
                            Consulta y administra los modelos de vehículos disponibles.
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </li>
                    <!-- Personas -->
                    <li class="relative">
                        <a href="{{ route('personas.index') }}" data-popover-target="popover-personas" class="flex items-center gap-3 p-2 text-white transition rounded-lg hover:bg-blue-700">
                            <img src="{{asset('/images/iconos/personas.png')}}" alt="" class="w-6 h-6" style="filter: invert(1);">
                            Personas
                        </a>
                        <div id="popover-personas" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-700 bg-white border border-gray-200 rounded-lg shadow-sm p-2">
                            Gestiona la lista de personas vinculadas al sistema.
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </li>
                    <!-- Gasolineras -->
                    <li class="relative">
                        <a href="{{ route('catalogo-gasolineras.index') }}" data-popover-target="popover-gasolineras" class="flex items-center gap-3 p-2 text-white transition rounded-lg hover:bg-blue-700">
                            <img src="{{asset('/images/iconos/gasolinera.png')}}" alt="" class="w-6 h-6" style="filter: invert(1);">
                            Gasolineras
                        </a>
                        <div id="popover-gasolineras" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-700 bg-white border border-gray-200 rounded-lg shadow-sm p-2">
                            Consulta las gasolineras registradas en el sistema.
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </li>
                    <!-- Tipos de Combustibles -->
                    <li class="relative">
                        <a href="{{ route('catalogo-combustibles.index') }}" data-popover-target="popover-combustibles" class="flex items-center gap-3 p-2 text-white transition rounded-lg hover:bg-blue-700">
                            <img src="{{asset('/images/iconos/combustible.png')}}" alt="" class="w-6 h-6" style="filter: invert(1);">
                            Tipos de Combustibles
                        </a>
                        <div id="popover-combustibles" role="tooltip" class="absolute z-10 invisible inline-block text-sm text-gray-700 bg-white border border-gray-200 rounded-lg shadow-sm p-2">
                            Revisa los tipos de combustibles disponibles.
                            <div class="tooltip-arrow" data-popper-arrow></div>
                        </div>
                    </li>
                </ul>
            </li>
            <li class="relative">
                <!-- Botón con popover -->
                <a href="{{route('orden.index')}}" 
                data-popover-target="popover-orden" 
                type="button" 
                class="flex items-center gap-3 p-3 text-white transition rounded-lg hover:bg-blue-700">
                    <span class="material-symbols-outlined">task</span>
                    Orden
                </a>
                
                <!-- Popover -->
                <div data-popover id="popover-orden" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Órdenes</h3>
                    </div>
                    <div class="px-3 py-2">
                        <p>Gestiona y organiza las órdenes de combustible con facilidad.</p>
                    </div>
                    <div data-popper-arrow></div>
                </div>
            </li>

            <li>
                <div class="flex items-center gap-3 p-3 text-white transition rounded-lg hover:bg-blue-700">
                <img src="{{asset('/images/iconos/informe.png')}}" alt="" class="w-6 h-6" style="filter: invert(1);">

                    @include('components.partials.modalInforme')
                </div>
            </li>
            @endrole




            
        </ul>

        <!-- Footer Buttons -->
        <div class="absolute bottom-6 left-0 w-full px-4 flex justify-between">
            <!-- Logout -->
            <form action="{{ route('logout') }}" method="POST" class="flex items-center gap-2">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-white bg-red-600 px-3 py-2 rounded-lg hover:bg-red-700">
                    <span class="material-symbols-outlined">logout</span>
                    Logout
                </button>
            </form>
            <!-- Theme Toggle -->
            <button id="theme-toggle" class="bg-white p-3 rounded-md" type="button"
                title="Cambiar tema: claro/oscuro"
                class="text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5">
                <svg id="theme-toggle-dark-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
                <svg id="theme-toggle-light-icon" class="hidden w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z">
                    </path>
                </svg>
            </button>

        </div>
    </div>
</aside>
