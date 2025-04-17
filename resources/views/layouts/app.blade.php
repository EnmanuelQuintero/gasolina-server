<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>


    <style>
        @media print {
        .no-print {
            display: none;
            }
        }

    </style>


        <!-- Vite CSS -->
        @vite('resources/css/app.css')


        <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet" />
    <!-- Bootstrap CSS -->

   

</head>
<body>

        @yield('content')



    @stack('scripts') <!-- Para incluir scripts adicionales desde las vistas -->

</body>
</html>