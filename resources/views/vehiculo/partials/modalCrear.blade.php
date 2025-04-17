<div class="relative inline-block text-left group">
    <button onclick="openModal('createModal')" class="w-full flex gap-4 text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
        <span class="material-symbols-outlined">add</span>
        Agregar Marca Modelo de Vehiculo
    </button>
    <div class="absolute left-1/2 transform -translate-x-1/2 z-10 hidden mt-2 w-48 rounded-md shadow-lg text-xs bg-transparent dark:text-white text-black p-2 group-hover:block">
        crea un nuevo registro de Marca o agrega un nuevo modelo de vehiculo.
    </div>
</div>



<!-- Modal Crear -->
<div id="createModal" class="hidden fixed inset-0 z-50 overflow-y-auto flex items-center justify-center w-full h-auto bg-black bg-opacity-50">
    <div class="relative p-4 w-full max-w-md h-auto">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Agregar modelo de Vehiculo
                </h3>
                <button type="button" onclick="closeModal('createModal')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <div class="p-4 md:p-5">
                <!-- Pestañas dentro del modal -->
                <div class="mb-4">
                    <ul class="flex border-b">
                        <li class="mr-1">
                            <button onclick="openTab(event, 'crearTab')" class="inline-block p-4 text-gray-600 dark:text-white hover:text-blue-600 focus:outline-none" type="button">Agregar Nueva Marca</button>
                        </li>
                        <li class="mr-1">
                            <button onclick="openTab(event, 'verTab')" class="inline-block p-4 text-gray-600 dark:text-white hover:text-blue-600 focus:outline-none" type="button">Agregar un Nuevo Modelo</button>
                        </li>
                    </ul>
                </div>

                <!-- Formulario para agregar nueva marca -->
                <div id="crearTab" class="tabcontent hidden">
                    <form action="{{ route('marcas-vehiculos.store') }}" method="POST">
                        @csrf
                        <h4 class="text-lg text-center m-6 font-semibold dark:text-white text-black">Agregar Nueva Marca</h4>
                        <div class="mb-4">
                            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nombre</label>
                            <input type="text" id="nombre" name="nombre" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Agregar nueva marca
                        </button>
                        <button type="button" onclick="closeModal('createModal')" class="mt-2 w-full text-white bg-red-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            Cancelar
                        </button>
                    </form>
                </div>

                <!-- Formulario para agregar un nuevo modelo -->
                <div id="verTab" class="tabcontent hidden">
                    
                    <h4 class="text-lg text-center m-6 font-semibold dark:text-white text-black">Agregar Modelo</h4>
                    <form action="{{ route('modelos-vehiculos.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5 mb-5">
                            <div>
                                <select name="marca_id" id="marcas" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @foreach ($marcas as $marca)
                                        <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <input type="text" id="modelo" name="modelo" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                            </div>
                        </div>
                        <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Agregar nuevo Modelo
                        </button>
                        <button type="button" onclick="closeModal('createModal')" class="mt-2 w-full text-white bg-red-500 hover:bg-gray-600 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-gray-600 dark:hover:bg-gray-700 dark:focus:ring-gray-800">
                            Cancelar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')

<script>
    function openTab(evt, tabName) {
        // Ocultar todas las pestañas
        var tabcontent = document.getElementsByClassName("tabcontent");
        for (var i = 0; i < tabcontent.length; i++) {
            tabcontent[i].classList.add('hidden');
        }

        // Mostrar la pestaña activa
        document.getElementById(tabName).classList.remove('hidden');
    }

    function openModal(modalId) {
        document.getElementById(modalId).classList.remove('hidden');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>
<script>
        // Función para abrir el modal
        function openModalVehiculo() {
            document.getElementById('vehicleModal').classList.remove('invisible');
        }

        // Función para cerrar el modal
        function closeModalVehiculo() {
            document.getElementById('vehicleModal').classList.add('invisible');
        }

    </script>

<script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
<script>
    
if (document.getElementById("filter-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    const dataTable = new simpleDatatables.DataTable("#filter-table", {
        tableRender: (_data, table, type) => {
            if (type === "print") {
                return table
            }
            const tHead = table.childNodes[0]
            const filterHeaders = {
                nodeName: "TR",
                attributes: {
                    class: "search-filtering-row"
                },
                childNodes: tHead.childNodes[0].childNodes.map(
                    (_th, index) => ({nodeName: "TH",
                        childNodes: [
                            {
                                nodeName: "INPUT",
                                attributes: {
                                    class: "datatable-input",
                                    type: "search",
                                    "data-columns": "[" + index + "]"
                                }
                            }
                        ]})
                )
            }
            tHead.childNodes.push(filterHeaders)
            return table
        }
    });
}

</script>


<script>
function openModalEditVehiculo(id) {
    fetch(`/catalogo-vehiculos/${id}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(vehiculo => {
            // Rellena los campos del modal con los datos del vehículo
            document.getElementById('edit_vehiculo_id').value = vehiculo.id; // ID corregido
            document.getElementById('edit_tipo').value = vehiculo.tipo; // Tipo corregido
            document.getElementById('edit_relacion_marca_modelo_id').value = vehiculo.relacion_marca_modelo_id; // Marca-Modelo corregido
            document.getElementById('edit_color').value = vehiculo.color; // Color corregido
            document.getElementById('edit_placa').value = vehiculo.placa; // Placa corregido
            document.getElementById('edit_activo').checked = vehiculo.activo == 1; // Checkbox

            // Muestra el modal
            document.getElementById('editVehicleModal').classList.remove('invisible');
        })
        .catch(error => console.error('Error:', error)); // Maneja errores
}
// Función para cerrar el modal
function closeModalEditVehiculo() {
    // Oculta el modal
    document.getElementById('editVehicleModal').classList.add('invisible');
}
</script>

<script>
    function toggleActivo(vehiculoId) {
    if (confirm('¿Estás seguro de que quieres cambiar el estado de este vehículo?')) {
        fetch(`/vehiculos/${vehiculoId}/toggle-activo`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Asegúrate de incluir el token CSRF
            },
            body: JSON.stringify({}),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualiza el estado en la vista o recarga la página
                location.reload(); // Recarga la página para reflejar el cambio
            } else {
                alert('Hubo un problema al cambiar el estado.');
            }
        })
        .catch(error => console.error('Error:', error));
    }
}

</script>
@endsection