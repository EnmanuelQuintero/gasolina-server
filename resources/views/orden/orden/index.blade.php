@extends('layouts.dash')

@section('content')
<div class="relative overflow-x-auto shadow-md sm:rounded-lg px-4 h-screen">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2 md:gap-0 bg-white dark:bg-gray-900 justify-items-center md:justify-items-start p-4 md:px-0 w-auto">
    <a href="{{ route('orden.create') }}" class="w-full md:w-auto text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" data-popover-target="popover-crear-orden" type="button">
        Crear Nueva Orden
    </a>

    <div data-popover id="popover-crear-orden" role="tooltip" class="absolute z-10 invisible inline-block w-64 text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:border-gray-600 dark:bg-gray-800">
        <div class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
            <h3 class="font-semibold text-gray-900 dark:text-white">Crear Nueva Orden</h3>
        </div>
        <div class="px-3 py-2">
            <p>Haz clic aquí para crear una nueva orden.</p>
        </div>
        <div data-popper-arrow></div>
    </div>

        

        <form action="{{ route('orden.index') }}" method="GET" class="flex justify-end md:flex-row gap-3 w-full md:w-auto">
            <label for="table-search" class="sr-only">Buscar</label>
            <div class="relative w-full">
                <input type="text" name="search" id="table-search" value="{{ request('search') }}" class="block w-full md:w-48 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Buscar por token">
            </div>
            <button type="submit" class="w-full md:w-auto px-4 py-2 bg-blue-500 text-white rounded-lg">Buscar</button>
        </form>
    </div>
    
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 text-center">
            {{ session('success') }}
        </div>
    @endif
    
    @if ($ordenes->count())
        <div class="overflow-x-auto mt-6 flex justify-center ">
            @include('orden.partials.tabla')
        </div>
    @else
        <div class="text-center text-gray-500 dark:text-gray-400 mt-4">No se encontraron órdenes.</div>
    @endif
</div>
@endsection

@section('scripts')
    <script src="{{ asset('/js/imprimir_orden.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@9.0.3"></script>
<script>
    
    if (document.getElementById("filter-table") && typeof simpleDatatables.DataTable !== 'undefined') {
    const dataTable = new simpleDatatables.DataTable("#filter-table", {
        tableRender: (_data, table, type) => {
            if (type === "print") {
                return table;
            }

            const tHead = table.childNodes[0];
            const filterHeaders = {
                nodeName: "TR",
                attributes: {
                    class: "search-filtering-row"
                },
                childNodes: tHead.childNodes[0].childNodes.map((_th, index) => {
                    // Excluir el tercer input (índice 2)
                    if (index === 3) {
                        return { nodeName: "TH", childNodes: [] }; // Retorna vacío para el tercer input
                    }

                    return {
                        nodeName: "TH",
                        childNodes: [
                            {
                                nodeName: "INPUT",
                                attributes: {
                                    class: "datatable-input",
                                    type: "search",
                                    "data-columns": "[" + index + "]"
                                }
                            }
                        ]
                    };
                })
            };

            // Insertar los filtros en el encabezado
            tHead.childNodes.push(filterHeaders);
            return table;
        }
    });
}


</script>

@endsection
