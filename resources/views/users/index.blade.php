@extends('layouts.dash')

@section('content')
<a href="{{route('users.create')}}">
<button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
    Crear Usuario
</button>
</a>

<div class="w-full mx-auto p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 md:p-8 dark:bg-gray-800 dark:border-gray-700 text-black dark:text-white">
    <h1 class="text-2xl font-bold mb-6 text-center">Usuarios Registrados</h1>

    @if (session('success'))
        <div class="mb-4">
            <div class="bg-green-100 text-green-700 p-4 rounded-lg">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <div class="overflow-x-auto">
        @include('users.partials.table')
    </div>

    <div class="mt-6">
        {{ $users->links() }} <!-- Paginación, si estás usando paginación en el controlador -->
    </div>
</div>

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

@endsection
