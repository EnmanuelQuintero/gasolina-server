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
                        <th class="px-6 py-3">Chofer</th>
                        <th class="px-6 py-3">Combustible</th>
                        <th class="px-6 py-3 w-auto">Cantidad</th>
                        <th class="px-6 py-3 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (  $relacionDetalleOrden as $index => $detalle)
                        <input type="hidden" name="detalles[{{ $index }}][id]" value="{{ $detalle->detalleOrden->id }}">

                        <tr>
                            <td>
                                <select name="detalles[{{ $index }}][numero_placa]" class="form-control dark:bg-gray-800 dark:text-white text-black bg-white">
                                    
                                    <option value=""></option>
                                    @foreach ($vehiculos as $vehiculo)
                                        <option value="{{ $vehiculo->id }}" {{ $vehiculo->placa == $detalle->detalleOrden->vehiculo->placa ? 'selected' : '' }}>
                                            {{ $vehiculo->placa }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <select name="detalles[{{ $index }}][id_chofer]" class="form-control dark:bg-gray-800 dark:text-white text-black bg-white">
                                    @foreach ($choferes as $persona)
                                        <option value="{{ $persona->id }}" {{ $persona->id == $detalle->detalleOrden->chofer_id ? 'selected' : '' }}>
                                            {{ $persona->primer_nombre }} {{ $persona->primer_apellido }}
                                        </option>
                                    @endforeach
                                </select>

                            </td>
                            <td>
                                <select name="detalles[{{ $index }}][id_combustible]" class="form-control dark:bg-gray-800 dark:text-white text-black bg-white">
                                    @foreach ($combustibles as $combustible)
                                        <option value="{{ $combustible->id }}" {{ $combustible->id == $detalle->detalleOrden->combustible_id ? 'selected' : '' }}>
                                            {{ $combustible->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" name="detalles[{{ $index }}][cantidad]" class="form-control dark:bg-gray-800 dark:text-white text-black bg-white w-auto " step="0.01" value="{{ $detalle->detalleOrden->cantidad  }}" required> <label for="detalle-cantidad">{{$detalle->detalleOrden->medida}}</label></td>
                            <td><button type="button" class="middle none center mr-4 rounded-lg bg-red-500 py-3 px-6 font-sans text-xs font-bold uppercase text-white shadow-md shadow-red-500/20 transition-all hover:shadow-lg hover:shadow-red-500/40 focus:opacity-[0.85] focus:shadow-none active:opacity-[0.85] active:shadow-none disabled:pointer-events-none disabled:opacity-50 disabled:shadow-none">Eliminar</button></td>
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
    document.addEventListener('DOMContentLoaded', () => {
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('fecha').value = today;

        let detailIndex = document.querySelectorAll('#detalles tbody tr').length;

        document.getElementById('add-detail').addEventListener('click', () => {
            const tbody = document.querySelector('#detalles tbody');
            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <select name="detalles[${detailIndex}][numero_placa]" class="form-control dark:bg-gray-800 dark:text-white text-black bg-white">
                        @foreach ($vehiculos as $vehiculo)
                            <option value="{{ $vehiculo->id }}">{{ $vehiculo->placa }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="detalles[${detailIndex}][id_chofer]" class="form-control dark:bg-gray-800 dark:text-white text-black bg-white">
                        @foreach ($personas as $persona)
                            <option value="{{ $persona->id }}">{{ $persona->primer_nombre }} {{ $persona->primer_apellido }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select name="detalles[${detailIndex}][id_chofer]" class="form-control dark:bg-gray-800 dark:text-white text-black bg-white">
                        @foreach ($choferes as $persona)
                            <option value="{{ $persona->id }}">{{ $persona->primer_nombre }} {{ $persona->primer_apellido }}</option>
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
