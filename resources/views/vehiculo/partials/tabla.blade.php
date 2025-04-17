<div class="overflow-x-auto">
    <table id="filter-table" class="min-w-full border border-gray-300 rounded-xl">
        <thead>
            <tr class="bg-gray-200 rounded-xl">
                <th class="px-4 py-2 text-left  border-gray-300">
                    <span class="flex items-center">
                        placa
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th class="px-4 py-2 text-left  border-gray-300">
                    <span class="flex items-center">
                        tipo
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th class="px-4 py-2 text-left  border-gray-300">
                    <span class="flex items-center">
                        color
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th class="px-4 py-2 text-left  border-gray-300">
                    <span class="flex items-center">
                        marca
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th class="px-4 py-2 text-left  border-gray-300">
                    <span class="flex items-center">
                        modelo
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($vehiculos as $vehiculo)
                <tr class="hover:dark:bg-gray-700 dark:text-white hover:bg-gray-100 text-black ">
                    <td class="px-4 py-2 border-b border-gray-300">{{$vehiculo->placa}}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{$vehiculo->tipo}}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{$vehiculo->color}}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{$vehiculo->marcaModelo->marca->nombre}}</td>
                    <td class="px-4 py-2 border-b border-gray-300">
                        
                        <div class='flex items-center justify-center space-x-8'>
                            <div>
                                {{$vehiculo->marcaModelo->modelo->nombre}}
                            </div>
                            <div>
                                @include('vehiculo.partials.modalEditarVehiculo')
                            </div>
                            <div>
                                <div class="relative inline-block text-left group">
                                    <!-- Botón para Cambiar Estado Activo -->
                                    <button onclick="toggleActivo({{ $vehiculo->id }})" 
                                        class="flex p-2.5 {{ $vehiculo->activo ? 'bg-green-500 hover:bg-green-700' : 'bg-red-500 hover:bg-red-700' }} rounded-xl hover:rounded-3xl transition-all duration-300 text-white">
                                        <span class="material-symbols-outlined">
                                            {{ $vehiculo->activo ? 'visibility' : 'visibility_off' }}
                                        </span>
                                    </button>

                                    <div class="absolute left-1/2 transform  -translate-x-1/2 z-10 hidden mt-2 w-32 rounded-md shadow-lg text-xs bg-white text-black p-2 group-hover:block">
                                        Oculta el registro
                                    </div>
                                </div>
                            </div>


                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
