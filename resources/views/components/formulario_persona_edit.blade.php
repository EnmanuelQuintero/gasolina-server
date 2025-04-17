<div class="mb-4">
            <label for="primer_nombre" class="block text-sm font-medium text-gray-700">Primer Nombre</label>
            <input type="text" name="primer_nombre" id="primer_nombre" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('primer_nombre') }}" required>
        </div>

        <div class="mb-4">
            <label for="segundo_nombre" class="block text-sm font-medium text-gray-700">Segundo Nombre</label>
            <input type="text" name="segundo_nombre" id="segundo_nombre" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('segundo_nombre') }}">
        </div>

        <div class="mb-4">
            <label for="primer_apellido" class="block text-sm font-medium text-gray-700">Primer Apellido</label>
            <input type="text" name="primer_apellido" id="primer_apellido" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('primer_apellido') }}" required>
        </div>

        <div class="mb-4">
            <label for="segundo_apellido" class="block text-sm font-medium text-gray-700">Segundo Apellido</label>
            <input type="text" name="segundo_apellido" id="segundo_apellido" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" value="{{ old('segundo_apellido') }}">
        </div>

        <div class="mb-4">
            <label for="id_area" class="block text-sm font-medium text-gray-700">Área</label>
            <select name="id_area" id="id_area" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                <option value="">Seleccione un área</option>
                @foreach ($areas as $area)
                    <option value="{{ $area->id }}">{{ $area->nombre }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="id_cargo" class="block text-sm font-medium text-gray-700">Cargo</label>
            <select name="id_cargo" id="id_cargo" class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                <option value="">Seleccione un cargo</option>
                @foreach ($cargos as $cargo)
                    <option value="{{ $cargo->id }}">{{ $cargo->nombre }}</option>
                @endforeach
            </select>
        </div>