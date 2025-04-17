@extends('layouts.dash')

@section('content')
<div class="grid justify-items-center w-full px-4 sm:px-6 lg:px-8">
    <h1 class="text-2xl font-semibold mb-6 text-gray-800 dark:text-gray-100">{{$nombre_tabla}}</h1>
    <button onclick="openModal('createModal')" class="inline-flex items-center px-4 py-2 mb-4 text-sm font-medium text-white bg-blue-800 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        <i class="fas fa-plus-circle mr-1"></i> Agregar nuevo registro
    </button>

    @if(session('success'))
    <div class="mb-4 p-4 text-green-800 bg-green-200 rounded-lg dark:bg-green-800 dark:text-green-200" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div class="relative overflow-x-auto shadow-lg w-full sm:rounded-lg">
        <table class="min-w-full table-auto text-sm text-left text-gray-700 dark:text-gray-300">
            <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-800 dark:text-gray-300">
                <tr>
                    <th scope="col" class="px-6 py-4">Nombre</th>
                    @if ($nombre_tabla == "Gasolineras")
                        <th scope="col" class="px-6 py-4">Dirección</th>
                    @endif
                    <th scope="col" class="px-6 py-4 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($datos as $dato)
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-100">
                            {{ $dato->nombre }}
                        </td>
                        @if ($nombre_tabla == "Gasolineras")
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-gray-100">
                            {{ $dato->direccion }}
                        </td>
                        @endif
                        <td class="px-6 py-4 flex flex-col sm:flex-row gap-3 justify-center">
                            <button onclick="openModal('editModal', '{{ $dato->id }}', '{{ $dato->nombre }}', '{{$dato->direccion}}')" class="rounded-lg bg-blue-600 py-2 px-4 font-sans text-xs font-bold text-white shadow transition-all hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Editar</button>

                            @if($dato->activo)
                                <form action="{{ str_replace('dummy', $dato->id, $ruta_estado) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rounded-lg bg-red-600 py-2 px-4 font-sans text-xs font-bold text-white shadow transition-all hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">Desactivar</button>
                                </form>
                            @else
                                <form action="{{ str_replace('dummy', $dato->id, $ruta_estado) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="rounded-lg bg-green-600 py-2 px-4 font-sans text-xs font-bold text-white shadow transition-all hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">Activar</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Fondo oscuro -->
<div id="overlay" class="fixed inset-0 bg-black opacity-50 hidden z-50"></div>

<!-- Modal Crear -->
<div id="createModal" class="hidden fixed inset-0 z-50 overflow-y-auto flex items-center justify-center w-full h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    Crear registro de {{$nombre_tabla}}
                </h3>
                <button type="button" onclick="closeModal('createModal')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <div class="p-4">
                <form action="{{$ruta_store }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    @if ($nombre_tabla == "Gasolineras")
                        <div class="mb-4">
                            <label for="direccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Dirección</label>
                            <input type="text" id="direccion" name="direccion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                    @endif
                    <button type="submit" class="w-full text-white bg-blue-800 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-500">
                        Crear
                    </button>
                    <button type="button" onclick="closeModal('createModal')" class="mt-2 w-full text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-500">
                        Cancelar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Editar -->
<div id="editModal" class="hidden fixed inset-0 z-50 overflow-y-auto flex items-center justify-center w-full h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-800">
            <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    Editar {{$nombre_tabla}}
                </h3>
                <button type="button" onclick="closeModal('editModal')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Cerrar modal</span>
                </button>
            </div>
            <div class="p-4">
                <form id="editForm" action="#" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="editNombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Nombre</label>
                        <input type="text" id="editNombre" name="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                    </div>
                    @if ($nombre_tabla == "Gasolineras")
                        <div class="mb-4">
                            <label for="editDireccion" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-100">Dirección</label>
                            <input type="text" id="editDireccion" name="direccion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required>
                        </div>
                    @endif
                    <button type="submit" class="w-full text-white bg-blue-800 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-700 dark:hover:bg-blue-600 dark:focus:ring-blue-500">
                        Guardar cambios
                    </button>
                    <button type="button" onclick="closeModal('editModal')" class="mt-2 w-full text-white bg-gray-600 hover:bg-gray-500 focus:ring-4 focus:outline-none focus:ring-gray-400 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-700 dark:hover:bg-gray-600 dark:focus:ring-gray-500">
                        Cancelar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function openModal(modalId, id = '', nombre = '', direccion = '') {
    const modal = document.getElementById(modalId);
    const overlay = document.getElementById('overlay');
    if (modal) {
        modal.classList.remove('hidden');
        overlay.classList.remove('hidden');
        if (modalId === 'editModal') {
            document.getElementById('editForm').action = `{{ str_replace('dummy', '', $ruta_editar) }}${id}`;
            document.getElementById('editNombre').value = nombre;
            document.getElementById('editDireccion').value = direccion;
        }
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    const overlay = document.getElementById('overlay');
    if (modal) {
        modal.classList.add('hidden');
        overlay.classList.add('hidden');
    }
}

</script>

@endsection
