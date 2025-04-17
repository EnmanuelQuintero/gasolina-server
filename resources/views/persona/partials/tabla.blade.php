<div class="overflow-x-auto">
    <table id="filter-table" class="min-w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-200">
                <th class="px-4 py-2 text-left  border-gray-300">
                    <span class="flex items-center">
                        Nombres y Apellidos
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th class="px-4 py-2 text-left  border-gray-300">
                    <span class="flex items-center">
                        Departamento
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>
                <th class="px-4 py-2 text-left  border-gray-300">
                    <span class="flex items-center">
                        Cargo
                        <svg class="w-4 h-4 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m8 15 4 4 4-4m0-6-4-4-4 4"/>
                        </svg>
                    </span>
                </th>


            </tr>
        </thead>
        <tbody>
            @foreach ($personas as $persona)
                <tr class="hover:dark:bg-gray-700 dark:text-white hover:bg-gray-100 text-black ">
                    <td class="px-4 py-2 border-b border-gray-300">{{$persona->primer_nombre}} {{$persona->seguno_nombre}} {{$persona->primer_apellido}} {{$persona->segundo_apellido}}</td>
                    <td class="px-4 py-2 border-b border-gray-300">{{$persona->departamentoCargo->departamento->nombre}}</td>
                    <td class="px-4 py-2 border-b border-gray-300 grid grid-cols-3 w-48 gap-4">
                        <div>
                            {{$persona->departamentoCargo->cargo->nombre}}
                        </div>
                        <div>
                            @include('persona.partials.modalEditarPersona')
                        </div>
                        <div>
                            <!-- Botón para Cambiar Estado Activo -->
                            <button onclick="toggleActivo({{ $persona->id }})" 
                                class="flex p-2.5 {{ $persona->activo ? 'bg-green-500 hover:bg-green-700' : 'bg-red-500 hover:bg-red-700' }} rounded-xl hover:rounded-3xl transition-all duration-300 text-white">
                                <span class="material-symbols-outlined">
                                    {{ $persona->activo ? 'visibility' : 'visibility_off' }}
                                </span>
                            </button>
                        </div>
                    
                </td>

                </tr>
            @endforeach
        </tbody>
    </table>
</div>
