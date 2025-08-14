@extends('layouts.dash')

@section('content')
<div class="max-w-5xl mx-auto p-6 bg-white border border-gray-300 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-600">
    <h1 class="text-3xl font-bold mb-6 text-center text-gray-800 dark:text-white">📋 Crear Orden</h1>
    
    <form action="{{ route('orden.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Fecha -->
            <div>
                <label for="fecha" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha</label>
                <input 
                    type="date" 
                    name="fecha" 
                    id="fecha" 
                    class="mt-1 block w-full border border-gray-300 dark:bg-gray-700 dark:text-gray-200 bg-white rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                    required readonly>
            </div>

            <!-- Gasolinera -->
            <div>
                <label for="id_gasolinera" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Gasolinera</label>
                <select 
                    name="id_gasolinera" 
                    id="id_gasolinera" 
                    class="mt-1 block w-full border border-gray-300 dark:bg-gray-700 dark:text-gray-200 bg-white rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                    required>
                    @foreach ($gasolineras as $gasolinera)
                        <option value="{{ $gasolinera->id }}">{{ $gasolinera->nombre }}</option>
                    @endforeach
                </select>
                
                <!-- Descripción con popover -->
                <button data-popover-target="popover-gasolinera" type="button" class="mt-2 text-blue-500 text-sm underline">¿Qué es esto?</button>

                <div data-popover id="popover-gasolinera" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                        <h3 class="font-semibold text-gray-900 dark:text-white">Gasolinera</h3>
                    </div>
                    <div class="px-3 py-2">
                        <p>Selecciona la gasolinera de la cual deseas realizar la orden.</p>
                    </div>
                    <div data-popper-arrow></div>
                </div>
            </div>

        </div>

        <!-- Autorizado -->
        <div>
            <label for="id_autorizado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Autorizado</label>
            <select 
                name="id_autorizado" 
                id="id_autorizado" 
                class="mt-1 block w-full border border-gray-300 dark:bg-gray-700 dark:text-gray-200 bg-white rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                required>
                @foreach ($personas as $persona)
                    @if ($persona->autorizado == 1)
                        <option value="{{ $persona->id }}">{{ $persona->primer_nombre }} {{ $persona->primer_apellido }}</option>
                    @endif
                @endforeach

            </select>
            
            <!-- Descripción con popover -->
            <button data-popover-target="popover-autorizado" type="button" class="mt-2 text-blue-500 text-sm underline">¿Qué es esto?</button>

            <div data-popover id="popover-autorizado" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Autorizado</h3>
                </div>
                <div class="px-3 py-2">
                    <p>Selecciona la persona autorizada para aprobar esta orden.</p>
                </div>
                <div data-popper-arrow></div>
            </div>
        </div>


        <!-- Observaciones -->
        <div>
            <label for="observaciones" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observaciones</label>
            <textarea 
                name="observaciones" 
                id="observaciones" 
                rows="4" 
                class="mt-1 block w-full border border-gray-300 dark:bg-gray-700 dark:text-gray-200 bg-white rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" 
                placeholder="Escribe tus observaciones aquí"></textarea>
            
            <!-- Descripción con popover -->
            <button data-popover-target="popover-observaciones" type="button" class="mt-2 text-blue-500 text-sm underline">¿Qué es esto?</button>

            <div data-popover id="popover-observaciones" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Observaciones</h3>
                </div>
                <div class="px-3 py-2">
                    <p>Aquí puedes agregar cualquier comentario o detalle adicional que consideres importante para esta orden.</p>
                </div>
                <div data-popper-arrow></div>
            </div>
        </div>


        <!-- Medida -->
        <div>
            <p class="text-lg font-semibold mb-2 text-gray-700 dark:text-gray-300">Medida</p>
            
            <!-- Descripción con popover -->
            <button data-popover-target="popover-medida" type="button" class="text-blue-500 text-sm underline">¿Qué es esto?</button>

            <div data-popover id="popover-medida" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-white">Medida</h3>
                </div>
                <div class="px-3 py-2">
                    <p>Selecciona la unidad de medida para la cantidad de combustible: puedes elegir entre Litros o Galones.</p>
                </div>
                <div data-popper-arrow></div>
            </div>

            <div class="flex items-center space-x-6 mt-2">
            <label class="flex items-center">
                <input type="radio" name="medida" value="Litros" required class="text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-gray-700 dark:text-gray-300">Litros</span>
            </label>
            <label class="flex items-center">
                <input type="radio" name="medida" value="Galones" class="text-blue-600 focus:ring-blue-500">
                <span class="ml-2 text-gray-700 dark:text-gray-300">Galones</span>
            </label>

            </div>
        </div>


        <!-- Detalles de la orden -->
        <div id="details-container">
            <h3 class="text-2xl font-semibold text-center mb-4 text-gray-800 dark:text-white">Detalles de Orden</h3>
            <div class="overflow-x-auto">
                <table id="detalles" class="w-full text-sm border-collapse bg-gray-50 dark:bg-gray-700 rounded-lg">
                    <thead>
                        <tr class="text-left bg-gray-200 dark:bg-gray-800 text-gray-700 dark:text-gray-300">
                            <th class="px-4 py-2">Placa</th>
                            <th class="px-4 py-2">Kilómetros</th>
                            <th class="px-4 py-2">Chofer</th>
                            <th class="px-4 py-2">Combustible</th>
                            <th class="px-4 py-2">Cantidad</th>
                            <th class="px-4 py-2">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2">
                                <label for="detalles[0][numero_placa]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Número de Placa</label>

                                <!-- Descripción con popover -->
                                <button data-popover-target="popover-numero-placa" type="button" class="text-blue-500 text-sm underline">¿Qué es esto?</button>

                                <div data-popover id="popover-numero-placa" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Número de Placa</h3>
                                    </div>
                                    <div class="px-3 py-2">
                                        <p>Selecciona el número de placa del vehículo de la lista proporcionada. Este campo es necesario para identificar el vehículo asociado a la orden.</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>

                                <select name="detalles[0][numero_placa]" class="block w-full bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border rounded-md mt-2" id="vehiculo_placa">
                                    <!-- Opción "Elija" por defecto -->
                                    <option value="" disabled selected>Elija un vehículo</option>
                                    
                                    @foreach ($vehiculos as $vehiculo)
                                        @if ($vehiculo->estado === 'operativo')
                                            <!-- Aquí agregamos el atributo data-es-alcaldia -->
                                            <option value="{{ $vehiculo->id }}" data-es-alcaldia="{{ $vehiculo->alcaldia ? 1 : 0 }}">
                                                {{ $vehiculo->placa }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                            </td>

                            <!-- Condición para mostrar el campo de Kilómetros -->
                            <td class="px-4 py-2 mt-6">
                                <label for="detalles[0][kilometros]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kilómetros</label>
                                <button data-popover-target="popover-kilometros" type="button" class="text-blue-500 text-sm underline">¿Qué es esto?</button>

                                <div data-popover id="popover-kilometros" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Kilómetros</h3>
                                    </div>
                                    <div class="px-3 py-2">
                                        <p>Este campo es obligatorio solo para los vehículos de la alcaldía. Si el vehículo seleccionado no pertenece a la alcaldía, este campo estará deshabilitado.</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>

                                <input type="number" name="detalles[0][kilometros]" class="block w-full border rounded-md dark:bg-gray-700 dark:text-gray-200 mt-4" step="0.01" id="kilometros" disabled>
                            </td>



                            <td class="px-4 py-2">
                                <label for="detalles[0][id_chofer]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Chofer</label>

                                <!-- Descripción con popover -->
                                <button data-popover-target="popover-chofer" type="button" class="text-blue-500 text-sm underline">¿Qué es esto?</button>

                                <div data-popover id="popover-chofer" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Chofer</h3>
                                    </div>
                                    <div class="px-3 py-2">
                                        <p>Selecciona el chofer que realizará la entrega de la orden. Este campo es esencial para asignar la responsabilidad del transporte.</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>

                                <select name="detalles[0][id_chofer]" class="block w-full bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border rounded-md mt-2">
                                    @foreach ($personas as $persona)
                                        @if ($persona->chofer == 1)
                                            <option value="{{ $persona->id }}">{{ $persona->primer_nombre }} {{ $persona->primer_apellido }}</option>
                                        @endif
                                    @endforeach
                                </select>

                            </td>


                            <td class="px-4 py-2">
                                <label for="detalles[0][id_combustible]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tipo de Combustible</label>

                                <!-- Descripción con popover -->
                                <button data-popover-target="popover-combustible" type="button" class="text-blue-500 text-sm underline">¿Qué es esto?</button>

                                <div data-popover id="popover-combustible" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Tipo de Combustible</h3>
                                    </div>
                                    <div class="px-3 py-2">
                                        <p>Selecciona el tipo de combustible que se utilizará para la orden. Es importante elegir el tipo correcto para garantizar la disponibilidad.</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>

                                <select name="detalles[0][id_combustible]" class="block w-full bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border rounded-md mt-2">
                                    @foreach ($combustibles as $combustible)
                                        <option value="{{ $combustible->id }}">{{ $combustible->nombre }}</option>
                                    @endforeach
                                </select>
                            </td>


                            <td class="px-4 py-2">
                                <label for="detalles[0][cantidad]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cantidad de Combustible</label>

                                <!-- Descripción con popover -->
                                <button data-popover-target="popover-cantidad" type="button" class="text-blue-500 text-sm underline">¿Qué es esto?</button>

                                <div data-popover id="popover-cantidad" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Cantidad de Combustible</h3>
                                    </div>
                                    <div class="px-3 py-2">
                                        <p>Ingresa la cantidad de combustible que se solicita para la orden. Puedes especificar la cantidad en litros o galones, según el tipo de medida seleccionado.</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>

                                <input type="number" name="detalles[0][cantidad]" class="block w-full border rounded-md dark:bg-gray-700 dark:text-gray-200 mt-2" step="0.01" required>
                            </td>


                            <td class="px-4 py-2 text-center">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Eliminar Fila</label>

                                <!-- Descripción con popover -->
                                <button data-popover-target="popover-eliminar" type="button" class="text-blue-500 text-sm underline">¿Qué es esto?</button>

                                <div data-popover id="popover-eliminar" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
                                    <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                                        <h3 class="font-semibold text-gray-900 dark:text-white">Eliminar Fila</h3>
                                    </div>
                                    <div class="px-3 py-2">
                                        <p>Haz clic en "Eliminar" para quitar esta fila del detalle de la orden. Asegúrate de que no se eliminen datos importantes antes de continuar.</p>
                                    </div>
                                    <div data-popper-arrow></div>
                                </div>

                                <button type="button" class="text-red-500 hover:text-red-600 remove-row mt-2">Eliminar</button>
                            </td>

                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4 text-center">
                <button type="button" id="add-detail" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg">
                    Agregar Detalle
                </button>
            </div>
        </div>

        <!-- Botón guardar -->
        <div class="text-center">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md focus:ring-4 focus:ring-blue-300">
                Guardar Orden
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('vehiculo_placa').addEventListener('change', function() {
        // Obtenemos la opción seleccionada
        var selectedOption = this.options[this.selectedIndex];

        // Verificamos si el vehículo es de la Alcaldía
        var esAlcaldia = selectedOption.getAttribute('data-es-alcaldia') === '1'; // '1' indica que es de la alcaldía

        // Obtenemos el campo de kilómetros
        var kilometrosInput = document.getElementById('kilometros');

        // Habilitar o deshabilitar el campo de Kilómetros según corresponda
        if (esAlcaldia) {
            kilometrosInput.disabled = false; // Habilitamos el campo si es de la alcaldía
        } else {
            kilometrosInput.disabled = true; // Deshabilitamos el campo si no es de la alcaldía
        }
    });
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const fechaInput = document.getElementById('fecha');
    const today = new Date().toISOString().split('T')[0];
    fechaInput.value = today;

    const saveOrderButton = document.querySelector('button[type="submit"]');
    let detailIndex = 1;

    // Agregar nuevo detalle
    document.getElementById('add-detail').addEventListener('click', () => {
        const tbody = document.querySelector('#detalles tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="px-4 py-2">
                <select name="detalles[${detailIndex}][numero_placa]" 
                    class="block w-full bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border rounded-md" 
                    id="vehiculo_placa_${detailIndex}">
                    <option value="" disabled selected>Elija un vehículo</option>
                    @foreach ($vehiculos as $vehiculo)
                        @if ($vehiculo->estado === 'operativo')
                            <option value="{{ $vehiculo->id }}" data-es-alcaldia="{{ $vehiculo->alcaldia ? 1 : 0 }}">
                                {{ $vehiculo->placa }}
                            </option>
                        @endif
                    @endforeach
                </select>
            </td>
            <!-- Nueva columna de Kilómetros -->
            <td class="px-4 py-2">
                <label for="detalles[${detailIndex}][kilometros]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"></label>
                <input type="number" name="detalles[${detailIndex}][kilometros]" 
                    class="block w-full border rounded-md dark:bg-gray-700 dark:text-gray-200" 
                    step="0.01" id="kilometros_${detailIndex}" disabled>
            </td>
            <td class="px-4 py-2">
                <select name="detalles[${detailIndex}][id_chofer]" 
                    class="block w-full bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border rounded-md">
                    @foreach ($personas as $persona)
                        @if ($persona->chofer == 1)
                            <option value="{{ $persona->id }}">{{ $persona->primer_nombre }} {{ $persona->primer_apellido }}</option>
                        @endif
                    @endforeach
                </select>
            </td>

            <td class="px-4 py-2">
                <select name="detalles[${detailIndex}][id_combustible]" 
                    class="block w-full bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200 border rounded-md">
                    @foreach ($combustibles as $combustible)
                        <option value="{{ $combustible->id }}">{{ $combustible->nombre }}</option>
                    @endforeach
                </select>
            </td>

            <td class="px-4 py-2">
                <input type="number" name="detalles[${detailIndex}][cantidad]" 
                    class="block w-full border rounded-md dark:bg-gray-700 dark:text-gray-200" 
                    step="0.01" required>
            </td>



            <td class="px-4 py-2 text-center">
                <button type="button" 
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition-all remove-row">
                    Eliminar
                </button>
            </td>
        `;

        tbody.appendChild(newRow);
        detailIndex++;

        // Mostrar el botón de guardar si se agrega un detalle
        saveOrderButton.classList.remove('hidden'); 

        // Agregar evento para habilitar/deshabilitar el campo de Kilómetros
        const vehiculoSelect = document.querySelector(`#vehiculo_placa_${detailIndex - 1}`);
        vehiculoSelect.addEventListener('change', (e) => {
            const selectedOption = e.target.options[e.target.selectedIndex];
            const isAlcaldia = selectedOption.getAttribute('data-es-alcaldia') === '1';
            const kilometrosInput = document.querySelector(`#kilometros_${detailIndex - 1}`);
            // Habilitar o deshabilitar el campo de Kilómetros según si el vehículo es de la alcaldía
            kilometrosInput.disabled = !isAlcaldia;
        });
    });

    // Eliminar una fila de detalles
    document.querySelector('#detalles').addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-row')) {
            e.target.closest('tr').remove();
            // Ocultar el botón de guardar si no hay detalles
            if (document.querySelectorAll('#detalles tbody tr').length === 0) {
                saveOrderButton.classList.add('hidden');
            }
        }
    });
});

// Cambiar texto dinámico según selección de medida
document.querySelectorAll('input[name="medida"]').forEach((radio) => {
    radio.addEventListener('change', function () {
        document.querySelectorAll('.medida').forEach((label) => {
            label.textContent = this.value;
        });
    });
});

</script>


@endsection
