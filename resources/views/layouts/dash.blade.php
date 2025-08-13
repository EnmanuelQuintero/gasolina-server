<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alcaldia Municipal de Leon</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Agrega los estilos de Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Agregar Font Awesome CDN en el head -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,0,0" />


        <!-- Vite CSS -->
        @vite(['resources/css/app.css','resources/js/app.js'])


    <!-- flowbite -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>





    <style>
    /* Estilos para el overlay */
    .loading-screen {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.7); /* Fondo semitransparente */
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        z-index: 1000; /* Encima de otros elementos */
    }

    .rotating-image {
        width: 150px; /* Tamaño de la imagen */
        height: auto;
        animation: rotate3d 2s linear infinite; /* Aplicar animación de rotación en 3D */
        transform-style: preserve-3d; /* Mantener el efecto 3D */
    }

    @keyframes rotate3d {
        0% {
            transform: rotateY(0deg) rotateX(0deg); /* Comienza en posición normal */
        }
        25% {
            transform: rotateY(90deg); /* Rota 90 grados en el eje Y */
        }
        50% {
            transform: rotateY(180deg); /* Rota 180 grados en el eje Y */
        }
        75% {
            transform: rotateY(270deg); /* Rota 270 grados en el eje Y */
        }
        100% {
            transform: rotateY(360deg); /* Vuelve a la posición original */
        }
    }
</style>
    
    
    <style>
        .espacios {


            margin-top: 5%; /* Espacio desde la parte superior */
        }
    </style>

</head>
<body class="dark:bg-slate-900 bg-auto h-full" >

<!-- Pantalla de carga -->
<div id="loading-screen" class="loading-screen">
    <img src="{{asset('/images/logo.png')}}" alt="Cargando..." class="rotating-image" />
    <p>Cargando...</p>
</div>
@include('components.sidebar')

<div class="p-4 sm:ml-64 transition-all duration-300">
    <main>
        <div class="grid justify-items-center espacios px-8 h-full w-full">
            <!-- Contenido Principal -->
            <!-- Botón flotante -->
            <button onclick="window.history.back()" 
                    class="fixed top-5 right-5 p-4 bg-gray-800 text-white rounded-full shadow-lg hover:bg-gray-700 transition duration-300">
                <i class="fas fa-arrow-left"></i> <!-- Icono de flecha hacia atrás -->
            </button>


            @yield('content')
        </div>
    </main>
</div>







    <!-- Bootstrap JS, Popper.js -->

    @yield('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const loadingScreen = document.getElementById('loading-screen');

        // Mostrar la pantalla de carga antes de redirigir
        document.querySelectorAll('.format-btn').forEach(button => {
            button.addEventListener('click', function() {
                loadingScreen.style.display = 'flex'; // Muestra la pantalla de carga
                const selectedOption = button.innerText.trim();

                // Simula una redirección (ejemplo para pruebas)
                setTimeout(() => {
                    // Oculta la pantalla de carga después de simular la generación del informe
                    loadingScreen.style.display = 'none';
                }, 3000); // Cambia este valor para pruebas
            });
        });
    });

    // Ocultar la pantalla de carga al cargar completamente la página
    window.addEventListener('load', function() {
        document.getElementById('loading-screen').style.display = 'none';
    });
</script>





    <script>
    // Obtener el sidebar, el botón de hamburguesa y el contenedor de la sidebar
    const sidebar = document.getElementById('logo-sidebar');
    const sidebarToggle = document.getElementById('sidebar-toggle');

    // Añadir un evento de clic al botón de hamburguesa para abrir/cerrar el sidebar
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('-translate-x-full');

        // Ocultar o mostrar el botón de hamburguesa dependiendo del estado de la sidebar
        if (sidebar.classList.contains('-translate-x-full')) {
            sidebarToggle.classList.remove('hidden');
        } else {
            sidebarToggle.classList.add('hidden');
        }
    });

    // Cerrar el sidebar si se hace clic fuera de él
    document.addEventListener('click', (event) => {
        if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
            sidebar.classList.add('-translate-x-full'); // Cerrar el sidebar
            sidebarToggle.classList.remove('hidden'); // Mostrar el botón de hamburguesa
        }
    });
</script>


    <script src="{{asset('js/flowbite.min.js')}}"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Referencias a los íconos de tema oscuro y claro
        var themeToggleDarkIcon = document.getElementById('theme-toggle-dark-icon');
        var themeToggleLightIcon = document.getElementById('theme-toggle-light-icon');
        var themeToggleBtn = document.getElementById('theme-toggle');

        if (!themeToggleDarkIcon || !themeToggleLightIcon || !themeToggleBtn) {
            console.error('Uno o más elementos del tema no se encuentran en el DOM.');
            return;
        }

        // Verifica el tema almacenado en localStorage o el preferido del sistema
        var initialTheme = localStorage.getItem('color-theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', initialTheme === 'dark');
        themeToggleDarkIcon.classList.toggle('hidden', initialTheme === 'light');
        themeToggleLightIcon.classList.toggle('hidden', initialTheme === 'dark');

        themeToggleBtn.addEventListener('click', function() {
            var isDarkMode = document.documentElement.classList.contains('dark');
            if (isDarkMode) {
                document.documentElement.classList.remove('dark');
                localStorage.setItem('color-theme', 'light');
                themeToggleDarkIcon.classList.remove('hidden');
                themeToggleLightIcon.classList.add('hidden');
            } else {
                document.documentElement.classList.add('dark');
                localStorage.setItem('color-theme', 'dark');
                themeToggleDarkIcon.classList.add('hidden');
                themeToggleLightIcon.classList.remove('hidden');
            }
        });
    });
</script>






</body>
</html>






