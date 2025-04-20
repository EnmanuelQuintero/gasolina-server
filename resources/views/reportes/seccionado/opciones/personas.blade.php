<div class="mb-4">
    <label for="persona_id" class="block text-sm font-medium text-gray-700">Seleccionar Persona:</label>
    <select name="persona_id" id="persona_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        @foreach ($personas as $persona)
            <option value="{{ $persona->id }}">{{ $persona->primer_nombre }} {{ $persona->primer_apellido }}</option>
        @endforeach
    </select>
</div>
