<p class="text-4xl font-bold text-gray-800 dark:text-white mb-8">Datos Generales</p>

<div class="w-full md:w-full grid md:grid-cols-3 grid-cols-1 h-auto p-10 justify-items-center gap-6 md:gap-12">

    <!-- Contenedor del primer bloque -->
    <div class="grid grid-cols-3 w-full md:w-3/5 border border-gray-300 shadow-md rounded-lg grid-rows-2 bg-white dark:bg-gray-800 dark:border-gray-600">

        <div class="bg-gray-900 flex justify-center items-center h-full rounded-tl-lg border-r border-gray-300 dark:border-gray-600">
            <span class="material-symbols-outlined text-white md:text-5xl sm:text-xl">
                directions_car
            </span>
        </div>

        <div class="col-span-2 text-center flex items-center justify-center bg-gray-100 dark:bg-gray-700">
            <p class="md:text-3xl text-gray-800 dark:text-white font-semibold">
                {{$conteoVehiculos}}
            </p>
        </div>

        <div class="col-span-3 flex justify-center items-center h-full w-full bg-gray-200 dark:bg-gray-700 rounded-b-lg">
            <p class="text-md text-gray-800 dark:text-gray-300 font-medium">
                Vehículos registrados
            </p>
        </div>

    </div>

    <!-- Contenedor del segundo bloque -->
    <div class="grid grid-cols-3 w-full md:w-3/5 border border-gray-300 shadow-md rounded-lg grid-rows-2 bg-white dark:bg-gray-800 dark:border-gray-600">

        <div class="bg-gray-900 flex justify-center items-center h-full rounded-tl-lg border-r border-gray-300 dark:border-gray-600">
            <span class="material-symbols-outlined text-white md:text-5xl">
                groups
            </span>
        </div>

        <div class="col-span-2 text-center flex items-center justify-center bg-gray-100 dark:bg-gray-700">
            <p class="md:text-3xl text-gray-800 dark:text-white font-semibold">
                {{$conteoPersonas}}
            </p>
        </div>

        <div class="col-span-3 flex justify-center items-center h-full w-full bg-gray-200 dark:bg-gray-700 rounded-b-lg">
            <p class="text-md text-gray-800 dark:text-gray-300 font-medium">
                Personas registradas
            </p>
        </div>

    </div>

    <!-- Contenedor del tercer bloque -->
    <div class="grid grid-cols-3 w-full md:w-3/5 border border-gray-300 shadow-md rounded-lg grid-rows-2 bg-white dark:bg-gray-800 dark:border-gray-600">

        <div class="bg-gray-900 flex justify-center items-center h-full rounded-tl-lg border-r border-gray-300 dark:border-gray-600">
            <span class="material-symbols-outlined text-white md:text-5xl">
                description
            </span>
        </div>

        <div class="col-span-2 text-center flex items-center justify-center bg-gray-100 dark:bg-gray-700">
            <p class="md:text-3xl text-gray-800 dark:text-white font-semibold">
                {{$conteoOrdenes}}
            </p>
        </div>

        <div class="col-span-3 flex justify-center items-center h-full w-full bg-gray-200 dark:bg-gray-700 rounded-b-lg">
            <p class="text-md text-gray-800 dark:text-gray-300 font-medium">
                Órdenes registradas
            </p>
        </div>

    </div>

</div>
