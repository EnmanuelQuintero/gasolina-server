<!-- Botón para Crear un nuevo registro de Persona-->
<div class="relative inline-block text-left group">
    <button onclick="openModalCreatePersona()" class="rounded-lg px-4 py-2 flex gap-4 bg-blue-600 hover:bg-blue-700 text-blue-100  duration-300">
        
        <span class="material-symbols-outlined">
            add
        </span>
        Agregar Nueva Persona al registro
    </button>
    <div class="absolute left-1/2 transform -translate-x-1/2 z-10 hidden mt-2 w-48 rounded-md shadow-lg bg-transparent dark:text-white text-black text-xs p-2 group-hover:block">
        crea un nuevo registro de Persona.
    </div>
</div>


<!-- Modal -->
<div id="personaModal" class="fixed inset-0 z-50 invisible bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg">
        <div class="p-6">
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-gray-100">Crear Persona</h3>
            <button type="button" class="absolute top-0 right-0 p-2 text-gray-900 dark:text-gray-100" onclick="closeModalPersona()">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="form" method="POST" action="{{route('personas.store')}}" class="p-4">
            @csrf
            <!-- Primer Nombre -->
            <div class="mb-4">
                <label for="primer_nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Primer Nombre</label>
                <input type="text" name="primer_nombre" id="primer_nombre" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>

            <!-- Segundo Nombre -->
            <div class="mb-4">
                <label for="segundo_nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Segundo Nombre</label>
                <input type="text" name="segundo_nombre" id="segundo_nombre" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <!-- Primer Apellido -->
            <div class="mb-4">
                <label for="primer_apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Primer Apellido</label>
                <input type="text" name="primer_apellido" id="primer_apellido" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>

            <!-- Segundo Apellido -->
            <div class="mb-4">
                <label for="segundo_apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Segundo Apellido</label>
                <input type="text" name="segundo_apellido" id="segundo_apellido" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <!-- Área -->
            <div class="mb-4">
                <label for="id_area" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departamento - cargo</label>
                <select name="departamento_cargo_id" id="departamento_cargo_id" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="" selected disabled>Seleccione el cargo de la persona</option>
                    <option value="Sin contrato">Sin contrato</option>
                    @foreach ($departamentosCargos as $departamentoCargo)
                        <option value="{{ $departamentoCargo->id }}">{{ $departamentoCargo->departamento->nombre }} - {{ $departamentoCargo->cargo->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end space-x-2">
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg dark:bg-red-500 dark:text-white" onclick="closeModalCreatePersona()">Cancelar</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg dark:bg-blue-700">Guardar</button>
            </div>
        </form>
    </div>
</div>