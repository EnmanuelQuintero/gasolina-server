<div class="mb-4">
    <label for="gasolinera_id" class="block text-sm font-medium text-gray-700">Seleccionar Gasolinera:</label>
    <select name="gasolinera_id" id="gasolinera_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
        @foreach ($gasolineras as $gasolinera)
            <option value="{{ $gasolinera->id }}">{{ $gasolinera->nombre }}</option>
        @endforeach
    </select>
</div>
