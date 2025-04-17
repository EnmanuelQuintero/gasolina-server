
<!-- Botón para Crear Vehículo -->
<div class="relative inline-block text-left group">
    <button onclick="openModalVehiculo()" class="rounded-lg px-4 py-2 flex gap-4 bg-blue-600 hover:bg-blue-700 text-blue-100  duration-300">
        
        <span class="material-symbols-outlined">
            add
        </span>
        Agregar Nuevo Vehículo
    </button>
    <div class="absolute left-1/2 transform dark:text-white -translate-x-1/2 z-10 hidden mt-2 w-48 rounded-md shadow-lg text-xs bg-transparent text-black p-2 group-hover:block">
        crea un nuevo registro de Vehículo.
    </div>
</div>



<!-- Modal -->
<div id="vehicleModal" class="fixed inset-0 z-50 invisible bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg">
        <div class="p-6">
            <h2 id="modalTitle" class="text-2xl font-semibold text-center mb-4 dark:text-white">Crear Vehículo</h2>

            <form id="vehicleForm" action="{{ route('catalogo-vehiculos.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo</label>
                    <select id="tipo" name="tipo" class="block w-full mt-1 p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" required>
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
                    <label for="relacion_marca_modelo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Marca - Modelo</label>
                    <select name="relacion_marca_modelo_id" id="relacion_marca_modelo_id" class="block w-full mt-1 p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" required>
                    <option value="" disabled>Seleccione un Modelo</option>
                        @foreach($marcasModelos as $marcaModelo)
                            
                            <option value="{{ $marcaModelo->id }}">{{ $marcaModelo->marca->nombre }} - {{ $marcaModelo->modelo->nombre }} </option>
                        @endforeach
                    </select>
                    @error('id_marca')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Color</label>
                    <div class="relative">
                        <select id="color" name="color" class="block w-full mt-1 p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" required>
                            <option value="" disabled>Seleccione un color</option>
                            <option value="blanco">Blanco</option>
                            <option value="negro">Negro</option>
                            <option value="gris">Gris</option>
                            <option value="plateado">Plateado</option>
                            <option value="azul">Azul</option>
                            <option value="rojo">Rojo</option>
                            <option value="verde">Verde</option>
                            <option value="morado">Morado</option>
                            <option value="amarillo">Amarillo</option>
                            <option value="naranja">Naranja</option>
                        </select>

                    </div>
                    @error('color')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="placa" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Placa</label>
                    <input type="text" name="placa" id="placa" class="block w-full mt-1 p-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300" required>
                    @error('placa')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    
                    <input type="checkbox" name="activo" id="activo" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600 hidden" checked>
                    @error('activo')
                        <div class="text-red-600 mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="text-center mt-6">
                    <button type="submit" class="w-full px-4 py-2 text-white bg-indigo-600 hover:bg-indigo-700 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-500 dark:hover:bg-indigo-600">
                        Guardar
                    </button>
                </div>
            </form>
        </div>

        <div class="p-4 bg-gray-50 dark:bg-gray-800 text-right w-full">
            <button onclick="closeModalVehiculo()" class="px-4 py-2 bg-red-500 dark:bg-gray-700 text-white dark:text-gray-200 rounded-md focus:outline-none w-full">Cancelar</button>
        </div>
    </div>
</div>
