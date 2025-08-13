<!-- Botón para Editar Vehículo -->
<div class="relative inline-block text-left group">
    <!-- Botón de Editar Vehículo -->
    <!-- Botón de Editar Vehículo -->
    <div class="relative group">
        <button
            onclick="openModalEditVehiculo(this)"
            data-id="{{ $vehiculo->id }}"
            data-placa="{{ $vehiculo->placa }}"
            data-color="{{ $vehiculo->color }}"
            data-tipo="{{ $vehiculo->tipo }}"
            data-modelo="{{ $vehiculo->relacion_marca_modelo_id }}"
            data-activo="{{ $vehiculo->activo }}"
            data-estado="{{ $vehiculo->estado }}"
            class="flex items-center justify-center p-2.5 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full transition-all duration-300 shadow-md"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </button>

        <!-- Tooltip -->
        <div class="absolute z-10 hidden group-hover:block w-32 text-xs text-center bg-gray-800 text-white py-1 px-2 rounded-md -top-10 left-1/2 transform -translate-x-1/2">
            Editar vehículo
        </div>
    </div>


    <div class="absolute left-1/2 transform  -translate-x-1/2 z-10 hidden mt-2 w-48 rounded-md shadow-lg text-xs bg-white text-black p-2 group-hover:block">
        Edita un registro existente de Vehículo.
    </div>
</div>

<!-- Modal de Edición -->
<div id="editVehicleModal" class="fixed inset-0 z-50 invisible bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg">
        <div class="p-6">
            <h2 id="modalTitleEdit" class="text-2xl font-semibold text-center mb-4 dark:text-white">Editar Vehículo</h2>

            <form id="editVehicleForm" action="{{ route('catalogo-vehiculos.update',  $vehiculo->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <input type="hidden" id="edit_vehiculo_id" name="vehiculo_id" value="">

                <div class="mb-4">
                    <label for="edit_tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                    <select id="edit_tipo" name="tipo" class="block w-full mt-1 p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" required>
                        <option value="Sedan">Sedan</option>
                        <option value="Camion">Camion</option>
                        <option value="Moto">Moto</option>
                        <option value="Camioneta">Camioneta</option>
                    </select>
                    @error('tipo')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="edit_relacion_marca_modelo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca - Modelo</label>
                    <select name="relacion_marca_modelo_id" id="edit_relacion_marca_modelo_id" class="block w-full mt-1 p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" required>
                        <option value="" disabled>Seleccione un Modelo</option>
                        @foreach($marcasModelos as $marcaModelo)
                            <option value="{{ $marcaModelo->id }}">{{ $marcaModelo->marca->nombre }} - {{ $marcaModelo->modelo->nombre }}</option>
                        @endforeach
                    </select>
                    @error('id_marca')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="edit_color" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                    <select id="edit_color" name="color" class="block w-full mt-1 p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" required>
                        <option value="" disabled>Seleccione un color</option>
                        <option value="Blanco">Blanco</option>
                        <option value="Negro">Negro</option>
                        <option value="Gris">Gris</option>
                        <option value="Plateado">Plateado</option>
                        <option value="Azul">Azul</option>
                        <option value="Rojo">Rojo</option>
                        <option value="Verde">Verde</option>
                        <option value="Morado">Morado</option>
                        <option value="Amarillo">Amarillo</option>
                        <option value="Naranja">Naranja</option>
                    </select>
                    @error('color')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="edit_placa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Placa</label>
                    <input type="text" name="placa" id="edit_placa" class="block w-full mt-1 p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" required>
                    @error('placa')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="edit_estado" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                    <select id="edit_estado" name="estado" class="block w-full mt-1 p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" required>
                        <option value="operativo">Operativo</option>
                        <option value="taller">En taller</option>
                        <option value="baja">De baja</option>
                    </select>
                    @error('estado')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <input type="checkbox" name="activo" id="edit_activo" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600 hidden">
                    @error('activo')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center mt-6">
                    <button type="submit" class="w-full px-4 py-2 text-white bg-indigo-600 hover:bg-indigo-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>

        <div class="p-4 bg-gray-50 dark:bg-gray-800 text-right w-full">
            <button onclick="closeModalEditVehiculo()" class="px-4 py-2 bg-red-500 dark:bg-gray-700 text-white dark:text-gray-200 rounded-md focus:outline-none w-full">Cancelar</button>
        </div>
    </div>
</div>
