<!-- Botón para Editar Persona --> 
<div class="relative inline-block text-left group">
    <!-- Ejemplo de botón para editar -->
    <button onclick="openModalPersona({{ json_encode($persona) }})" class="flex p-2.5 bg-yellow-500 rounded-xl hover:rounded-3xl hover:bg-yellow-600 transition-all duration-300 text-white">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
        </svg>
    </button>

    <div class="absolute left-1/2 transform -translate-x-1/2 z-10 hidden mt-2 w-48 rounded-md shadow-lg bg-transparent dark:text-white text-black text-xs p-2 group-hover:block">
        Edita el registro de Persona.
    </div>
</div>

<!-- Modal -->
<div id="editarPersonaModal" class="fixed inset-0 z-50 invisible bg-black bg-opacity-50 flex items-center justify-center pb-10">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-lg">
        <div class="p-6">
            <h3 id="modalTitle" class="text-lg font-semibold text-gray-900 dark:text-gray-100">Editar Persona</h3>
            <button type="button" class="absolute top-0 right-0 p-2 text-gray-900 dark:text-gray-100" onclick="closeModalEditarPersona()">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <form id="editPersonaForm" action="{{ route('personas.update', $persona->id) }}" method="POST" class="px-10">
    @csrf
    @method('PUT')
            <!-- Primer Nombre -->
            <div class="mb-4">
                <label for="editar_primer_nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Primer Nombre</label>
                <input type="text" name="primer_nombre" id="editar_primer_nombre" value="{{ $persona->primer_nombre }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>

            <!-- Segundo Nombre -->
            <div class="mb-4">
                <label for="editar_segundo_nombre" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Segundo Nombre</label>
                <input type="text" name="segundo_nombre" id="editar_segundo_nombre" value="{{ $persona->segundo_nombre }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <!-- Primer Apellido -->
            <div class="mb-4">
                <label for="editar_primer_apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Primer Apellido</label>
                <input type="text" name="primer_apellido" id="editar_primer_apellido" value="{{ $persona->primer_apellido }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
            </div>

            <!-- Segundo Apellido -->
            <div class="mb-4">
                <label for="editar_segundo_apellido" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Segundo Apellido</label>
                <input type="text" name="segundo_apellido" id="editar_segundo_apellido" value="{{ $persona->segundo_apellido }}" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <!-- Área -->
            <div class="mb-4">
                <label for="editar_departamento_cargo_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Departamento - cargo</label>
                <select name="departamento_cargo_id" id="editar_departamento_cargo_id" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-100 dark:focus:ring-blue-500 dark:focus:border-blue-500" required>
                    <option value="">Seleccione el cargo de la persona</option>
                    @foreach ($departamentosCargos as $departamentoCargo)
                        <option value="{{ $departamentoCargo->id }}" {{ $departamentoCargo->id == $persona->departamento_cargo_id ? 'selected' : '' }}>
                            {{ $departamentoCargo->departamento->nombre }} - {{ $departamentoCargo->cargo->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end space-x-2 mb-8">
                <button type="button" class="bg-red-500 text-white px-4 py-2 rounded-lg dark:bg-red-500 dark:text-white" onclick="closeModalEditarPersona()">Cancelar</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg dark:bg-blue-700">Actualizar</button>
            </div>
        </form>
    </div>
</div>
