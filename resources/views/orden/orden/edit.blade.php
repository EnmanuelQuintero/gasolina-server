@extends('layouts.dash')

@section('content')
<div class="w-full mx-auto p-4 bg-white border text-black dark:text-white border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 mb-4">
    <h1 class="text-2xl font-semibold mb-4 text-center">Editar Orden</h1>

    <form action="{{ route('orden.update', $orden->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="fecha" class="block text-sm font-medium text-gray-700 dark:text-white">Fecha</label>
            <input type="date" name="fecha" id="fecha" class="mt-1 block w-full border border-gray-300 dark:bg-slate-900 dark:text-white bg-white text-black rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ $orden->fecha }}" required readonly>
        </div>

        <div class="mb-4">
            <label for="id_gasolinera" class="block text-sm font-medium text-gray-700 dark:text-white">Gasolinera</label>
            <select name="id_gasolinera" id="id_gasolinera" class="mt-1 block w-full border border-gray-300 dark:bg-slate-900 dark:text-white bg-white text-black rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                @foreach ($gasolineras as $gasolinera)
                    <option value="{{ $gasolinera->id }}" {{ $gasolinera->id == $orden->gasolinera_id ? 'selected' : '' }}>
                        {{ $gasolinera->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="id_autorizado" class="block text-sm font-medium text-gray-700 dark:text-white">Autorizado</label>
            <select name="id_autorizado" id="id_autorizado" class="mt-1 block w-full border border-gray-300 dark:bg-slate-900 dark:text-white bg-white text-black rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                @foreach ($autorizados as $persona)
                    <option value="{{ $persona->id }}" {{ $persona->id == $orden->autorizado_id ? 'selected' : '' }}>
                        {{ $persona->primer_nombre }} {{ $persona->primer_apellido }}
                    </option>
                @endforeach
            </select>

        </div>

        <div class="mb-4">
            <label for="observaciones" class="block text-sm font-medium text-gray-700 dark:text-white">Observaciones</label>
            <textarea name="observaciones" id="observaciones" class="mt-1 block w-full border dark:bg-gray-900 dark:text-white text-black border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ $orden->observaciones }}</textarea>
        </div>
        <p class="text-xl text-center font-bold">
            Medida
        </p>




        <ul class="items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg sm:flex dark:bg-gray-700 dark:border-gray-600 dark:text-white">
            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                <div class="flex items-center ps-3">
                    <input id="horizontal-list-radio-license" type="radio" value="Litros" name="medida" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" {{ $medida == "Litros" ? 'checked' : '' }}>
                    <label for="horizontal-list-radio-license" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Litros </label>
                </div>
            </li>
            <li class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                <div class="flex items-center ps-3">
                    <input id="horizontal-list-radio-id" type="radio" value="Galones" name="medida" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500" {{ $medida == "Galones" ? 'checked' : '' }}>
                    <label for="horizontal-list-radio-id" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Galones</label>
                </div>
            </li>
        </ul>
        <h3 class="text-xl font-semibold text-center mb-4">Detalles de Orden</h3>
        <div class="overflow-x-auto w-full">
            <table id="detalles" class="w-full text-sm text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-200">
                    <tr>
                        <th class="px-6 py-3">Placa</th>
                        <th class="px-6 py-3">Kilometros</th>
                        <th class="px-6 py-3">Chofer</th>
                        <th class="px-6 py-3">Combustible</th>
                        <th class="px-6 py-3 w-auto">Cantidad</th>
                        <th class="px-6 py-3 text-center">Acción</th>
                    </tr>
                </thead>
<tbody>
    @foreach ($relacionDetalleOrden as $index => $detalle)
        <input type="hidden" name="detalles[{{ $index }}][id]" value="{{ $detalle->detalleOrden->id }}">

        <tr>
<td>
    @if ($detalle->detalleOrden->vehiculo->estado === 'operativo')
        <select name="detalles[{{ $index }}][numero_placa]" 
                class="form-control dark:bg-gray-800 dark:text-white text-black bg-white" 
                id="vehiculo_placa_{{ $index }}">
            <option value=""></option>
            @foreach ($vehiculos as $vehiculo)
                @if ($vehiculo->estado === 'operativo')
                    <option value="{{ $vehiculo->id }}" 
                            {{ $vehiculo->placa == $detalle->detalleOrden->vehiculo->placa ? 'selected' : '' }} 
                            data-es-alcaldia="{{ $vehiculo->alcaldia ? 1 : 0 }}">
                        {{ $vehiculo->placa }}
                    </option>
                @endif
            @endforeach
        </select>
    @else
        <input type="text" value="{{ $detalle->detalleOrden->vehiculo->placa }}" 
               class="form-control dark:bg-gray-800 dark:text-white text-black bg-white" 
               readonly />
        <!-- Campo hidden para enviar el ID del vehículo aunque no sea operativo -->
        <input type="hidden" name="detalles[{{ $index }}][numero_placa]" value="{{ $detalle->detalleOrden->vehiculo->id }}" />
    @endif
</td>

<!-- Kilómetros -->
<td>
    <label for="detalles[{{ $index }}][kilometros]" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1"></label>


    <input type="number" name="detalles[{{ $index }}][kilometros]" 
           class="block w-full border rounded-md dark:bg-gray-700 dark:text-gray-200 mt-4" 
           step="0.01" id="kilometros_{{ $index }}" 
           value="{{ $detalle->detalleOrden->kilometros }}" 
           @if(!$detalle->detalleOrden->vehiculo->alcaldia) disabled @endif>
</td>

            <td>
                <select name="detalles[{{ $index }}][id_chofer]" 
                        class="form-control dark:bg-gray-800 dark:text-white text-black bg-white"
                        {{ $detalle->detalleOrden->vehiculo->estado !== 'operativo' ? 'readonly' : '' }}>
                    @foreach ($choferes as $persona)
                        <option value="{{ $persona->id }}" 
                                {{ $persona->id == $detalle->detalleOrden->chofer_id ? 'selected' : '' }}>
                            {{ $persona->primer_nombre }} {{ $persona->primer_apellido }}
                        </option>
                    @endforeach
                </select>
            </td>

            <td>
                <select name="detalles[{{ $index }}][id_combustible]" 
                        class="form-control dark:bg-gray-800 dark:text-white text-black bg-white"
                        {{ $detalle->detalleOrden->vehiculo->estado !== 'operativo' ? 'readonly' : '' }}>
                    @foreach ($combustibles as $combustible)
                        <option value="{{ $combustible->id }}" 
                                {{ $combustible->id == $detalle->detalleOrden->combustible_id ? 'selected' : '' }}>
                            {{ $combustible->nombre }}
                        </option>
                    @endforeach
                </select>
            </td>

            <td>
                <input type="number" name="detalles[{{ $index }}][cantidad]" 
                       class="form-control dark:bg-gray-800 dark:text-white text-black bg-white w-auto mt-5"
                       step="0.01" value="{{ $detalle->detalleOrden->cantidad }}" required 
                       {{ $detalle->detalleOrden->vehiculo->estado !== 'operativo' ? 'readonly' : '' }} />
                <label for="detalle-cantidad">{{$detalle->detalleOrden->medida}}</label>
            </td>

            <td>
                <button type="button" class="middle none center mr-4 rounded-lg bg-red-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">
                    Eliminar
                </button>
            </td>
        </tr>
    @endforeach
</tbody>

            </table>
        </div>

        <div class="flex justify-center mt-4 gap-4">
            <button type="button" id="add-detail" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Agregar Detalle</button>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Guardar Cambios</button>
        </div>
    </form>
</div>
<script>
document.addEventListener('change', function(event) {
    if (event.target.id.startsWith('vehiculo_placa_')) {
        const selectedOption = event.target.options[event.target.selectedIndex];
        const esAlcaldia = selectedOption.getAttribute('data-es-alcaldia') === '1';

        // Encontramos el input de kilómetros asociado a esta fila
        const kilometrosInput = event.target.closest('tr').querySelector('input[type="number"]');
        
        // Habilitar o deshabilitar el campo de Kilómetros según corresponda
        if (esAlcaldia) {
            kilometrosInput.disabled = false; // Habilitamos el campo si es de la alcaldía
        } else {
            kilometrosInput.disabled = true; // Deshabilitamos el campo si no es de la alcaldía
        }
    }
});

</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('fecha').value = today;

        let detailIndex = document.querySelectorAll('#detalles tbody tr').length;

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
                <td>
                    <select name="detalles[${detailIndex}][id_chofer]" class="form-control dark:bg-gray-800 dark:text-white text-black bg-white">
                        @foreach ($choferes as $persona)
                            <option value="{{ $persona->id }}">{{ $persona->primer_nombre }} {{ $persona->primer_apellido }}</option>
                        @endforeach
                    </select>

                </td>
                            <td>
                <select name="detalles[{{ $index }}][id_combustible]" 
                        class="form-control dark:bg-gray-800 dark:text-white text-black bg-white"
                        {{ $detalle->detalleOrden->vehiculo->estado !== 'operativo' ? 'readonly' : '' }}>
                    @foreach ($combustibles as $combustible)
                        <option value="{{ $combustible->id }}" 
                                {{ $combustible->id == $detalle->detalleOrden->combustible_id ? 'selected' : '' }}>
                            {{ $combustible->nombre }}
                        </option>
                    @endforeach
                </select>
            </td>
                <td>
                    <select name="detalles[${detailIndex}][medida]" class="form-control dark:bg-gray-800 dark:text-white text-black bg-white">
                        <option value="Litros">Litros</option>
                        <option value="Galones">Galones</option>
                    </select>
                </td>
                <td><button type="button" class="bg-red-500 text-white px-2 py-1 rounded-lg hover:bg-red-600 remove-row">Eliminar</button></td>
            `;
            tbody.appendChild(newRow);
            detailIndex++;
        });

        document.querySelector('#detalles').addEventListener('click', (e) => {
            if (e.target.classList.contains('remove-row')) {
                e.target.closest('tr').remove();
            }
        });
    });
</script>

@endsection