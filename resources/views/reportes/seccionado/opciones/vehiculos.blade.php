<div class="mb-4">
    <label for="vehiculo_id" class="block text-sm font-medium text-gray-700">Seleccionar Vehículo:</label>
    <select name="vehiculo_id" id="vehiculo_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        @foreach ($vehiculos as $vehiculo)
            <option value="{{ $vehiculo->id }}">{{ $vehiculo->placa }} - {{ $vehiculo->modelo }}</option>
        @endforeach
    </select>
</div>
