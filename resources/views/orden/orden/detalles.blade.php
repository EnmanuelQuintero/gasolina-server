@php
    $i = 1; // Contador de filas
    $total = 0; // Total de cantidad
@endphp

@extends('layouts.app')

@section('content')

<style>
    @media print {
    
    button 
    {
        display: none;
    }
    
    .no-print {
        display: none;
    }

    .pie_pagina 
    {
        bottom: 0;
    }

    .texto
    {
        width: 140px;
        text-align: start;
    }
    .xd
    {
        margin-left: 80px;
    }
    



}
.columna{
    border-top: 2px solid black;
    border-bottom: 2px solid black;
}

.super
{
    justify-content: space-between;
}

</style>
@php
 $suma =0;

@endphp
<div class="container  p-4 w-1/2 h-screen ">
        <div class="bg-white rounded-lg  dark:bg-gray-800 h-screen">
            <div class="flex super">
                <img class="rounded w-16 h-16" style="padding: 5px;" src="{{ asset('/images/logo.jpeg') }}" alt="Logo">
                <div class="text-center xd" >

                        <label class="text-md font-bold text-gray-900 ">Alcaldía Municipal de León</label><br>
                        <label class="text-md font-medium text-gray-900 ">Capital de la Revolución</label><br>
                        <label class="text-md font-medium text-gray-900 ">Orden de Retiro</label>

                </div>

                <img class="rounded w-20 h-20 float-end ml-16" style="padding: 5px;" src="{{ asset('/images/logo45_sf.png') }}" alt="Logo">

            </div>
            <div class="grid grid-cols-3 px-6 mt-5">
                <div class="w-96">
                    <p class=" text-sm"><strong>Numero de Orden:</strong> {{ $orden->id }}</p>
                    
                    <p class=" text-sm"><strong>Gasolinera:</strong> {{ $orden->gasolinera->nombre }}</p>

                </div>
                <div></div>
                <div class="abajo-45">
                    <div class="ml-28"><p class=" ml-2 text-xs"><strong class="ml-2">Fecha:</strong><br> {{ now()->format('d/m/y	 ') }}</p></div>
                    <div class=" ml-28"><div class="">{!!QrCode::size(60)->generate($orden->token) !!}</div></div>
                </div>

                

            </div>

            <!-- Página Actual -->
            <div class="page" >
                <div class="grid grid-cols-6 auto-rows-max text-center tabla mt-4 place-items-center h-full" >
                    <!-- Encabezado de la tabla -->
                    <div class="columna grid place-items-center justify-items-center w-full h-full  text-sm" style="border-left: 2px solid black;"><div class="encabezado font-bold"><p>#</p></div></div>
                    <div class="columna grid place-items-center justify-items-center  w-full h-full text-sm" style="border-left: 2px solid black;"><div class="encabezado font-bold"><p>Tipo de Vehículo</p></div></div>
                    <div class="columna grid place-items-center justify-items-center w-full h-full text-sm" style="border-left: 2px solid black;"><div class="encabezado font-bold"><p>Placa de Vehículo</p></div></div>
                    <div class="columna grid place-items-center justify-items-center w-full h-full text-xs" style="border-left: 2px solid black;"><div class="encabezado font-bold"><p>Tipo Combustible</p></div></div>
                    <div class="columna grid place-items-center justify-items-center w-full h-full text-sm" style="border-left: 2px solid black;"><div class="encabezado font-bold"><p>Cantidad</p></div></div>
                    <div class="columna grid place-items-center justify-items-center w-full h-full text-sm" style="border: 2px solid black;"><div class="encabezado font-bold"><p>Medida</p></div></div>

                    <!-- Contenido de la tabla -->
                    @foreach ($relacionDetalleOrden as $detalle)

                        <div class="columna grid place-items-center justify-items-center text-xs w-full h-full" style="border-left: 2px solid black; border-bottom:none;"><p>{{ $loop->iteration + ($relacionDetalleOrden->currentPage() - 1) * $relacionDetalleOrden->perPage() }}</p></div>
                        <div class="columna grid place-items-center justify-items-center text-xs w-full h-full" style="border-left: 2px solid black; border-bottom:none;"><p>{{ $detalle->detalleOrden->vehiculo->tipo }}</p></div>
                        <div class="columna grid place-items-center justify-items-center text-xs w-full h-full" style="border-left: 2px solid black; border-bottom:none;"><p>{{ $detalle->detalleOrden->vehiculo->placa }}</p></div>
                        <div class="columna grid place-items-center justify-items-center text-xs w-full h-full" style="border-left: 2px solid black; border-bottom:none;"><p>{{ $detalle->detalleOrden->combustible->nombre }}</p></div>
                        <div class="columna grid place-items-center justify-items-center text-xs w-full h-full" style="border-left: 2px solid black; border-bottom:none;"><p>{{ $detalle->detalleOrden->cantidad }}</p></div>
                        <div class="columna grid place-items-center justify-items-center text-xs w-full h-full" style="border: 2px solid black; border-bottom:none;"><p>{{ $detalle->detalleOrden->medida }}</p></div>
                        @php    
                            $suma += $detalle->detalleOrden->cantidad;
                            $medida = $detalle->detalleOrden->medida;
                        @endphp 
                    @endforeach
                </div>
                <div class="flex text-end justify-end  total ">
                    <p class="col-span-6 tx-total w-full h-full pr-2" style="border: 2px solid black;"><strong>Total:</strong> {{ $suma . ' '.$medida }}  </p>
                </div>

            </div>



                <div class="page-break"></div>



            

            <div class="pie_pagina bottom-0 absolute w-1/2">
                <div class="grid p-6 grid-cols-3 place-items-center gap-4 text-center mt-14 mr-8">
                                    
                    <div class=" w-full ">

                        <center>
                            <p class="border-solid border-2 border-gray-700 w-32"></p>
                            <p>Entregado por</p>
                        </center>
                                    
                    </div >

                    <div class="w-full flex items-start medio">

                        <center>
                                <p class="border-solid border-2 border-gray-700 w-32"></p>
                                <p>Autorizado por</p>
                            </center>
                    </div>

                    <div class=" w-full ">

                        <center>
                                <p class="border-solid border-2 border-gray-700 w-32"></p>
                                <p>Recibido por</p>
                            </center>
                    </div>
                        
                </div>

                    <div class="grid grid-cols-3 ">
                        <div></div>
                        <div class="w-full">
                            <img class="w-full mb-3" src="{{asset('/images/logo_pie.webp')}}" alt="">
                        </div>
                        <div></div>
                    </div>

                    @if($relacionDetalleOrden->lastPage() != 1)
                        <div class="absolute bottom-0 mr-8 right-0"><p class="text-xs ">Pagina {{$relacionDetalleOrden->currentPage()}} de {{$relacionDetalleOrden->lastPage();}}</p></div>
                    @endif
            </div>
            <!-- Paginación -->
            <div class="flex flex-col items-center mt-4 no-print">
                {{ $relacionDetalleOrden->links() }}
            </div>
            <div class="flex justify-end mt-4 absolute bottom-0 right-0">
                <button class="printbutton text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    Imprimir oden
                </button>
            </div>
            <div class="flex justify-end mt-4 absolute bottom-20 right-0">
                <a href="{{route('orden.index')}}">
                    <button class=" text-white bg-gradient-to-r from-red-500 via-red-600 to-red-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        regresar
                    </button>
                </a>

            </div>
        </div>
        
</div>
    <script>
        document.querySelectorAll('.printbutton').forEach(function(element) {
            element.addEventListener('click', function() {
                window.print();
            });
        });
    </script>
@endsection
